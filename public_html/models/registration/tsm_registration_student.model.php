<?php

class TSM_REGISTRATION_STUDENT extends TSM_REGISTRATION_CAMPUS {

  private $info;
  private $enrolledPrograms;
  private $approved;
  private $useRecordedFees = true;

  public function __construct($studentId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($studentId)) {
      if ($this->hasPermission($studentId)) {
        $this->studentId = $studentId;
        $this->getInfo();
      } else {
        die("No Permission");
      }
    }
  }

  public function hasPermission($student_id) {
    if (isset($this->tsm->adminUser)) {
      if ($this->tsm->adminUser->isLoggedIn()) {
        return true;
      } else {
        return false;
      }
    } else {
      $family = new TSM_REGISTRATION_FAMILY();
      if ($family->isLoggedIn()) {
        $q = "SELECT student_id FROM tsm_reg_students WHERE student_id = '".$student_id."' AND family_id = '".$family->getFamilyId()."'";
        $r = $this->db->runQuery($q);
        if (mysql_num_rows($r) == 1) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_students WHERE student_id = ".$this->studentId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function isFirstYear() {
    $q = "SELECT * FROM tsm_reg_students_school_years WHERE student_id = '".$this->studentId."' AND school_year = '".$this->getSelectedSchoolYear()."'";
    $r = $this->db->runQuery($q);
    $result = false;
    while ($a = mysql_fetch_assoc($r)) {
      if ($a['first_year'] == 1) {
        $result = true;
      }
    }

    return $result;
  }

  public function addToSchoolYear($school_year) {
    $q = "SELECT student_id FROM tsm_reg_students_school_years WHERE student_id = '".$this->studentId."' AND school_year = '".$school_year."'";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      $q = "INSERT INTO tsm_reg_students_school_years (student_id,school_year) VALUES('".$this->studentId."','".$school_year."')";
      $this->db->runQuery($q);
      return true;
    }
  }

  public function isApproved() {
    if (!isset($this->isApproved)) {
      $q = "SELECT approved FROM tsm_reg_students_school_years WHERE student_id = '".$this->studentId."' AND school_year = '".$this->getSelectedSchoolYear()."'";
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->isApproved = $a['approved'];
      }
    }

    return $this->isApproved;
  }

  public function inProgram($program_id) {
    $q = "SELECT * FROM tsm_reg_student_program WHERE student_id = '".$this->studentId."' AND program_id = '".$program_id."'";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function inCourse($course_id) {
    $q = "SELECT * FROM tsm_reg_student_course WHERE student_id = '".$this->studentId."' AND course_id = '".$course_id."'";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function getEnrolledPrograms() {
    $q = "SELECT * FROM tsm_reg_student_program sp, tsm_reg_programs p WHERE p.program_id = sp.program_id AND sp.student_id = ".$this->studentId." AND p.school_year = ".$this->getSelectedSchoolYear()."";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $this->enrolledPrograms[$a['program_id']] = $a;
    }

    return $this->enrolledPrograms;
  }

  public function meetsRequirements() {
    $studentEligible = true;
    if (isset($requirements)) {
      foreach ($requirements as $requirement) {
        $requirementObject = new TSM_REGISTRATION_REQUIREMENT($requirement['requirement_id']);
        $studentMeetsRequirement = $requirementObject->studentMeetsRequirement($this);
        if ($studentMeetsRequirement == false) {
          $studentEligible = false;
        }
      }
    }

    return $studentEligible;
  }

  public function getEligibleCoursesForProgram($program_id) {
    $program = new TSM_REGISTRATION_PROGRAM($program_id);
    $eligibleCourses = null;
    $allCourses = $program->getCourses();
    if (isset($allCourses)) {
      foreach ($allCourses as $course) {
        $courseObject = new TSM_REGISTRATION_COURSE($course['course_id']);
        $requirements = $courseObject->getRequirements();
        $studentEligible = $this->meetsRequirements($requirements);

        if ($studentEligible == true && $this->inCourse($course['course_id']) == false) {
          $eligibleCourses[$course['course_id']] = $course;
        }
      }
    }

    return $eligibleCourses;
  }

  public function meetsConditions($feeConditions, $params = null) {
    $studentEligible = true;
    if (isset($feeConditions)) {
      foreach ($feeConditions as $feeCondition) {
        $feeConditionObject = new TSM_REGISTRATION_FEE_CONDITION($feeCondition['fee_condition_id']);
        $studentMeetsFeeCondition = $feeConditionObject->studentMeetsFeeCondition($this, $params);
        if ($studentMeetsFeeCondition == false) {
          $studentEligible = false;
        }
      }
    }

    return $studentEligible;
  }

  public function getUseRecordedFees() {
    return $this->useRecordedFees;
  }

  public function setUseRecordedFees($setTo) {
    $this->useRecordedFees = $setTo;

    return $this->useRecordedFees;
  }

  public function getFeesForCourse($course_id, $program_id, $fee_type_id = null) {
    $course = new TSM_REGISTRATION_COURSE($course_id);
    $eligibleFees = null;
    if ($this->getUseRecordedFees() == false) {
      $fees = $course->getFees($program_id, $fee_type_id);

      if (isset($fees)) {
        foreach ($fees as $fee) {
          $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
          $feeConditions = $feeObject->getConditionsForCourse($course_id, $program_id);
          $params = Array('course_id' => $course_id, 'program_id' => $program_id);
          $studentEligible = $this->meetsConditions($feeConditions, $params);
          $fee['program_id'] = $program_id;

          if ($studentEligible == true) {
            //$eligibleFees[$fee['fee_id']] = $fee;
            $eligibleFees[] = $fee;
          }
        }
      }

      $fees = $course->getFees(null, $fee_type_id);
      if (isset($fees)) {
        foreach ($fees as $fee) {
          $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
          $feeConditions = $feeObject->getConditionsForCourse($course_id, null);
          $params = Array('course_id' => $course_id, 'program_id' => $program_id);
          $studentEligible = $this->meetsConditions($feeConditions, $params);
          $fee['program_id'] = $program_id;

          if ($studentEligible == true) {
            //$eligibleFees[$fee['fee_id']] = $fee;s
            $eligibleFees[] = $fee;
          }
        }
      }
    } else {
      //get course specific fees
      $q = "SELECT * FROM tsm_reg_families_fees WHERE student_id = ".$this->studentId." AND course_id = '".$course_id."' AND program_id IS NULL AND school_year = '".$this->getSelectedSchoolYear()."'";
      if ($fee_type_id != null) {
        $q .= " AND fee_type_id = '$fee_type_id'";
      }
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $eligibleFees[] = $a;
      }

      //get fees assigned to course AND program
      $q = "SELECT * FROM tsm_reg_families_fees WHERE student_id = ".$this->studentId." AND course_id = '".$course_id."' AND program_id = '".$program_id."' AND school_year = '".$this->getSelectedSchoolYear()."'";
      if ($fee_type_id != null) {
        $q .= " AND fee_type_id = '$fee_type_id'";
      }
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $eligibleFees[] = $a;
      }
    }

    return $eligibleFees;
  }

  public function getRegistrationDate($program_id) {
    $regDate = null;
    $q = "SELECT registration_date FROM tsm_reg_student_program WHERE student_id = ".$this->studentId." AND program_id = '".$program_id."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $regDate = $a['registration_date'];
    }

    return $regDate;
  }

  public function getFees($fee_type_id = null) {
    $programs = $this->getEnrolledPrograms();
    $eligibleFees = null;
    if (isset($programs)) {
      foreach ($programs as $program) {
        $fees = $this->getFeesForProgramAndCourses($program['program_id'], $fee_type_id);
        if (isset($fees)) {
          foreach ($fees as $fee) {
            //$eligibleFees[$fee['fee_id']] = $fee;
            $eligibleFees[] = $fee;
          }
        }
      }
    }

    return $eligibleFees;
  }

  public function approve() {
    //if($this->getUseRecordedFees() == false){
    /*
      $q = "DELETE FROM tsm_reg_families_fees WHERE student_id = '".$this->studentId."' AND school_year = '".$this->getSelectedSchoolYear()."'";
      $this->db->runQuery($q);

      $programs = $this->getEnrolledPrograms();
      $eligibleFees = null;
      if(isset($programs)){
        foreach($programs as $program){
          $fees = $this->getFeesForProgramAndCourses($program['program_id'],null);
          if(isset($fees)){
            foreach($fees as $fee){
              if(!isset($fee['course_id'])){
                $course_id = "NULL";
              } else {
                $course_id = $fee['course_id'];
              }
              $q = "INSERT INTO tsm_reg_families_fees (student_id,program_id,course_id,fee_id,name,fee_type_id,amount,school_year) VALUES ('".$this->studentId."','".$program['program_id']."',".$course_id.",'".$fee['fee_id']."','".$fee['name']."','".$fee['fee_type_id']."','".$fee['amount']."','".$fee['school_year']."');";
              $this->db->runQuery($q);
            }
          }
        }
      }
      */
    $q = "UPDATE tsm_reg_students_school_years SET approved = 1 WHERE student_id = '".$this->studentId."' AND school_year = '".$this->getSelectedSchoolYear()."'";
    $this->db->runQuery($q);

    $this->isApproved = true;

    //} else {
    //	return false;
    //}
    return true;
  }

  public function getLatestProgram() {
    $q = "SELECT sp.program_id FROM tsm_reg_students s, tsm_reg_student_program sp, tsm_reg_programs p WHERE sp.program_id = p.program_id AND sp.student_id = s.student_id AND p.school_year = '".$this->getSelectedSchoolYear()."' ORDER BY sp.registration_date DESC LIMIT 1";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $program_id = $a['program_id'];
    }

    return $program_id;
  }

  public function saveStudent() {
    $student_id = $this->db->updateRowFromPost("tsm_reg_students", $this->studentId);
    if ($student_id) {
      return $student_id;
    } else {
      //THERE WAS AN ERROR INSERTING THE ROW
      die("uhoh");
    }
  }

  public function getFeesForProgramAndCourses($program_id, $fee_type_id = null) {
    $eligibleFees = null;
    if ($this->getUseRecordedFees() == false) {
      $program = new TSM_REGISTRATION_PROGRAM($program_id);

      $fees = $program->getFees($fee_type_id);
      if (isset($fees)) {
        foreach ($fees as $fee) {
          $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
          $feeConditions = $feeObject->getConditionsForProgram($program_id);
          $params = Array('program_id' => $program_id);
          $studentEligible = $this->meetsConditions($feeConditions, $params);

          if ($studentEligible == true) {
            //$eligibleFees[$fee['fee_id']] = $fee;
            $eligibleFees[] = $fee;
          }
        }
      }

      $courses = $this->getCoursesIn($program_id);
      if (isset($courses)) {
        foreach ($courses as $course) {
          $fees = $this->getFeesForCourse($course['course_id'], $program_id, $fee_type_id);
          if (isset($fees)) {
            foreach ($fees as $fee) {
              //don't need to process conditions in here because they are already processed in getFeesForCourse.
              //$eligibleFees[$fee['fee_id']] = $fee;
              $eligibleFees[] = $fee;
            }
          }
        }
      }
    } else {
      //get fees for program, but not courses
      $q = "SELECT * FROM tsm_reg_families_fees WHERE student_id = ".$this->studentId." AND program_id = '".$program_id."' AND course_id IS NULL AND school_year = '".$this->getSelectedSchoolYear()."'";
      if ($fee_type_id != null) {
        $q .= " AND fee_type_id = '$fee_type_id'";
      }
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $eligibleFees[] = $a;
      }

      $courses = $this->getCoursesIn($program_id);
      if (isset($courses)) {
        foreach ($courses as $course) {
          $fees = $this->getFeesForCourse($course['course_id'], $program_id, $fee_type_id);
          if (isset($fees)) {
            foreach ($fees as $fee) {
              //don't need to process conditions in here because they are already processed in getFeesForCourse.
              //$eligibleFees[$fee['fee_id']] = $fee;
              $eligibleFees[] = $fee;
            }
          }
        }
      }

    }

    return $eligibleFees;
  }

  public function getSpotInFamily() {
    $q = "SELECT * FROM tsm_reg_students s, tsm_reg_students_school_years ssy WHERE ssy.student_id = s.student_id AND s.family_id = '".$this->info['family_id']."' ORDER BY student_school_year_id";
    $r = $this->db->runQuery($q);
    $i = 1;
    while ($a = mysql_fetch_assoc($r)) {
      if ($a['student_id'] == $this->studentId) {
        $spotInFamily = $i;
      }
      $i++;
    }

    return $spotInFamily;
  }

  public function getSpotInFamilyInProgram($program_id) {
    $q = "SELECT sp.student_id FROM tsm_reg_student_program sp, tsm_reg_students s
    WHERE s.student_id = sp.student_id
    AND s.family_id = '".$this->info['family_id']."'
    AND sp.program_id = '$program_id'
    ORDER BY sp.student_program_id DESC";
    $r = $this->db->runQuery($q);
    $i = 1;
    while ($a = mysql_fetch_assoc($r)) {
      if ($a['student_id'] == $this->studentId) {
        $spotInFamily = $i;
      }
      $i++;
    }

    return $spotInFamily;
  }

  public function getCampusId() {
    return $this->info['campus_id'];
  }

  public function getEligiblePrograms() {
    $campus = new TSM_REGISTRATION_CAMPUS($this->getCampusId());
    $eligiblePrograms = null;
    $allPrograms = $campus->getPrograms();
    if (isset($allPrograms)) {
      foreach ($allPrograms as $program) {
        $programObject = new TSM_REGISTRATION_PROGRAM($program['program_id']);
        $requirements = $programObject->getRequirements();
        $studentEligible = $this->meetsRequirements($requirements);

        if ($studentEligible == true && $this->inProgram($program['program_id']) == false) {
          $eligiblePrograms[$program['program_id']] = $program;
        }
      }
    }

    return $eligiblePrograms;
  }

  public function getCoursesIn($program_id) {
    $q = "SELECT sc.*, c.*, p.*, CONCAT(t.first_name,' ',t.last_name) AS teacher_name
  	FROM tsm_reg_student_course sc, tsm_reg_courses c, tsm_reg_periods p, tsm_reg_teachers t, tsm_reg_course_period cp 
  	WHERE t.teacher_id = cp.teacher_id 
  	AND sc.course_period_id = cp.course_period_id 
  	AND c.course_id = cp.course_id 
  	AND cp.period_id = p.period_id 
  	AND sc.program_id = '$program_id' 
  	AND sc.student_id = '".$this->studentId."' 
  	ORDER BY day, start_time";
    $r = $this->db->runQuery($q);
    $courses = null;
    while ($a = mysql_fetch_assoc($r)) {
      $courses[$a['course_id']] = $a;
    }

    return $courses;
  }

  public function enrollInCourse($course_id, $program_id, $course_period_id) {
    if ($this->inCourse($course_id) == false) {

      $q = "INSERT INTO tsm_reg_student_course (student_id,course_id,program_id,course_period_id) VALUES('".$this->studentId."','".$course_id."','".$program_id."','".$course_period_id."')";
      $this->db->runQuery($q);

      /*
      $this->setUseRecordedFees(false);
      $fees = $this->getFeesForCourse($course_id, $program_id, null);
      $this->setUseRecordedFees(true);
      if (isset($fees)) {
        foreach ($fees as $fee) {
          $this->assignFee($fee['fee_id'],$program_id,$course_id);
        }
      }
      */

      $this->processFees();

      return true;
    } else {
      return false;
    }
  }

  public function assignedFee($fee_id, $program_id, $course_id) {
    $q = "SELECT * FROM tsm_reg_families_fees WHERE student_id = '".$this->studentId."'
    AND fee_id = '".$fee_id."'";
    if (!$course_id) {
      $q .= " AND course_id IS NULL";
    } else {
      $q .= " AND course_id = '$course_id'";
    }
    if (!$program_id) {
      $q .= " AND program_id IS NULL";
    } else {
      $q .= " AND program_id = '$program_id'";
    }

    $r = $this->db->runQuery($q);

    if (mysql_num_rows($r) > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function assignFee($fee_id, $program_id, $course_id) {
    if (!$this->assignedFee($fee_id, $program_id, $course_id)) {
      $feeObject = new TSM_REGISTRATION_FEE($fee_id);
      $feeInfo = $feeObject->getInfo();
      if ($course_id == null) {
        $course_id = "NULL";
      }
      if ($program_id == null) {
        $program_id = "NULL";
      }

      $q = "INSERT INTO tsm_reg_families_fees (family_id,student_id,program_id,course_id,fee_id,name,fee_type_id,amount,school_year) VALUES ('".$this->info['family_id']."','".$this->studentId."',".$program_id.",".$course_id.",'".$fee_id."','".$feeInfo['name']."','".$feeInfo['fee_type_id']."','".$feeInfo['amount']."','".$this->getSelectedSchoolYear()."');";
      $this->db->runQuery($q);

      return true;
    } else {
      return false;
    }
  }

  public function processFees() {
    $this->setUseRecordedFees(false);
    $fees = $this->getFees();
    $this->setUseRecordedFees(true);
    foreach ($fees as $fee) {
      if (!isset($fee['course_id'])) {
        $fee['course_id'] = null;
      }
      if (!isset($fee['program_id'])) {
        $fee['program_id'] = null;
      }

      if (!$this->assignedFee($fee['fee_id'], $fee['program_id'], $fee['course_id'])) {
        $addFees[] = $fee;
      }

    }

    if (isset($addFees)) {
      foreach ($addFees as $fee) {
        $this->assignFee($fee['fee_id'], $fee['program_id'], $fee['course_id']);
      }

    }

    return true;
  }

  public function enrollInProgram($program_id) {
    if ($this->inProgram($program_id) == false) {
      $q = "INSERT INTO tsm_reg_student_program (student_id,program_id) VALUES('".$this->studentId."','".$program_id."')";
      $this->db->runQuery($q);

      /*
      $this->setUseRecordedFees(false);
      $fees = $this->getFeesForProgramAndCourses($program_id, null);
      $this->setUseRecordedFees(true);
      if (isset($fees)) {
        foreach ($fees as $fee) {
          $this->assignFee($fee['fee_id'],$program_id,null);
        }
      }
      */

      $this->processFees();


      return true;
    } else {
      return false;
    }
  }

  public function getAllCourses() {
    $q = "SELECT * FROM tsm_reg_student_course sc, tsm_reg_courses c, tsm_reg_periods p WHERE c.course_id = sc.course_id AND p.period_id = sc.period_id AND sc.student_id = '".$this->studentId."' ORDER BY day, start_time";
    $r = $this->db->runQuery($q);
    $courses = null;
    while ($a = mysql_fetch_assoc($r)) {
      $courses[$a['course_id']] = $a;
    }

    return $courses;
  }

}

?>