<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<script src="../includes/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/ckeditor/adapters/jquery.js"></script>
<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?></h1>

    <form method="post" action="index.php?com=registration&ajax=formSubmission">
        <fieldset>
            <label for="plan_name">Plan Name: </label><input type="text" name="name" id="plan_name"
                                                             value="<?php echo $planInfo['name']; ?>"/><br/>
            <label for="fee_type_id">Available To: </label>
            <select name="fee_type_id" id="fee_type_id">
                <option value="">All Fee Types</option>
              <?php
              if (isset($feeTypes)) {
                foreach ($feeTypes as $feeType) {
                  if ($feeType['fee_type_id'] == $planInfo['fee_type_id']) {
                    $selected = "selected=selected";
                  } else {
                    $selected = "";
                  }
                  echo "<option value=\"".$feeType['fee_type_id']."\" $selected>".$feeType['name']."</option>";
                }
              }
              ?>
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
            <option value="3" <?php if ($planInfo['payment_plan_type_id'] == 3) {
              echo "selected=selected";
            } ?>>Single Payment
            </option>
            <option value="4" <?php if ($planInfo['payment_plan_type_id'] == 4) {
              echo "selected=selected";
            } ?>>Part now / part later
            </option>
        </select><br/><br/>
          <span id="partNow_partLater" class="planDetails" style="display: none;">
            <b>Plan Details</b>
              <p>Invoice <input type="textbox" name="immediate_invoice_percentage"
                                value="<?php echo $planInfo['immediate_invoice_percentage']; ?>" size=2/>% now followed
                  by invoicing every
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
                  invoice(s) beginning on <select name="start-month" class="start-month">
                  <?php
                  for ($i = 1; $i <= 12; $i++) {
                    $name = $tsm->intToMonth($i);
                    echo "<option value=\"$i\">$name</option>";
                  }
                  ?>
                  </select>/
                  <select name="start-day" class="start-day">
                    <?php
                    for ($i = 1; $i <= 31; $i++) {
                      $name = $i;
                      echo "<option value=\"$i\">$name</option>";
                    }
                    ?>
                  </select>/
                  <select name="start-year" class="start-year">
                    <?php
                    for ($i = date('Y') - 5; $i <= date('Y') + 5; $i++) {
                      if ($i == date('Y')) {
                        $selected = "selected=selected";
                      } else {
                        $selected = "";
                      }
                      $name = $i;
                      echo "<option value=\"$i\" $selected>$name</option>";
                    }
                    ?>
                  </select>.</p>
          </span>
      <span id="monthly_plan" class="planDetails" style="display: none;">
				<b>Plan Details</b>
				<p>Once family is approved, beginning
            <select name="start-month" class="start-month">
              <?php
              for ($i = 1; $i <= 12; $i++) {
                $name = $tsm->intToMonth($i);
                echo "<option value=\"$i\">$name</option>";
              }
              ?>
            </select>/
            <select name="start-day" class="start-day">
              <?php
              for ($i = 1; $i <= 31; $i++) {
                $name = $i;
                echo "<option value=\"$i\">$name</option>";
              }
              ?>
            </select>/
            <select name="start-year" class="start-year">
              <?php
              for ($i = date('Y') - 5; $i <= date('Y') + 5; $i++) {
                if ($i == date('Y')) {
                  $selected = "selected=selected";
                } else {
                  $selected = "";
                }
                $name = $i;
                echo "<option value=\"$i\" $selected>$name</option>";
              }
              ?>
            </select>

            invoice every
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
            invoice(s).</p>
      </span>

        </fieldset>
        <label for="description">Description: </label>
        <textarea name="description" id="description" class="editor"/><?php echo $planInfo['description']; ?></textarea>
        <label for="description">Disclaimer: </label>
        <textarea name="disclaimer" id="disclaimer" class="editor"/><?php echo $planInfo['disclaimer']; ?></textarea>
        <script type="text/javascript">
            $('textarea.editor').ckeditor();
        </script>
        <br/>
        <input type="hidden" class="nodelete" name="start_date" id="start_date"
               value="<?php echo $planInfo['start_date']; ?>"/>
        <input type="hidden" class="nodelete" name="payment_plan_id"
               value="<?php echo $planInfo['payment_plan_id']; ?>"/>
        <input type="hidden" class="nodelete" name="campus_id" value="<?php echo $currentCampus->getCampusId(); ?>"/>
        <input type="hidden" class="nodelete" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>"/>
        <input type="hidden" class="nodelete" name="school_year" value="<?php echo $reg->getSelectedSchoolYear(); ?>"/>
        <input type="hidden" class="nodelete" name="formAction" value="<?php echo $formAction; ?>"/>
        <input type="submit" class="submitButton" style="margin-top: 20px; float: right;"
               value="Save Payment Plan"/>
        <br/><br/><br/>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        if ($("#payment_plan_type_id").val() == 2) {
            $("#monthly_plan").show();
        } else if ($("#payment_plan_type_id").val() == 4) {
            $("#partNow_partLater").show();
        }

        $("#payment_plan_type_id").change(function () {
            $(".planDetails").hide();
            if ($(this).val() == 2) {
                $("#monthly_plan").show();
            } else if ($(this).val() == 4) {
                $("#partNow_partLater").show();
            }
        });
        var startDates = $("#start_date").val().split("-");
        $(".start-year").val(parseInt(startDates[0]));
        $(".start-month").val(parseInt(startDates[1]));
        $(".start-day").val(parseInt(startDates[2]));
    });
    $(".submitButton").click(function () {
        if ($("#monthly_plan").is(":hidden")) {
            $("#monthly_plan").remove();
        } else if ($("#partNow_partLater").is(":hidden")) {
            $("#partNow_partLater").remove();
        }

        var start_date = $(".start-year").val() + "-" + $(".start-month").val() + "-" + $(".start-day").val();
        $("#start_date").val(start_date);
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