<?php

class TSM_REGISTRATION_PROGRAM extends TSM_REGISTRATION {

  private $programId;
  private $info;
  private $numStudentsEnrolled;
  private $fees;
  private $requirements;
  private $courses;

  public function __construct($programId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($programId)) {
      $this->programId = intval($programId);
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_programs WHERE program_id = ".$this->programId;
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

  public function getDetails() {
    $this->numStudentsEnrolled = $this->getNumStudentsEnrolled();
  }

  public function delete() {
    if (!$this->getFees(null) && !$this->hasStudents() && !$this->getCourses() && !$this->getRequirements()) {
      $q = "DELETE FROM tsm_reg_programs WHERE program_id = '".$this->programId."'";
      if ($this->db->runQuery($q)) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function getNumStudentsEnrolled($programId = null) {
    if ($this->numStudentsEnrolled == null) {
      if ($programId == null) {
        $programId = $this->programId;
      }
      $q = "SELECT COUNT(student_id) AS num_students FROM tsm_reg_student_program WHERE program_id = '".$programId."'";
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->numStudentsEnrolled = $a['num_students'];
      }
    }

    return $this->numStudentsEnrolled;
  }

  public function addCourses() {
    foreach ($_POST as $key => $value) {
      $value = $this->tsm->makeVarSafe($value);
      if (stristr($key, "course_")) {
        $this->addCourse($value);
      }
    }

    return true;
  }

  public function hasCourses() {
    $q = "SELECT COUNT(course_id) AS num_courses FROM tsm_reg_course_program WHERE program_id = '".$this->programId."'";
    $r = $this->db->runQuery($q);
    $numCourses = 0;
    while ($a = mysql_fetch_assoc($r)) {
      $numCourses = $a['num_courses'];
    }

    if ($numCourses == 0) {
      return false;
    } else {
      return true;
    }
  }

  public function addCourse($course_id) {
    //Check to see if the course has already been added to the program
    $q = "SELECT * FROM tsm_reg_course_program WHERE course_id = ".$course_id." AND program_id = ".$this->programId;
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      $q = "INSERT INTO tsm_reg_course_program (program_id,course_id) VALUES ('".$this->programId."','".$course_id."')";
      ;
      if ($this->db->runQuery($q)) {
        $courseAdded = true;
      } else {
        $courseAdded = false;
      }
    } else {
      $courseAdded = false;
    }

    return $courseAdded;
  }

  public function removeCourse($course_id) {
    $course = new TSM_REGISTRATION_COURSE($course_id);
    if (!$course->getRequirements($this->programId) && !$course->getFees($this->programId, null)) {
      $q = "DELETE FROM tsm_reg_course_program WHERE program_id = '".$this->programId."' AND course_id = '$course_id'";
      $this->db->runQuery($q);

      return true;
    } else {
      return false;
    }
  }

  public function getCourses() {
    $q = "SELECT * FROM tsm_reg_courses c, tsm_reg_course_program cp WHERE cp.course_id = c.course_id AND cp.program_id = '".$this->programId."'";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $this->courses[$a['course_id']] = $a;
    }

    return $this->courses;
  }

  public function getRequirements() {
    if ($this->requirements == null) {
      $q = "SELECT * FROM tsm_reg_program_requirements pr, tsm_reg_requirements r WHERE r.requirement_id = pr.requirement_id AND pr.program_id = ".$this->programId."";
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->requirements[$a['program_requirement_id']] = $a;
      }
    }

    return $this->requirements;
  }

  public function getFees($fee_type_id = null) {
    $fees = null;
    if ($fee_type_id == null) {
      $q = "SELECT * FROM tsm_reg_program_fee pf, tsm_reg_fees f WHERE f.fee_id = pf.fee_id AND pf.program_id = ".$this->programId."";
    } else {
      $q = "SELECT * FROM tsm_reg_program_fee pf, tsm_reg_fees f WHERE f.fee_id = pf.fee_id AND pf.program_id = ".$this->programId." AND f.fee_type_id = '$fee_type_id'";
    }
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      //$this->fees[$a['program_fee_id']] = $a;
      $fees[] = $a;
    }

    return $fees;
  }

  public function deleteFeeCondition($programFeeConditionId) {
    $q = "DELETE FROM tsm_reg_program_fee_condition WHERE program_fee_condition_id = $programFeeConditionId AND program_id = ".$this->programId;
    $r = $this->db->runQuery($q);

    return true;
  }

  public function addFee($feeId) {
    //Check to see if the fee has already been added to the program
    $q = "SELECT * FROM tsm_reg_program_fee WHERE fee_id = ".$feeId." AND program_id = ".$this->programId;
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      $q = "INSERT INTO tsm_reg_program_fee (program_id,fee_id) VALUES ('".$this->programId."','$feeId')";
      ;
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

  public function addRequirement($requirementId) {
    //Check to see if the fee has already been added to the program
    $q = "SELECT * FROM tsm_reg_program_requirements WHERE requirement_id = ".$requirementId." AND program_id = ".$this->programId;
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      $q = "INSERT INTO tsm_reg_program_requirements (program_id,requirement_id) VALUES ('".$this->programId."','$requirementId')";
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

  public function removeRequirement($requirementId) {
    $q = "DELETE FROM tsm_reg_program_requirements WHERE requirement_id = ".$requirementId." AND program_id = ".$this->programId;
    $r = $this->db->runQuery($q);

    return true;
  }

  public function addFeeCondition($feeConditionId, $feeId) {
    //Check to see if the fee has already been added to the program
    $q = "SELECT * FROM tsm_reg_program_fee_condition WHERE fee_id = ".$feeId." AND fee_condition_id = ".$feeConditionId." AND program_id = ".$this->programId;
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      $q = "INSERT INTO tsm_reg_program_fee_condition (program_id,fee_id,fee_condition_id) VALUES ('".$this->programId."','$feeId','$feeConditionId')";
      ;
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

  public function hasStudents() {
    $q = "SELECT student_id FROM tsm_reg_student_program WHERE program_id = '".$this->programId."'";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) == 0) {
      return false;
    } else {
      return true;
    }
  }

  public function deleteFee($feeId) {
    //if($this->hasStudents() == false){
    $q = "DELETE FROM tsm_reg_program_fee WHERE fee_id = ".$feeId." AND program_id = ".$this->programId;
    $r = $this->db->runQuery($q);

    $q = "DELETE FROM tsm_reg_program_fee_condition WHERE fee_id = ".$feeId." AND program_id = ".$this->programId;
    $r = $this->db->runQuery($q);

    return true;
    //} else {
    //	return false;
    //}
  }

}

?>