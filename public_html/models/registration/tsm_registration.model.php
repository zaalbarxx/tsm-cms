<?php

class TSM_REGISTRATION {

  private $currentCampusId;
  private $selectedSchoolYear;
  private $feeConditionTypes;
  private $requirementTypes;

  public function __construct() {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
  }

  public function userCanAccessCampus($campus_id) {
    if (isset($this->tsm->adminUser)) {
      $q = "SELECT * FROM tsm_reg_users WHERE user_id = '".$_SESSION['adminUser']['id']."'";
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $super_user = $a['super_user'];
        $allowed_campues = unserialize($a['allowed_campuses']);
      }
      if ($super_user == 1) {
        return true;
      } else {
        $access = false;
        foreach ($allowed_campues as $allowed_campus_id) {
          if ($allowed_campus_id == $campus_id) {
            $access = true;
          }
        }

        return $access;
      }
    } else {
      return true;
    }
  }

  public function setCurrentCampusId($campus_id) {
    if ($this->userCanAccessCampus($campus_id)) {
      $_SESSION['reg']['currentCampusId'] = $campus_id;
      $this->currentCampusId = $_SESSION['reg']['currentCampusId'];
    }

    return true;
  }

  public function getGradeDisplay($grade) {
    if ($grade == -1) {
      $return = "Preschool";

    } elseif ($grade == 0) {
      $return = "Kindergarten";
    } else {
      $return = $grade;
    }

    return $return;
  }

  public function setSelectedSchoolYear($school_year) {
    //echo "set school year to: ".$school_year;
    $_SESSION['reg']['selectedSchoolYear'] = $school_year;
    $this->selectedSchoolYear = $_SESSION['reg']['selectedSchoolYear'];

    return true;
  }

  public function displayPeriod($period) {
    if ($period['start_time'] == "00:00:00" and $period['end_time'] == "00:00:00") {
      $return = "TBD";
      if (isset($period['first_name']) && isset($period['last_name'])) {
        if ($period['first_name'] != "TBD" && $period['last_name'] != "TBD") {
          $return .= ": ".$period['first_name']." ".$period['last_name'];
        }
        //$return .= ": ".$period['first_name']." ".$period['last_name'];
      }
    } else {
      $return = $this->tsm->intToDay($period['day']).". ".date("g:ia", strtotime($period['start_time']))." - ".date("g:ia", strtotime($period['end_time']));
      if (isset($period['first_name']) && isset($period['last_name'])) {
        $return .= ": ".$period['first_name']." ".$period['last_name'];
      }
    }

    return $return;
  }

  public function getCurrentCampusId() {
    if (isset($_SESSION['reg']['currentCampusId'])) {
      return $_SESSION['reg']['currentCampusId'];
    } else {
      return null;
    }

  }

  public function addFees($fees) {
    $total = 0;

    if (isset($fees)) {
      foreach ($fees as $fee) {
        $total = $total + $fee['amount'];
      }
    }

    $total = number_format($total, 2, '.', '');

    return $total;
  }

  public function getSelectedSchoolYear() {
    if (isset($_SESSION['reg']['selectedSchoolYear'])) {
      return $_SESSION['reg']['selectedSchoolYear'];
    } else {
      return null;
    }
  }

  public function getCampuses($regOpen = null) {
    $q = "SELECT * FROM tsm_reg_campuses WHERE website_id = '".$_SESSION['website_id']."'";
    if ($regOpen == true) {
      $q .= "AND registration_open = 1";
    }
    $r = $this->db->runQuery($q);
    $campuses = null;
    while ($a = mysql_fetch_assoc($r)) {
      if ($this->userCanAccessCampus($a['campus_id'])) {
        $campuses[$a['campus_id']] = $a;
      }
    }
    return $campuses;
  }

  public function createCampus() {
    if (isset($_POST['name']) && isset($_POST["website_id"])) {
      if ($this->db->insertRowFromPost("tsm_reg_campuses")) {
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      }
    } else {

    }
  }

  public function getFeeTypeName($fee_type_id) {
    $q = "SELECT name FROM tsm_reg_fee_types WHERE fee_type_id = $fee_type_id";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      return $a['name'];
    }
  }

  public function getFeeConditionTypes() {
    $q = "SELECT * FROM tsm_reg_fee_condition_types";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $this->feeConditionTypes[$a['fee_condition_type_id']] = $a;
    }

    return $this->feeConditionTypes;
  }

  public function getRequirementTypes() {
    $q = "SELECT * FROM tsm_reg_requirement_types";
    $r = $this->db->runQuery($q);
    while ($a = mysql_fetch_assoc($r)) {
      $this->requirementTypes[$a['requirement_type_id']] = $a;
    }

    return $this->requirementTypes;
  }

}

?>