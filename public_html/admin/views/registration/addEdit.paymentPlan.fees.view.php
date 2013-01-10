<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?></h2>
        <form method="post" action="index.php?com=registration&ajax=formSubmission">
            <fieldset>
                <label for="name">Plan Name: </label><input type="text" name="name"
                                                            value="<?php echo $planInfo['name']; ?>"/><br/>
                <label for="fee_type_id">Applies To: </label><select name="fee_type_id">
                <option value="1" <?php if ($planInfo['fee_type_id'] == 1) {
                  echo "selected=selected";
                } ?>>Tuition
                </option>
                <option value="2" <?php if ($planInfo['fee_type_id'] == 2) {
                  echo "selected=selected";
                } ?>>Registration Fees
                </option>
                <option value="" <?php if ($planInfo['fee_type_id'] == 1) {
                  echo "selected=selected";
                } ?>>Everything
                </option>
            </select><br/>
                <label for="payment_plan_type_id">Invoice: </label><select name="payment_plan_type_id"
                                                                           id="payment_plan_type_id">
                <option value="1" <?php if ($planInfo['payment_plan_type_id'] == 1) {
                  echo "selected=selected";
                } ?>>Immediately
                </option>
                <option value="2" <?php if ($planInfo['payment_plan_type_id'] == 2) {
                  echo "selected=selected";
                } ?>>Monthly
                </option>
            </select><br/><br/>
      <span id="monthly_plan" class="planDetails" style="display: none;">
				<b>Plan Details</b>
				<p>After Family Approval, invoice every
            <select name="invoice_frequency">
              <?php for ($i = 1; $i <= 12; $i++) {
              if ($i == $planInfo['invoice_frequency']) {
                $selected = " selected=selected";
              } else {
                $selected = null;
              }
              echo "<option value=\"$i\"$selected>$i</option>";

            } ?>
            </select>
            month(s) for
            <select name="num_invoices">
              <?php for ($i = 1; $i <= 12; $i++) {
              if ($i == $planInfo['num_invoices']) {
                $selected = " selected=selected";
              } else {
                $selected = null;
              }
              echo "<option value=\"$i\"$selected>$i</option>";

            } ?>
            </select>
            invoice(s) beginning immediately.</p>
      </span>
            </fieldset>
            <br/>
            <input type="hidden" name="payment_plan_id" value="<?php echo $planInfo['payment_plan_id']; ?>"/>
            <input type="hidden" name="campus_id" value="<?php echo $currentCampus->getCampusId(); ?>"/>
            <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>"/>
            <input type="hidden" name="school_year" value="<?php echo $reg->getSelectedSchoolYear(); ?>"/>
            <input type="hidden" name="formAction" value="<?php echo $formAction; ?>"/>
            <input type="submit" class="submitButton" style="margin-top: 20px; float: right;"
                   value="Save Payment Plan"/>
            <br/><br/><br/>
        </form>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        if ($("#payment_plan_type_id").val() == 2) {
            $("#monthly_plan").show();
        }

        $("#payment_plan_type_id").change(function () {
            $(".planDetails").hide();
            if ($(this).val() == 2) {
                $("#monthly_plan").show();
            }
        });
    });
    $(".submitButton").click(function () {
        form = $(this).parent();
        submitData = form.serialize();
        $.post(form.attr('action'), submitData, function (data) {
            if (data == "0") {

            } else if (data == "1") {

            } else {
                //alert(data);
                window.parent.location = data;
            }
        });

        return false;
    });
</script>