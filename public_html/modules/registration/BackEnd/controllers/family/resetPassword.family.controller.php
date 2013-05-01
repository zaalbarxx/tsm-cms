<?php

$family = new TSM_REGISTRATION_FAMILY($family_id);
$familyInfo = $family->getInfo();

if (isset($resetPassword) && isset($password) && isset($confirm_password)) {
  if ($password == $confirm_password) {
    if (isset($_POST['password'])) {
      $_POST['password'] = $tsm->createPassword($_POST['password']);
      $family->saveFamily();
      die("1");
    }
  }

}
?>