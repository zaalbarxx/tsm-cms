<?php
if (!$family->isLoggedIn()) {
  $currentCampus = new TSM_REGISTRATION_CAMPUS($campus_id);

  //IF THE FAMILY EXISTS
  if ($currentCampus->familyExists($primary_email)) {
    if ($family->login($primary_email, $password, $campus_id)) {
      header("Location: index.php");

      //THE FAMILY EXISTS, BUT THEY ENTERED THE WRONG PASSWORD
    } else {

    }

    //IF THE FAMILY IS NOT FOUND IN THE SYSTEM
  } else {
    if (isset($registerFamily)) {
      $reg->setSelectedSchoolYear($currentCampus->getCurrentSchoolYear());
      $new_family_id = $family->registerFamily();
      $newFamily = new TSM_REGISTRATION_FAMILY($new_family_id);
      if ($new_family_id) {
        $newFamily->addToSchoolYear($currentCampus->getCurrentSchoolYear());
        if ($newFamily->moveToNextStep()) {
          $family->login($primary_email, $password, $campus_id);
          //header("Location: index.php");
        } else {
          die("Error moving to the next step.");
        }
        //header('Location: index.php?com=registration&view=programs');
      }
    }

    $familyInfo = Array('primary_email' => $primary_email, 'password' => $password, 'confirm_password' => $confirm_password);
    $pageTitle = "Family Information";
    $submitField = "registerFamily";
    $headerMessage = "Your family is not yet in the registration system. Please enter your information below to create your account.";
  }

//IF THE FAMILY IS LOGGED IN
} else {
  if (isset($verifyFamilyAndAddToSchoolYear)) {
    if ($family->saveFamily()) {
      if ($family->addToSchoolYear($currentCampus->getCurrentSchoolYear())) {
        if ($family->moveToNextStep()) {
          header("Location: index.php");
        } else {
          die("Error moving to the next step.");
        }
      } else {
        die("Error adding to the school year.");
      }
    } else {
      die("Error saving family information");
    }
  }

  if (isset($verifyFamily)) {
    if ($family->saveFamily()) {
      if ($family->moveToNextStep()) {
        header("Location: index.php");
      } else {
        die("Error moving to the next step.");
      }
    } else {
      die("Error saving family information.");
    }
  }

  //IF THE FAMILY IS IN THE CURRENT SCHOOL YEAR, VERIFY THEIR INFORMATION
  if ($family->inSchoolYear($currentCampus->getCurrentSchoolYear())) {
    $familyInfo = $family->getInfo();
    ;
    $pageTitle = "Verify Family Information";
    $submitField = "verifyFamily";
    $headerMessage = "Your family is already in the registration system. Please verify your information below to move on to the next step.";

    //IF THE FAMILY IS NOT YET IN THE CURRENT SCHOOL YEAR, VERIFY THEIR INFORMATION AND ADD THEM.
  } else {
    $familyInfo = $family->getInfo();
    ;
    $pageTitle = "Verify Family Information";
    $submitField = "verifyFamilyAndAddToSchoolYear";
    $headerMessage = "Your family is not yet registered in the ".$currentCampus->getCurrentSchoolYear()." school year. Please verify your information below to register.";
  }

  $hidePasswordFields = 1;
}
error_reporting(E_ALL ^ E_NOTICE);
//$familyInfo = $family->getInfo();

?>