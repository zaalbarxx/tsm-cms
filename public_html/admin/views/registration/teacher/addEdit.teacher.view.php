<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="span9">
    <h1><?php echo $pageTitle; ?></h2>
      <?php if (isset($errorMessage)) {
        echo "<span style='text-align: center; font-weight:bold; margin-bottom: 20px; display: block; color: red;'>".$errorMessage."</span>";
      } ?>
        <form method="post">

            <fieldset>
              <?php if (!isset($teacher_id)) { ?>
                <label for="add_type">Add Type: </label>
                <select name="add_type" id="add_type">
                    <option value="">Choose One</option>
                    <option value="1">Previous School Year</option>
                    <option value="2">New Teacher</option>
                </select><br/>
              <?php } ?>
                <div id="oldTeacher" style="display: none;">
                    <label for="addTeacher">Teacher Name: </label><select name="addTeacher" id="addTeacher">
                  <?php foreach ($teachers as $teacher) { ?>
                    <option value="<?php echo $teacher['teacher_id']; ?>"><?php echo $teacher['first_name']." ".$teacher['last_name']; ?></option>
                  <?php } ?>
                </select>
                </div>
                <div id="newTeacher">
                    <label for="first_name">First Name: </label><input type="text" name="first_name"
                                                                       value="<?php echo $teacherInfo['first_name']; ?>"/><br/>
                    <label for="last_name">Last Name: </label><input type="text" name="last_name"
                                                                     value="<?php echo $teacherInfo['last_name']; ?>"/><br/>
                </div>
            </fieldset>
            <br/>
            <input type="hidden" name="teacher_id" value="<?php echo $teacherInfo['teacher_id']; ?>"/>
            <input type="hidden" name="campus_id" value="<?php echo $currentCampus->getCampusId(); ?>"/>
            <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>"/>
            <input type="hidden" name="school_year" value="<?php echo $reg->getSelectedSchoolYear(); ?>"/>
            <input type="hidden" name="<?php echo $formAction; ?>" value="1"/>
            <input type="submit" class="btn btn-primary" style="margin-top: 20px; float: right;" value="Save Teacher"/>
            <br/><br/><br/>
        </form>
</div>
<script type="text/javascript">
    $("#add_type").change(function () {
        if ($(this).val() == 1) {
            $("#oldTeacher").show();
            $("#newTeacher").hide();
        } else if ($(this).val() == 2) {
            $("#oldTeacher").hide();
            $("#newTeacher").show();
        }
    })
</script>