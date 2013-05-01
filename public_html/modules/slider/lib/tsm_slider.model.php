<?php

class TSM_SLIDER extends TSM_COMPONENT{

  protected $id;

  public function __construct($id = null){
    $this->tsm = TSM::getInstance();
    $this->db = $this->tsm->db;
    if($id != null){
      $this->id = $id;
      $this->getData();
    }
  }

  public function getData(){
    $q = "SELECT * FROM tsm_sliders WHERE slider_id = '".$this->id."' AND website_id = '".$this->tsm->website->getWebsiteId()."'";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $this->_data = $a;
    }

    $q = "SELECT * FROM tsm_sliders_slides WHERE slider_id = '".$this->id."'";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $this->_data['Slides'][] = $a;
    }

    return $this->_data;
  }

  public function getSlides(){
    return $this->_data['Slides'];
  }

  public function display(){
    require_once(__TSM_ROOT__."modules/slider/Component/controllers/slider.controller.php");
  }





}

?>