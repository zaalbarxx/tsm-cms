<?php
require_once(__TSM_ROOT__.'modules/page/lib/tsm_page.model.php');


if(!isset($var) || $var == ""){
  $view = "notFound";
}

$page = new TSM_PAGE($var);
if($page->exists()){
  $view = "viewPage";
} else {
  $view = "notFound";
}

switch($view){
  case "viewPage":
    require_once(__TSM_ROOT__.'modules/page/FrontEnd/controllers/viewPage.controller.php');
    break;
  case "notFound":
    header("HTTP/1.0 404 Not Found");
    break;
}