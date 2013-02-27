<?php
$families = $currentCampus->getFamilies();
if (isset($families)) {
  foreach ($families as $family) {
    if ($family['current_step'] == 0) {
      unset($families[$family['family_id']]);
    }

  }

}

if (isset($downloadCSV)) {
  $tsm->arrayToCSV($families, $campusInfo['name']." - Unfinalized Families");
}
?>