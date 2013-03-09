<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>

<div class="span9">
    <h1><?php echo $pageTitle; ?></h1>

    <form method="post" style="" action="">
        <fieldset>
            <label for="name">Requirement Name: </label><input type="text" name="name"
                                                               value="<?php echo $requirement['name']; ?>"/> (ex.
            Must Be In Highschool) <br/>
            <label for="requirement_type_id">Requirement Type: </label><select name="requirement_type_id"
                                                                               id="requirement_type_id">
            <option value="">Choose a Type</option>
          <?php
          foreach ($requirementTypes as $requirementType) {
            if ($requirementType['requirement_type_id'] == $requirement['requirement_type_id']) {
              $selected = "selected=selected";
            } else {
              $selected = "";
            }

            echo "<option value=\"".$requirementType['requirement_type_id']."\" ".$selected.">".$requirementType['name']."</option>";
          }
          ?>
        </select>

            <div id="requirementForm"></div>
        </fieldset>
        <input type="hidden" name="requirement_id" value="<?php echo $requirement['requirement_id']; ?>"/>
        <input type="hidden" name="school_year" value="<?php echo $reg->getSelectedSchoolYear(); ?>"/>
        <input type="hidden" name="campus_id" value="<?php echo $reg->getCurrentCampusId(); ?>"/>
        <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>"/>
        <input type="hidden" name="<?php echo $submitField; ?>" value="1"/>
        <input type="submit" class="btn btn-primary" style="margin-top: 20px;" value="Save Condition"/>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $.get("index.php?com=registration&view=requirements&action=getRequirementForm&requirement_type_id=" + $("#requirement_type_id").val() + "&requirement_id=<?php echo $requirement['requirement_id']; ?>", function (data) {
            $("#requirementForm").html(data);
        });
    });
    $("#requirement_type_id").change(function () {
        $.get("index.php?com=registration&view=requirements&action=getRequirementForm&requirement_type_id=" + $(this).val(), function (data) {
            $("#requirementForm").html(data);
        });
    });
</script>