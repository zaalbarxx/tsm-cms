<?php
$activeView = __TSM_ROOT__."admin/views/login/main.view.php";
if (isset($login)) {
  if ($tsm->adminUser->login($username, $password)) {
    $loginSuccessful = 1;
  } else {
    $loginSuccessful = 0;
    $errorMessage = "Sorry. Your username or password was incorrect.";
  }
}

//CALL THE APPROPRIATE VIEW
require_once($tsm->website->getTemplateHeader());
require_once($activeView);
require_once($tsm->website->getTemplateFooter());
?>