<?php
class TSM_REGISTRATION_COURSE extends TSM_REGISTRATION {

  private $courseId;
  private $info;
  private $courses;
  private $numStudentsEnrolled;
  private $fees;
  private $tuitionFees;
  private $requirements;
  private $periods;
  private $assignedPrograms;
  private $enrolledStudents;

  public function __construct($courseId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($courseId)) {
      $this->courseId = intval($courseId);
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_courses WHERE course_id = ".$this->courseId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function getName() {
    if ($this->info == null) {
      $this->getInfo();
    }

    $this->name = $this->info['name'];

    return $this->name;
  }

  public function delete($force = false) {
    if ((!$this->getNumStudentsEnrolled() && !$this->getAssignedPrograms() && !$this->getFees() && !$this->getRequirements()) or $force == true) {
      echo "can be deleted";
    } else {
      return false;
    }
  }

  public function changePeriod($course_period_id, $new_period_id, $new_teacher_id) {
    $q = "UPDATE tsm_reg_course_period SET teacher_id = '$new_teacher_id', period_id = '$new_period_id' WHERE course_period_id = '$course_period_id' AND course_id = '".$this->courseId."'";
    $this->db->runQuery($q);

    return true;
  }

  public function getEnrolledStudents($program_id = null) {
    if ($program_id == null) {
      $q = "SELECT * FROM tsm_reg_student_course WHERE course_id = '".$this->courseId."'";
    } else {
      $q = "SELECT * FROM tsm_reg_student_course WHERE course_id = '".$this->courseId."' AND program_id = '$program_id'";
    }
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $student = new TSM_REGISTRATION_STUDENT($a['student_id']);
      $studentInfo = $student->getInfo();
      $this->enrolledStudents[$a['student_id']] = $studentInfo;
    }

    return $this->enrolledStudents;
  }

  public function getAssignedPrograms() {
    $q = "SELECT * FROM tsm_reg_course_program WHERE course_id = '".$this->courseId."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $this->assignedPrograms[$a['program_id']] = $a;
    }

    return $this->assignedPrograms;

  }

  public function addFee($feeId, $program_id = null) {
    //Check to see if the fee has already been added to the program
    if ($program_id == null) {
      $q = "SELECT * FROM tsm_reg_course_fee WHERE fee_id = ".$feeId." AND course_id = ".$this->courseId." AND program_id IS NULL";
    } else {
      $q = "SELECT * FROM tsm_reg_course_fee WHERE fee_id = ".$feeId." AND course_id = ".$this->courseId." AND program_id = '$program_id'";
    }
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      if ($program_id == null) {
        $q = "INSERT INTO tsm_reg_course_fee (course_id,fee_id) VALUES ('".$this->courseId."','$feeId')";
        ;
      } else {
        $q = "INSERT INTO tsm_reg_course_fee (course_id,fee_id,program_id) VALUES ('".$this->courseId."','$feeId','$program_id')";
        ;
      }
      if ($this->db->runQuery($q)) {
        $feeAdded = true;
      } else {
        $feeAdded = false;
      }
    } else {
      $feeAdded = false;
    }

    return $feeAdded;
  }

  public function getFees($program_id = null, $fee_type_id = null) {
    $fees = null;
    $q = "SELECT * FROM tsm_reg_course_fee cf, tsm_reg_fees f WHERE f.fee_id = cf.fee_id AND cf.course_id = ".$this->courseId;
    if ($program_id == null) {
      $q .= " AND program_id IS NULL";
    } else {
      $q .= " AND program_id = '$program_id'";
    }
    if ($fee_type_id != null) {
      $q .= " AND f.fee_type_id = '$fee_type_id'";
    }
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      //$this->fees[$a['course_fee_id']] = $a;
      $fees[] = $a;
    }

    return $fees;
  }

  public function addFeeCondition($feeConditionId, $feeId, $program_id = null) {
    //Check to see if the fee has already been added to the program
    if ($program_id == null) {
      $q = "SELECT * FROM tsm_reg_course_fee_condition WHERE fee_id = ".$feeId." AND fee_condition_id = ".$feeConditionId." AND course_id = ".$this->courseId." AND program_id IS NULL";
    } else {
      $q = "SELECT * FROM tsm_reg_course_fee_condition WHERE fee_id = ".$feeId." AND fee_condition_id = ".$feeConditionId." AND course_id = ".$this->courseId." AND program_id = '$program_id'";
    }
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      if ($program_id == null) {
        $q = "INSERT INTO tsm_reg_course_fee_condition (course_id,fee_id,fee_condition_id) VALUES ('".$this->courseId."','$feeId','$feeConditionId')";
      } else {
        $q = "INSERT INTO tsm_reg_course_fee_condition (course_id,fee_id,fee_condition_id,program_id) VALUES ('".$this->courseId."','$feeId','$feeConditionId','$program_id')";
      }
      if ($this->db->runQuery($q)) {
        $feeAdded = true;
      } else {
        $feeAdded = false;
      }
    } else {
      $feeAdded = false;
    }

    return $feeAdded;
  }

  public function getPeriods() {
    $q = "SELECT * FROM tsm_reg_periods p, tsm_reg_course_period cp, tsm_reg_teachers t WHERE p.period_id = cp.period_id AND t.teacher_id = cp.teacher_id AND cp.course_id = '".$this->courseId."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $this->periods[$a['course_period_id']] = $a;
    }

    return $this->periods;
  }

  public function sudentsInPeriod($course_period_id) {
    $q = "SELECT * FROM tsm_reg_student_course WHERE course_id = '".$this->courseId."' AND course_period_id = '".$course_period_id."'";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) > 0) {
      return true;
    } else {
      return false;

    }

  }

  public function addPeriod($period_id, $teacher_id) {
    //Check to see if this teacher is already teaching this course and period.
    $q = "SELECT * FROM tsm_reg_course_period WHERE course_id = '".$this->courseId."' AND period_id = ".$period_id." AND teacher_id = ".$teacher_id;
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      $q = "INSERT INTO tsm_reg_course_period (course_id,period_id,teacher_id) VALUES ('".$this->courseId."','$period_id','".$teacher_id."')";
      ;
      if ($this->db->runQuery($q)) {
        $requirementAdded = true;
      } else {
        $requirementAdded = false;
      }
    } else {
      $requirementAdded = false;
    }

    return $requirementAdded;
  }

  public function deleteFeeCondition($courseFeeConditionId) {
    $q = "DELETE FROM tsm_reg_course_fee_condition WHERE course_fee_condition_id = $courseFeeConditionId AND course_id = ".$this->courseId;
    $r = $this->db->runQuery($q);

    return true;
  }

  public function deletePeriod($course_period_id) {
    if (!$this->sudentsInPeriod($course_period_id)) {
      $q = "DELETE FROM tsm_reg_course_period WHERE course_period_id = $course_period_id AND course_id = ".$this->courseId;
      $r = $this->db->runQuery($q);

      return true;
    }
  }

  public function deleteFee($courseFeeId) {
    $q = "DELETE FROM tsm_reg_course_fee WHERE course_fee_id = $courseFeeId AND course_id = ".$this->courseId;
    $this->db->runQuery($q);

    return true;
  }

  public function addRequirement($requirementId, $program_id = null) {
    //Check to see if the fee has already been added to the course
    if ($program_id == null) {
      $q = "SELECT * FROM tsm_reg_course_requirements WHERE requirement_id = ".$requirementId." AND course_id = ".$this->courseId." AND program_id IS NULL";
    } else {
      $q = "SELECT * FROM tsm_reg_course_requirements WHERE requirement_id = ".$requirementId." AND course_id = ".$this->courseId." AND program_id = '$program_id'";
    }
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      if ($program_id == null) {
        $q = "INSERT INTO tsm_reg_course_requirements (course_id,requirement_id) VALUES ('".$this->courseId."','$requirementId')";
      } else {
        $q = "INSERT INTO tsm_reg_course_requirements (course_id,requirement_id,program_id) VALUES ('".$this->courseId."','$requirementId','$program_id')";
      }
      if ($this->db->runQuery($q)) {
        $requirementAdded = true;
      } else {
        $requirementAdded = false;
      }
    } else {
      $requirementAdded = false;
    }

    return $requirementAdded;
  }

  public function removeRequirement($courseRequirementId) {
    $q = "DELETE FROM tsm_reg_course_requirements WHERE course_requirement_id = ".$courseRequirementId." AND course_id = ".$this->courseId;
    $r = $this->db->runQuery($q);

    return true;
  }

  public function getRequirements($program_id = null) {
    if ($this->requirements == null) {
      $q = "SELECT * FROM tsm_reg_course_requirements cr, tsm_reg_requirements r WHERE r.requirement_id = cr.requirement_id AND cr.course_id = ".$this->courseId;
      if ($program_id == null) {
        $q .= " AND program_id IS NULL";
      } else {
        $q .= " AND program_id = '$program_id'";
      }
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->requirements[$a['course_requirement_id']] = $a;
      }
    }

    return $this->requirements;
  }

  public function getRequirementsForProgram($program_id) {
    if ($this->requirements == null) {
      $q = "SELECT * FROM tsm_reg_course_requirements cr, tsm_reg_requirements r WHERE r.requirement_id = cr.requirement_id AND cr.course_id = ".$this->courseId." AND program_id = '".$program_id."'";
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->requirements[$a['course_requirement_id']] = $a;
      }
    }

    return $this->requirements;
  }

  public function getNumStudentsEnrolled() {
    if ($this->numStudentsEnrolled == null) {
      $q = "SELECT COUNT(student_id) AS num_students FROM tsm_reg_student_course WHERE course_id = ".$this->courseId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->numStudentsEnrolled = $a['num_students'];
      }
    }

    return $this->numStudentsEnrolled;
  }

}

?>