<?php
class TSM_REGISTRATION_COURSE_FEE extends TSM_REGISTRATION {

  private $courseFeeId;
  private $info;

  public function __construct($courseFeeId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($courseFeeId)) {
      $this->courseFeeId = intval($courseFeeId);
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_course_fee WHERE course_fee_id = ".$this->courseFeeId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function setQuickbooksClassId($qbClassId){
    $q = "UPDATE tsm_reg_course_fee SET quickbooks_class_id = '$qbClassId' WHERE course_fee_id = '".$this->courseFeeId."'";
    $this->db->runQuery($q);

    return true;
  }

}

?>