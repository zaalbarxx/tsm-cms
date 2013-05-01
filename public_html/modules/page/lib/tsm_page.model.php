<?php

class TSM_PAGE extends TSM_MODULE{

  public function __construct($guid){
    $this->tsm = TSM::getInstance();
    $this->db = $this->tsm->db;
    $this->getPageByGUID($guid);
  }

  public function getPageByGUID($guid){
    $q = "SELECT * FROM tsm_page_pages WHERE guid = '".$guid."'";
    $r = $this->db->runQuery($q);
    $info = null;
    while($a = mysql_fetch_assoc($r)){
      $info = $a;
    }

    if($info != null){
      $this->setId($info['page_id']);
      $this->_data['info'] = $info;
    } else {
      $this->setId(null);
    }

    return $info;
  }

  public function exists(){
    if($this->getId() != null){
      return true;
    } else {
      return false;
    }
  }

}