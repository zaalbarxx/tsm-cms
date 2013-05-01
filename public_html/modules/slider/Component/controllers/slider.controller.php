<?php

$sliderTypeId = $this->getslider_type_id();
$slides = $this->getSlides();


switch($sliderTypeId){
  case 1:
    $activeView = __TSM_ROOT__."modules/slider/Component/views/thumbnail_slider.view.php";
    break;
}

require_once($activeView);
