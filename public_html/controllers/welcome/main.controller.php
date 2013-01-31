<?php

$activeView = __TSM_ROOT__."views/welcome/main.view.php";

//CALL THE APPROPRIATE VIEW
require_once($tsm->website->getTemplateHeader());
require_once($activeView);
require_once($tsm->website->getTemplateFooter());
?>