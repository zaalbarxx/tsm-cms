<?php
require_once(__TSM_ROOT__."modules/registration/FrontEnd/views/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?></h1>
        <form method="post" id="studentInfoForm" action="">
            <fieldset>
                <legend>Student Information</legend>
                <label for="first_name">First Name: </label><input type="text" name="first_name"
                                                                   value="<?php echo $studentInfo['first_name']; ?>"/><br/>
                <label for="last_name">Last Name: </label><input type="text" name="last_name"
                                                                 value="<?php echo $studentInfo['last_name']; ?>"/><br/>
                <label for="nickname">Nick Name: </label><input type="text" name="nickname"
                                                                value="<?php echo $studentInfo['nickname']; ?>"/><br/>
                <label for="email">E-mail Address: </label><input type="text" name="email"
                                                                  value="<?php echo $studentInfo['email']; ?>"/><br/>
                <label for="birthdate">Birthdate: </label>
                <select name="birthdate_month" id="birthdate_month" style="margin-left: -2px;">
                    <option value="">Month</option>
                  <?php for ($i = 1; $i <= 12; $i++) {
                  echo "<option value=\"".$i."\">".$tsm->intToMonth($i)."</option>";
                } ?>
                </select>/
                <select name="birthdate_day" id="birthdate_day">
                    <option value="">Day</option>
                  <?php for ($i = 1; $i <= 31; $i++) {
                  echo "<option value=\"".$i."\">".$i."</option>";
                } ?>
                </select> /
                <select name="birthdate_year" id="birthdate_year">
                    <option value="">Year</option>
                  <?php for ($i = date('Y'); $i >= date('Y') - 100; $i--) {
                  echo "<option value=\"".$i."\">".$i."</option>";
                } ?>
                </select><br/>
                <label for="grade">Grade: </label><select name="grade">
                <option value="">Select Grade</option>
              <?php
              for ($i = -1; $i <= 12; $i++) {
                if ($studentInfo['grade'] == $i) {
                  $selected = "selected=selected";
                } else {
                  $selected = "";
                }
                if ($i == 0) {
                  $name = "Kindergarten";
                } elseif ($i == -1) {
                  $name = "Preschool";
                } else {
                  $name = $i;
                }
                echo "<option value=\"$i\" $selected>$name</option>";
              }
              ?>
            </select>
            </fieldset>

            <br/>
            <input type="hidden" name="birth_date" id="birth_date" value="<?php echo $studentInfo['birth_date']; ?>"/>
            <input type="hidden" name="family_id" value="<?php echo $family->getFamilyId(); ?>"/>
            <input type="hidden" name="campus_id" value="<?php echo $currentCampus->getCampusId(); ?>"/>
            <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>"/>
            <input type="hidden" name="<?php echo $submitField; ?>" value="1"/>
            <input type="submit" class="submitButton" style="float: right;" value="Save Student"/>
            <br/><br/><br/>
        </form>
</div>
<script type="text/javascript">
  $("#studentInfoForm").validate({
    rules:{
      first_name:"required",
      last_name:"required",
      email:"email",
      grade:"required",
      //age:"required",
      birthdate_day:"required",
      birthdate_month:"required",
      birthdate_year:"required",
      first_year:"required"
    }
  });
    $("#studentInfoForm").submit(function () {
        var birthDate = $("#birthdate_year").val() + "-" + $("#birthdate_month").val() + "-" + $("#birthdate_day").val();
        $("#birth_date").val(birthDate);
    });
    var birth_date = $("#birth_date").val().split("-");
    $("#birthdate_month").val(parseInt(birth_date[1]));
    $("#birthdate_day").val(parseInt(birth_date[2]));
    $("#birthdate_year").val(parseInt(birth_date[0]));
</script>