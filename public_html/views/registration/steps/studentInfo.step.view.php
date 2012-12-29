<div class="contentArea">
  <h1><?php echo $pageTitle; ?></h2>
  <p style="text-align: center; margin: 30px;"><?php echo $headerMessage; ?></p>
  <form method="post" action="">
    <fieldset>
    	<legend>Student Information</legend>
      <label for="first_name">First Name: </label><input type="text" name="first_name" value="<?php echo $studentInfo['first_name']; ?>" /><br />
      <label for="father_last">Last Name: </label><input type="text" name="father_last" value="<?php echo $studentInfo['father_last']; ?>" /><br />
      <label for="nickname">Nick Name: </label><input type="text" name="nickname" value="<?php echo $studentInfo['nickname']; ?>" /><br />
      <label for="birthdate">Birthdate: </label>
      <select name="birthdate_month">
      	<option value="">Month</option>
      	<?php for($i = 1; $i <= 12; $i++){
      		echo "<option value=\"".$i."\">".$tsm->intToMonth($i)."</option>";
      	} ?>
      </select>/ 
      <select name="birthdate_day">
      	<option value="">Day</option>
      	<?php for($i = 1; $i <= 31; $i++){
      		echo "<option value=\"".$i."\">".$i."</option>";
      	} ?>
      </select> / 
      <select name="birthdate_year">
      	<option value="">Year</option>
      	<?php for($i = date('Y'); $i >= date('Y') - 100; $i--){
      		echo "<option value=\"".$i."\">".$i."</option>";
      	} ?>
      </select><br />
      <label for="age">Age: </label><select name="age">
      	<option value="">Select Age</option>
      	<?php for($i = 1; $i <= 100; $i++){
      		echo "<option value=\"".$i."\">".$i."</option>";
      	} ?>
      </select><br />
      <label for="grade">Grade: </label><select name="age">
      	<option value="">Select Grade</option>
      	<?php
				for($i = 1; $i <= 14; $i++){
					if($condition['config_2'] == $i){ $selected = "selected=selected"; } else { $selected = ""; }
					if($i == 13){
						$name = "Kindergarten";
					} elseif($i == 14){
						$name = "Preschool";
					} else {
						$name = $i;
					}
					echo "<option value=\"$i\" $selected>$name</option>";
				}
				?>
      </select>
    </fieldset>

    <br />
    <input type="hidden" name="campus_id" value="<?php echo $currentCampus->getCampusId(); ?>" />
    <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>" />
    <input type="hidden" name="school_year" value="<?php echo $currentCampus->getCurrentSchoolYear(); ?>" />
    <input type="hidden" name="<?php echo $submitField; ?>" value="1" />
    <input type="submit" class="submitButton" style="float: right;" value="Next Step" />
    <br /><br /><br />
  </form>
</div>