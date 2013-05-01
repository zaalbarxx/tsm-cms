<?php
require_once(__TSM_ROOT__."modules/edit/edit.php");


if(isset($ajax)){
  switch($ajax){
    case "inlineSave":
      $editArray = explode(":",$editInfo);
      $saveType = $editArray[0];
      switch($saveType){
        case "option":
          $optionName = $editArray[1];
          $edit = new TSM_EDIT();
          $edit->saveOption($optionName,$contents);
        break;
      }

      break;
  }
  die();
}


?>