<?php
error_reporting(E_ALL ^ E_STRICT);
ini_set("display_errors", "1");

session_start();

//REQUIRE THE CONFIG FILE
require_once('tsm_config.php');

//REQUIRE THE CORE CLASSES
require_once(__TSM_ROOT__.'tsm_core.php');

//INSTANTIATE THE TSM CLASS
$tsm = TSM::getInstance();
//START SAFE GLOBAL VARIABLES
extract($tsm->makeArraySafe($_REQUEST), EXTR_OVERWRITE);

//INSTANTIATE THE DB CONNECTION
require_once(__TSM_ROOT__.'tsm_db_conn.php');

$tsm->logRequest();

//INSTANTIATE THE WEBSITE CLASS AND START THE SITE
$tsm->website = new Website();
$tsm->website->start();
$tsm->currentTemplate = new TSM_TEMPLATE();

//TURN CONTROL OVER TO THE COMPONENT
require_once($tsm->getComponentOld());

?>