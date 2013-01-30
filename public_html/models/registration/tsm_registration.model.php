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

  public function setCurrentCampusId($campus_id) {
    //echo "set campusId to: ".$campus_id;
    $_SESSION['reg']['currentCampusId'] = $campus_id;
    $this->currentCampusId = $_SESSION['reg']['currentCampusId'];

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
        $return .= ": ".$period['first_name']." ".$period['last_name'];
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

  public function getFeeTypes() {
    $q = "SELECT * FROM tsm_reg_fee_types";
    $r = $this->db->runQuery($q);
    $feeTypes = null;
    while ($a = mysql_fetch_assoc($r)) {
      $feeTypes[$a['fee_type_id']] = $a;
    }

    return $feeTypes;
  }

  public function addFees($fees) {
    $total = 0;

    if (isset($fees)) {
      foreach ($fees as $fee) {
        $total = $total + $fee['amount'];
      }
    }

    return $total;
  }

  public function getSelectedSchoolYear() {
    if (isset($_SESSION['reg']['selectedSchoolYear'])) {
      return $_SESSION['reg']['selectedSchoolYear'];
    } else {
      return null;
    }
  }

  public function getCampuses() {
    $q = "SELECT * FROM tsm_reg_campuses WHERE website_id = '".$_SESSION['website_id']."'";
    $r = $this->db->runQuery($q);
    $campuses = null;
    while ($a = mysql_fetch_assoc($r)) {
      $campuses[$a['campus_id']] = $a;
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