<?php
class TSM_EDIT {

  public function __construct(){
    $tsm = TSM::getInstance();
    $this->db = $tsm->db;
    $this->website = $tsm->website;
  }

  //we'll need to integrate some security here
  public function saveOption($optionName,$data){
    if($this->getOption($optionName)){
      $q = "UPDATE tsm_options SET option_value = '$data' WHERE option_name = '$optionName' AND website_id = '".$this->website->getWebsiteId()."'";
    } else {
      $q = "INSERT INTO tsm_options (option_name,option_value,website_id) VALUES('$optionName','$data','".$this->website->getWebsiteId()."')";
    }
    $this->db->runQuery($q);

    return true;
  }

  public function getOption($optionName){
    $q = "SELECT * FROM tsm_options WHERE option_name = '$optionName' AND website_id = '".$this->website->getWebsiteId()."'";
    $r = $this->db->runQuery($q);
    $return = false;
    while($a = mysql_fetch_assoc($r)){
      $return = $a;
    }

    return $return;
  }

}
?>