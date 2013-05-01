<?php
if (isset($createPeriod)) {
  if ($currentCampus->createPeriod()) {
    header('Location: index.php?mod=registration&view=periods');
  }
} else if (isset($savePeriod)) {
  if ($currentCampus->savePeriod($period_id)) {
    header('Location: index.php?mod=registration&view=periods');
  } else {
    die();
  }
}

if (isset($period_id)) {
  $period = new TSM_REGISTRATION_PERIOD($period_id);
  $period = $period->getInfo();
  $submitField = "savePeriod";
  $pageTitle = "Edit Period";
} else {
  $period = null;
  $submitField = "createPeriod";
  $pageTitle = "Add Period";
}

?>