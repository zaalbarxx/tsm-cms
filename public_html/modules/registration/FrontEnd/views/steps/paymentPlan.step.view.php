<div class="contentArea">
    <a class="submitButton" href="index.php?com=registration&backToReview=1" style="float: right">Back to Review</a>

    <h1>Choose Payment Plan</h1>

    <p style="text-align: center;">Please choose a payment plan for each of the fee types below.</p>
  <?php if (isset($errorMessage)) {
  echo "<p style='text-align: center; color: red; font-weight: bold'>".$errorMessage."</p>";
} ?>
    <form action="" id="paymentPlans" method="post">
      <?php
      if (isset($feeTypes)) {
        foreach ($feeTypes as $feeType) {
          if ($feeType['total_amount'] > 0) {
            ?>
              <div class="half" <?php if (count($feeType['payment_plans']) == 1) {
                echo "style='display: none;'";
              } ?>>
                  <h2 style="text-align: center;"><?php echo $feeType['name']; ?></h2>
                  <label class="label" style="width: 200px;"><?php echo $feeType['name']; ?> Total:</label>
                  $<?php echo $feeType['total_amount']; ?>
                  <br/>
                  <label class="label" style="width: 200px;" for="fee_type_id_<?php echo $feeType['fee_type_id']; ?>">Payment
                      Plan: </label>
                  <select name="payment_plan_id_for_fee_type_id:<?php echo $feeType['fee_type_id']; ?>">
                      <option value="">Choose a Plan</option>
                    <?php foreach ($feeType['payment_plans'] as $plan) {
                    if (count($feeType['payment_plans']) == 1) {
                      $selected = "selected=selected";
                    } else {
                      $selected = "";
                    }
                    echo "<option value='".$plan['payment_plan_id']."' $selected>".$plan['name']."</option>";
                  } ?>
                  </select><br/><a
                      href="index.php?com=registration&action=viewAvailablePaymentPlans&fee_type_id=<?php echo $feeType['fee_type_id']; ?>"
                      class="fb paymentPlanHelp" style="position: relative; left: 120px;">see details</a>

              </div>
            <?php
          }
        }
      }
      ?>
        <input type="hidden" name="savePaymentPlans" value="1"/>
        <br style="width: 100%; clear: both;"/><br/><br/>
        <input type="submit" style="width: 200px; margin-left: 370px; " class="submitButton"
               value="Save Payment Plans"/>
        <br/><br/>
    </form>
</div>
<script type="text/javascript">
    $(document).ready()
</script>