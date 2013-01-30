<?php

class TSM_REGISTRATION_FEE extends TSM_REGISTRATION_CAMPUS {

  private $info;

  public function __construct($feeId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($feeId)) {
      $this->feeId = intval($feeId);
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_fees WHERE fee_id = ".$this->feeId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function getConditionsForCourse($course_id, $program_id = null) {
    $q = "SELECT * FROM tsm_reg_course_fee_condition cfc, tsm_reg_fee_conditions fc 
    WHERE cfc.fee_condition_id = fc.fee_condition_id 
    AND cfc.course_id = ".$course_id." AND cfc.fee_id = ".$this->feeId;
    if ($program_id == null) {
      $q .= " AND program_id IS NULL";
    } else {
      $q .= " AND program_id = '$program_id'";
    }
    $r = $this->db->runQuery($q);
    $conditions = null;
    while ($a = mysql_fetch_assoc($r)) {
      $conditions[$a['course_fee_condition_id']] = $a;
    }

    return $conditions;
  }

  public function getConditionsForProgram($program_id) {
    $q = "SELECT * FROM tsm_reg_program_fee_condition pfc, tsm_reg_fee_conditions fc 
    WHERE pfc.fee_condition_id = fc.fee_condition_id 
    AND pfc.program_id = ".$program_id." AND pfc.fee_id = ".$this->feeId;
    $r = $this->db->runQuery($q);
    $conditions = null;
    while ($a = mysql_fetch_assoc($r)) {
      $conditions[$a['program_fee_condition_id']] = $a;
    }

    return $conditions;
  }

}

?>