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
        $this->studentId = intval($studentId);
        $this->getInfo();
      } else {
        throw new Exception('TSM_REGISTRATION_STUDENT: no permission');
      }
    }
  }

  public function hasPermission($student_id) {
    if ($this->tsm->adminUser->isLoggedIn()) {
      return true;
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
      $q = "SELECT * FROM tsm_reg_students WHERE student_id = '".$this->studentId."'";
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function getAge() {
    $dt = strtotime($this->info['birth_date']);
    $a = gmdate('Y') - gmdate('Y', $dt);

    return $a; // return the age.
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

  public function setFirstYear($first_year) {
    $q = "UPDATE tsm_reg_students_school_years SET first_year = '$first_year' WHERE student_id = '".$this->studentId."' AND school_year = '".$this->getSelectedSchoolYear()."'";
    $this->db->runQuery($q);

    return true;
  }

  public function getFirstYear() {
    $q = "SELECT first_year FROM tsm_reg_students_school_years WHERE student_id = '".$this->studentId."' AND school_year = '".$this->getSelectedSchoolYear()."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $first_year = $a['first_year'];
    }

    return $first_year;
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

	public function inAProgram(){
		$q = "SELECT * FROM tsm_reg_student_program sp, tsm_reg_programs p WHERE sp.student_id = '".$this->studentId."' AND sp.program_id = p.program_id AND p.school_year = '".$this->getSelectedSchoolYear()."'";
		$r = $this->db->runQuery($q);
		if (mysql_num_rows($r) > 0) {
			return true;
		} else {
			return false;
		}
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

  public function changePeriodForCourse($course_id, $program_id, $course_period_id, $new_course_period_id) {
    $q = "UPDATE tsm_reg_student_course SET course_period_id = '$new_course_period_id' WHERE course_period_id = '$course_period_id' AND student_id = '".$this->studentId."' AND course_id = '$course_id' AND program_id = '$program_id'";
    $this->db->runQuery($q);

    return true;
  }

  public function getEnrolledPrograms() {
    $q = "SELECT * FROM tsm_reg_student_program sp, tsm_reg_programs p WHERE p.program_id = sp.program_id AND sp.student_id = ".$this->studentId." AND p.school_year = ".$this->getSelectedSchoolYear()."";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $this->enrolledPrograms[$a['program_id']] = $a;
    }

    return $this->enrolledPrograms;
  }

  public function meetsRequirements($requirements) {
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
          $params = Array('course_id' => $course_id, 'program_id' => $program_id, 'fee' => $fee);
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
          $params = Array('course_id' => $course_id, 'program_id' => $program_id, 'fee' => $fee);
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
      $q = "SELECT * FROM tsm_reg_families_fees WHERE student_id = ".$this->studentId."
      AND course_id = '".$course_id."' AND program_id IS NULL
      AND school_year = '".$this->getSelectedSchoolYear()."'";
      if ($fee_type_id != null) {
        $q .= " AND fee_type_id = '$fee_type_id'";
      }
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $eligibleFees[] = $a;
      }

      //get fees assigned to course AND program
      $q = "SELECT * FROM tsm_reg_families_fees WHERE student_id = ".$this->studentId."
      AND course_id = '".$course_id."'
      AND program_id = '".$program_id."'
      AND school_year = '".$this->getSelectedSchoolYear()."'";
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
    if ($regDate == null) {
      $q = "SELECT registration_time FROM tsm_reg_students_school_years WHERE student_id = '".$this->studentId."' AND school_year = '".$this->getSelectedSchoolYear()."'";
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $regDate = $a['registration_time'];
      }
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


    if($this->getUseRecordedFees() == true){
      $q = "SELECT * FROM tsm_reg_families_fees WHERE student_id = '".$this->studentId."' AND (program_id IS NOT NULL or course_id IS NOT NULL)";
      if($fee_type_id != null){
        $q .= " AND fee_type_id = ".$fee_type_id;
      }
      if(isset($eligibleFees)){
        $q .= " AND (";
        //print_r($eligibleFees);die();
        foreach($eligibleFees as $fee){
          $q .= " family_fee_id != ".$fee['family_fee_id']." AND ";
        }
        $q = substr($q, 0, -5);
        $q .= ")";
      }


      $r = $this->db->runQuery($q);
      while($a = mysql_fetch_assoc($r)){
        $eligibleFees[] = $a;
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
          $params = Array('program_id' => $program_id, 'fee' => $fee);
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
      $q = "SELECT * FROM tsm_reg_families_fees WHERE student_id = ".$this->studentId."
      AND program_id = '".$program_id."'
      AND course_id IS NULL
      AND school_year = '".$this->getSelectedSchoolYear()."'";
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
    $q = "SELECT * FROM tsm_reg_students s, tsm_reg_students_school_years ssy
    WHERE ssy.student_id = s.student_id
    AND s.family_id = '".$this->info['family_id']."'
    ORDER BY student_school_year_id";
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
    ORDER BY sp.student_program_id ASC";
    $r = $this->db->runQuery($q);
    $i = 1;
    while ($a = mysql_fetch_assoc($r)) {
      if ($a['student_id'] == $this->studentId) {
        $spotInFamily = $i;
      }
      $i++;
    }

    if (!isset($spotInFamily)) {
      $spotInFamily = $i;
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

      $q = "INSERT INTO tsm_reg_student_log (student_id,program_id,course_id,add_remove) VALUES('".$this->studentId."',$program_id,$course_id,1)";
      $this->db->runQuery($q);

      $this->processFees();

      return true;
    } else {
      return false;
    }
  }

  public function unenrollFromCourse($course_id, $program_id) {
    if ($this->inCourse($course_id)) {
      $q = "DELETE FROM tsm_reg_student_course WHERE student_id = '".$this->studentId."' AND course_id = '".$course_id."' AND program_id = '".$program_id."'";
      $this->db->runQuery($q);

      $q = "INSERT INTO tsm_reg_student_log (student_id,program_id,course_id,add_remove) VALUES('".$this->studentId."',$program_id,$course_id,0)";
      $this->db->runQuery($q);

      $processFees = $this->processFees(true);
      if(isset($processFees['removeButInvoiced'])){
        foreach($processFees['removeButInvoiced'] as $fee){
          $familyFee = new TSM_REGISTRATION_FAMILY_FEE($fee['family_fee_id']);
          $familyFeeInfo = $familyFee->getInfo();
          if($familyFeeInfo['removable'] == 1){
            $familyFee->setToReview(true);
          }
        }
      }
      $this->processFees();

      return true;
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

  public function assignFee($fee_id, $program_id = null, $course_id = null) {
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

      $q = "INSERT INTO tsm_reg_families_fee_log (family_id,student_id,add_remove,fee_id,program_id,course_id,amount,fee_name) VALUES('".$this->info['family_id']."','".$this->studentId."',1,$fee_id,$program_id,$course_id,'".$feeInfo['amount']."','".$feeInfo['name']."')";
      $this->db->runQuery($q);

      return true;
    } else {
      return false;
    }
  }

  public function getShirtSize(){
    $q = "SELECT * FROM tsm_reg_shirt_sizes WHERE shirt_size_id = '".$this->info['shirt_size_id']."'";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $shirt_size = $a['name'];
    }

    return $shirt_size;
  }

  public function processFees($preview = false) {
    $this->setUseRecordedFees(false);
    $fees = $this->getFees();
    $this->setUseRecordedFees(true);
    if (isset($fees)) {
      foreach ($fees as $fee) {
        if (!isset($fee['course_id'])) {
          $fee['course_id'] = null;
        }
        if (!isset($fee['program_id'])) {
          $fee['program_id'] = null;
        }

        if (!$this->assignedFee($fee['fee_id'], $fee['program_id'], $fee['course_id'])) {
          $params = Array('program_id' => $fee['program_id'], 'course_id' => $fee['course_id'], 'fee' => $fee);

          $feeObject = new TSM_REGISTRATION_FEE($fee['fee_id']);
          if (!is_null($fee['program_id'])) {
            $programConditions = $feeObject->getConditionsForProgram($fee['program_id']);
          } else {
            $programConditions = null;
          }
          if (!is_null($fee['course_id'])) {
            $courseConditions = $feeObject->getConditionsForCourse($fee['course_id'], $fee['program_id']);
          } else {
            $courseConditions = null;
          }
          if ($this->meetsConditions($programConditions, $params) && $this->meetsConditions($courseConditions, $params)) {
            if($preview == false){
              $this->assignFee($fee['fee_id'], $fee['program_id'], $fee['course_id']);
            } else {
              $addFees[] = $fee;
            }

          }
          //$addFees[] = $fee;
        }

      }
    }

    $assignedFees = $this->getFees();
    if (isset($assignedFees)) {
      foreach ($assignedFees as $fee) {
        if (!isset($fee['course_id'])) {
          $fee['course_id'] = null;
        }
        if (!isset($fee['program_id'])) {
          $fee['program_id'] = null;
        }
        $needed = false;

        if (isset($fees)) {
          foreach ($fees as $neededFee) {


            if (!isset($neededFee['course_id'])) {
              $neededFee['course_id'] = null;
            }
            if (!isset($neededFee['program_id'])) {
              $neededFee['program_id'] = null;
            }

            if ($neededFee['fee_id'] == $fee['fee_id'] &&
              $neededFee['program_id'] == $fee['program_id'] &&
              $neededFee['course_id'] == $fee['course_id']
            ) {
              $needed = true;
            }


          }
        }

        if ($needed == false) {
          //echo "deleteing: ".$fee['fee_id']."\r\n";
          $feeObject = new TSM_REGISTRATION_FAMILY_FEE($fee['family_fee_id']);
          if (!$feeObject->isInvoiced() && !$feeObject->isOnPaymentPlan() && $feeObject->isRemovable() == true) {
            if($preview == false){
              $feeObject->delete();
            } else {
              $removeFees[] = $fee;
            }

          } else {
            if($preview == true){
              if($feeObject->getIsUnderReview() == false){
                $removeButInvoiced[] = $fee;
              }
            } else {
              $feeObject->setToReview(true);
            }
          }
        }
      }

    }

    if($preview == false){
      $return = true;
    } else {
      $return = Array("addFees"=>$addFees,"removeFees"=>$removeFees,"removeButInvoiced"=>$removeButInvoiced);
    }
    return $return;
  }

  public function enrollInProgram($program_id) {
    if ($this->inProgram($program_id) == false) {
      $q = "INSERT INTO tsm_reg_student_program (student_id,program_id) VALUES('".$this->studentId."','".$program_id."')";
      $this->db->runQuery($q);

      $q = "INSERT INTO tsm_reg_student_log (student_id,program_id,course_id,add_remove) VALUES('".$this->studentId."',$program_id,NULL,1)";
      $this->db->runQuery($q);

      $this->processFees();

      return true;
    } else {
      return false;
    }
  }

  public function unenrollFromProgram($program_id) {
    $return["success"] = false;
    if ($this->inProgram($program_id)) {
      $courses = $this->getCoursesIn($program_id);
      if (isset($courses)) {
        $return = false;
      } else {
        $q = "DELETE FROM tsm_reg_student_program WHERE student_id = '".$this->studentId."' AND program_id = '".$program_id."'";
        $this->db->runQuery($q);

        $q = "INSERT INTO tsm_reg_student_log (student_id,program_id,course_id,add_remove) VALUES('".$this->studentId."',$program_id,NULL,0)";
        $this->db->runQuery($q);

        $return = true;
      }
    }

    $processFees = $this->processFees(true);
    if(isset($processFees['removeButInvoiced'])){
      foreach($processFees['removeButInvoiced'] as $fee){
        $familyFee = new TSM_REGISTRATION_FAMILY_FEE($fee['family_fee_id']);
        $familyFeeInfo = $familyFee->getInfo();
        if($familyFeeInfo['removable'] == 1){
          $familyFee->setToReview(true);
        }
      }
    }
    $this->processFees();

    return $return;
  }

  public function getAllCourses() {
    $q = "SELECT * FROM tsm_reg_student_course sc, tsm_reg_courses c, tsm_reg_periods p, tsm_reg_course_period cp
    WHERE c.course_id = sc.course_id
    AND p.period_id = cp.period_id
    AND cp.course_period_id = sc.course_period_id
    AND sc.student_id = '".$this->studentId."'
    ORDER BY day, start_time";
    $r = $this->db->runQuery($q);
    $courses = null;
    while ($a = mysql_fetch_assoc($r)) {
      $courses[$a['course_id']] = $a;
    }

    return $courses;
  }

  public function getLog(){
    $q = "SELECT * FROM tsm_reg_student_log WHERE student_id = ".$this->studentId." ORDER BY time_logged DESC";
    $r = $this->db->runQuery($q);
    $log = null;
    while ($a = mysql_fetch_assoc($r)) {
      $log[$a['log_id']] = $a;
    }

    return $log;
  }
  public function getProgramById($id){
    $q = "SELECT * FROM tsm_reg_student_program WHERE student_id=".$this->studentId.' AND student_program_id='.$id;
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
        $result = $a;
    }
    return $result;
  }
  public function updateProgramRegistrationDate($program_id,$date){
    $q = "UPDATE tsm_reg_student_program SET registration_date='".$date."' WHERE student_program_id=".$program_id;
    $r = $this->db->runQuery($q);
    $this->processFees(false);
    return true;
  }
}

?>