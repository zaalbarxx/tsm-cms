<?php

$activeView = __TSM_ROOT__."modules/welcome/BackEnd/views/main.view.php";

//CALL THE APPROPRIATE VIEW
require_once($tsm->website->getTemplateHeader());
require_once($activeView);
require_once($tsm->website->getTemplateFooter());
?>