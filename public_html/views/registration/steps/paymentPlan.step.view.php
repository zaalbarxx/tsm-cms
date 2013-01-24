<div class="contentArea">
    <h1>Choose Payment Plan</h1>

    <p style="text-align: center;">Please choose a payment plan for both your tuition and registration fees.</p>
  <?php if (isset($errorMessage)) {
  echo "<p style='text-align: center; color: red; font-weight: bold'>".$errorMessage."</p>";
} ?>
    <form action="" id="paymentPlans" method="post">
        <div class="half">
            <h2 style="text-align: center;">Registration Fees</h2>
            <label class="label" style="width: 200px;">Registration Total:</label> $<?php echo $registrationTotal; ?>
            <br/>
            <label class="label" style="width: 200px;" for="fee_type_id_2">Payment Plan: </label>
            <select name="fee_type_id_2" class="fee_type_id">
                <option value="">Choose a Plan</option>
              <?php foreach ($regPaymentPlans as $plan) {
              echo "<option value='".$plan['payment_plan_id']."'>".$plan['name']."</option>";
            } ?>

            </select>

        </div>
        <div class="half">
            <h2 style="text-align: center;">Tuition Fees</h2>
            <label class="label" style="width: 200px;">Tuition Total:</label> $<?php echo $tuitionTotal; ?><br/>
            <label class="label" style="width: 200px;" for="fee_type_id_1">Payment Plan: </label>
            <select name="fee_type_id_1" class="fee_type_id">
                <option value="">Choose a Plan</option>
              <?php foreach ($tuitionPaymentPlans as $plan) {
              echo "<option value='".$plan['payment_plan_id']."'>".$plan['name']."</option>";
            } ?>
            </select>
        </div>
        <input type="hidden" name="savePaymentPlans" value="1"/>
        <br style="width: 100%; clear: both;"/><br/><br/>
        <input type="submit" style="width: 200px; margin-left: 370px; " class="submitButton"
               value="Save Payment Plans"/>
        <br/><br/>
    </form>
</div>
<script type="text/javascript">

</script>