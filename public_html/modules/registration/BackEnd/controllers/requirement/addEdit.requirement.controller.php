<?php
if (isset($requirement_id)) {
  $requirement = $currentCampus->getRequirement($requirement_id);
  $submitField = "saveRequirement";
} else {
  $requirement = null;
  $submitField = "createRequirement";
}
if (isset($createRequirement)) {
  if ($currentCampus->createRequirement()) {
    header('Location: index.php?mod=registration&view=requirements');
  }
} else if (isset($saveRequirement)) {
  if ($currentCampus->saveRequirement($requirement_id)) {
    header('Location: index.php?mod=registration&view=requirements');
  } else {
    die();
  }
}
$pageTitle = "Add Requirement";
$requirementTypes = $reg->getRequirementTypes();
?>