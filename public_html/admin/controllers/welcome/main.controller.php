<?php

$activeView = __TSM_ROOT__."admin/views/welcome/main.view.php";

//CALL THE APPROPRIATE VIEW
require_once($tsm->website->getTemplateHeader());
require_once($activeView);
require_once($tsm->website->getTemplateFooter());
?>