<?php
$campus = new TSM_REGISTRATION_CAMPUS($reg->getCurrentCampusId());
$campusInfo = $campus->getInfo();
$activeView = __TSM_ROOT__."modules/registration/BackEnd/views/dashboard.view.php";
?>