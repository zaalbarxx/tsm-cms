<?php

class TSM_REGISTRATION_FEE_CONDITION extends TSM_REGISTRATION_CAMPUS {

  private $requirementId;
  private $info;

  public function __construct($feeConditionId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($feeConditionId)) {
      $this->feeConditionId = intval($feeConditionId);
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_fee_conditions WHERE fee_condition_id = ".$this->feeConditionId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function studentMeetsFeeCondition($student, $params = null) {

    //die("got here");
    $fee_condition_type_id = $this->info['fee_condition_type_id'];
    $studentInfo = $student->getInfo();
    switch ($fee_condition_type_id) {
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
          if ($studentInfo['grade'] >= $this->info['config_2']) {
            $meets1 = true;
          } else {
            $meets1 = false;
          }
        } //grade is less than
        elseif ($this->info['config_1'] == -1) {
          if ($studentInfo['grade'] <= $this->info['config_2']) {
            $meets1 = true;
          } else {
            $meets1 = false;
          }
        } else {
          $meets1 = false;
        }

        if ($this->info['config_3'] != "") {
          if ($this->info['config_3'] == 1) {
            if ($studentInfo['grade'] >= $this->info['config_4']) {
              $meets2 = true;
            } else {
              $meets2 = false;
            }
          } elseif ($this->info['config_3'] == -1) {
            if ($studentInfo['grade'] <= $this->info['config_4']) {
              $meets2 = true;
            } else {
              $meets2 = false;
            }
          } else {
            $meets2 = false;
          }
        } else {
          $meets2 = true;
        }

        if ($meets1 == true && $meets2 == true) {
          $result = true;
        } else {
          $result = false;
        }

        break;
      //REGISTRATION DATE
      case "3":
        $startDate = $this->info['config_3']."-".$this->info['config_1']."-".$this->info['config_2'];
        $endDate = $this->info['config_6']."-".$this->info['config_4']."-".$this->info['config_5'];
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        $regDate = $student->getRegistrationDate($params['program_id']);
        $regDate = strtotime($regDate);
        if ($startDate < $regDate && ($endDate > $regDate)) {
          $result = true;
        } else {
          $result = false;
        }

        //die();
        break;
      //ENROLLED IN # OF CLASSES IN PROGRAM
      case "4":
        $condition = $this->info['config_1'];
        $specified = $this->info['config_2'];
        $numCourses = count($student->getCoursesIn($this->info['config_3']));
        $result = false;
        switch ($condition) {
          //less than

          case "-1":
            if ($numCourses < $specified) {
              $result = true;
            }

            break;
          //equal to
          case "0":
            if ($numCourses == $specified) {
              $result = true;
            }

            break;
          //greater than
          case "1":
            if ($numCourses > $specified) {
              $result = true;
            }

            break;
        }

        return $result;
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
      //ENROLLED IN COURSE IN PROGRAM
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
      case "9":
        $spotInFamily = $student->getSpotInFamily();
        if ($this->info['config_1'] == "-1") {
          if ($spotInFamily < $this->info['config_2']) {
            $result = true;
          } else {
            $result = false;
          }
        } elseif ($this->info['config_1'] == "1") {
          if ($spotInFamily > $this->info['config_2']) {
            $result = true;
          } else {
            $result = false;
          }
        } elseif ($this->info['config_1'] == "0") {
          if ($spotInFamily == $this->info['config_2']) {
            $result = true;
          } else {
            $result = false;
          }
        }

        return $result;
        break;
      case "10":
        $spotInProgram = $student->getSpotInFamilyInProgram($this->info['config_3']);
        if ($this->info['config_1'] == "-1") {
          if ($spotInProgram < $this->info['config_3']) {
            $result = true;
          } else {
            $result = false;
          }
        } elseif ($this->info['config_1'] == "1") {
          if ($spotInProgram > $this->info['config_3']) {
            $result = true;
          } else {
            $result = false;
          }
        } elseif ($this->info['config_1'] == "0") {
          if ($spotInProgram == $this->info['config_3']) {
            $result = true;
          } else {
            $result = false;
          }
        }

        return $result;
        break;
      case "11":
        if ($student->isFirstYear()) {
          $result = true;
        } else {
          $result = false;
        }

        return $result;
        break;
    }

    return $result;
  }

}

?>