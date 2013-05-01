<?php

class TSM_TEMPLATE extends TSM_COMPONENT{

  protected $id;
  protected $_data;
  protected $tsm;

  public function __construct(){
    $this->tsm = TSM::getInstance();
    $this->db = $this->tsm->db;
    $this->id = $this->tsm->website->getTemplateId();
    $this->getData();
  }

  public function getData(){
    $q = "SELECT * FROM tsm_options WHERE option_name LIKE '%template_".$this->id."_option%' AND website_id = '".$this->tsm->website->getWebsiteId()."'";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $options[$a['option_name']] = $a;
    }

    $this->_data['options'] = $options;
  }

  public function getOptionRawValue($optionId){
    return $this->_data['options']['template_'.$this->id.'_option_'.$optionId]['option_value'];
  }

  public function displayOptionValue($opionValue){
    echo html_entity_decode($this->getOptionRawValue($opionValue));

  }

  public function makeOptionEditable($id){
    if($this->tsm->adminUser->isLoggedIn()){
      echo "contenteditable=\"true\" data-tsm-inline-edit-info=\"option:template_".$this->id."_option_".$id."\"";
    }
  }

}