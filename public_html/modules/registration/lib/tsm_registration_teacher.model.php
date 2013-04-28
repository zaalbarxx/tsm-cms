<?php

class TSM_REGISTRATION_TEACHER extends TSM_REGISTRATION_CAMPUS {

  private $info;

  public function __construct($teacherId = null) {
    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;
    if (isset($teacherId)) {
      $this->teacherId = intval($teacherId);
      $this->getInfo();
    }
  }

  public function getInfo() {
    if ($this->info == null) {
      $q = "SELECT * FROM tsm_reg_teachers WHERE teacher_id = ".$this->teacherId;
      $r = $this->db->runQuery($q);
      while ($a = mysql_fetch_assoc($r)) {
        $this->info = $a;
      }
    }

    return $this->info;
  }

  public function inSchoolYear($school_year) {
    $q = "SELECT * FROM tsm_reg_teachers_school_years WHERE teacher_id = ".$this->teacherId." AND school_year = '".$school_year."'";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function addToSchoolYear($school_year) {
    if (!$this->inSchoolYear($school_year)) {
      $q = "INSERT INTO tsm_reg_teachers_school_years (teacher_id,school_year) VALUES('".$this->teacherId."','$school_year')";
      if ($this->db->runQuery($q)) {
        return true;
      }
    } else {
      return false;
    }
  }

}

?>