<?php
require_once(__TSM_ROOT__."admin/views/registration/fees.sidebar.view.php");
?>

<div class="span9">
    <h1><?php echo $pageTitle; ?></h2>
        <form method="post" style="" action="">
            <fieldset>
                <label for="name">Condition Name: </label><input type="text" name="name"
                                                                 value="<?php echo $condition['name']; ?>"/> (ex. Must
                Be In Highschool) <br/>
                <label for="fee_condition_type_id">Condition Type: </label><select name="fee_condition_type_id"
                                                                                   id="fee_condition_type_id">
                <option value="">Choose a Type</option>
              <?php
              foreach ($feeConditionTypes as $feeConditionType) {
                if ($feeConditionType['fee_condition_type_id'] == $condition['fee_condition_type_id']) {
                  $selected = "selected=selected";
                } else {
                  $selected = "";
                }

                echo "<option value=\"".$feeConditionType['fee_condition_type_id']."\" ".$selected.">".$feeConditionType['name']."</option>";
              }
              ?>
            </select>

                <div id="conditionForm"></div>
            </fieldset>
            <input type="hidden" name="fee_condition_id" value="<?php echo $condition['fee_condition_id']; ?>"/>
            <input type="hidden" name="school_year" value="<?php echo $reg->getSelectedSchoolYear(); ?>"/>
            <input type="hidden" name="campus_id" value="<?php echo $reg->getCurrentCampusId(); ?>"/>
            <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>"/>
            <input type="hidden" name="<?php echo $submitField; ?>" value="1"/>
            <input type="submit" class="btn btn-primary" style="margin-top: 20px;" value="Save Condition"/>
        </form>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $.get("index.php?com=registration&view=fees&action=getConditionForm&fee_condition_type_id=" + $("#fee_condition_type_id").val() + "&fee_condition_id=<?php echo $condition['fee_condition_id']; ?>", function (data) {
            $("#conditionForm").html(data);
        });
    });
    $("#fee_condition_type_id").change(function () {
        $.get("index.php?com=registration&view=fees&action=getConditionForm&fee_condition_type_id=" + $(this).val(), function (data) {
            $("#conditionForm").html(data);
        });
    });
</script>