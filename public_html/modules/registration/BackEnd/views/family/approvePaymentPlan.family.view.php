<div class="span9">
  <h2>Approve Payment Plan</h2>
  <p>Approving this plan will being the invoicing process for the fees below.</p>
  <?php foreach($students as $student){
    echo "<h3>".$student['info']['first_name']."".$student['last_name']."</h3>";
    foreach($student['fees'] as $fee){
      ?>
      <div class="well well-small">
        <div class="title"><?php echo $fee['name']; ?>: $<?php echo $fee['amount']; ?></div>
      </div>
      <?php
    }
  } ?>
  <div style="text-align: right; font-size: 20px">Plan Total: $<?php echo $total; ?></div>
  <br />
  <span class="center">
    <a class="btn btn-success btn-large right approvePlan" href="index.php?com=registration&ajax=approveFamilyPaymentPlan&family_payment_plan_id=<?php echo $familyPaymentPlanId; ?>&fb=1">Approve Plan</a>
  </span>
</div>
<script type="text/javascript">
  $(".approvePlan").click( function(){
    $.get($(this).attr("href"), function (data) {
      var response = JSON.parse(data);
      if (response.alertMessage != null) {
        alert(response.alertMessage);
      }
      if (response.success == true) {
        parent.window.location.reload();
      }
    });
    return false;
  });
</script>