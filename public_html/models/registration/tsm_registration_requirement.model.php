<?php

class TSM_REGISTRATION_REQUIREMENT extends TSM_REGISTRATION_CAMPUS {

  private $requirementId;
  private $info;

  public function __construct($requirementId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($requirementId)) {
      $this->requirementId = $requirementId;
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_requirements WHERE requirement_id = ".$this->requirementId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function studentMeetsRequirement($student) {
    $requirement_type_id = $this->info['requirement_type_id'];
    $studentInfo = $student->getInfo();
    switch ($requirement_type_id) {
      //AGE REQUIREMENT
      case "1":
        //age is greater than
        if ($this->info['config_1'] == 1) {
          if ($studentInfo['age'] > $this->info['config_2']) {
            $result = true;
          } else {
            $result = false;
          }
        } //age is less than
        elseif ($this->info['config_1'] == -1) {
          if ($studentInfo['age'] < $this->info['config_2']) {
            $result = true;
          } else {
            $result = false;
          }
        }
        break;
      //GRADE REQUIREMENT
      case "2":
        //grade is greater than
        if ($this->info['config_1'] == 1) {
          if ($studentInfo['grade'] > $this->info['config_2']) {
            $result = true;
          } else {
            $result = false;
          }
        } //grade is less than
        elseif ($this->info['config_1'] == -1) {
          if ($studentInfo['grade'] < $this->info['config_2']) {
            $result = true;
          } else {
            $result = false;
          }
        }
        break;
      //REGISTRATION DATE
      case "3":
        break;
      //ENROLLED IN # OF CLASSES IN PROGRAM
      case "4":
        break;
      //ENROLLED IN PROGRAM
      case "5":
        $programs = $student->getEnrolledPrograms();
        $result = false;
        foreach ($programs as $program) {
          if ($program['program_id'] == $this->info['config_1']) {
            $result = true;
          }
        }
        break;
      //NOT ENROLLED IN PROGRAM
      case "6":
        $programs = $student->getEnrolledPrograms();
        $inProgram = false;
        foreach ($programs as $program) {
          if ($program['program_id'] == $this->info['config_1']) {
            $inProgram = true;
          }
        }
        if ($inProgram == true) {
          $result = false;
        } else {
          $result = true;
        }
        return $result;
        break;
      //ENROLLED IN COURSE
      case "7":
        $courses = $student->getAllCourses();
        $result = false;
        foreach ($courses as $course) {
          if ($course['course_id'] == $this->info['config_1']) {
            $result = true;
          }
        }
        return $result;
        break;
      //NOT ENROLLED IN COURSE
      case "8":
        $courses = $student->getAllCourses();
        $inCourse = false;
        if (isset($courses)) {
          foreach ($courses as $course) {
            if ($course['course_id'] == $this->info['config_1']) {
              $inCourse = true;
            }
          }
        }
        if ($inCourse == true) {
          $result = false;
        } else {
          $result = true;
        }
        return $result;
        break;
    }

    return $result;
  }

}

?>