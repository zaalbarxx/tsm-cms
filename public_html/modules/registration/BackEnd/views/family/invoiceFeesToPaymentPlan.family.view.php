<div class="span9">
  <form action="index.php?mod=registration&ajax=invoiceFeesToFamilyPaymentPlan&family_payment_plan_id=<?php echo $familyPaymentPlanId; ?>" method="post" id="paymentPlanForm">
    <h2>Invoice Fees To Payment Plan</h2>
    <p>Invoicing fees to this payment plan will add these fees to this payment plan and immediate invoice them in a separate invoice. If you do not want to invoice a certain fee to this payment plan, just uncheck the corresponding box.</p>
    <span class="right"><label class="checkbox"><input id="checkAll" type="checkbox" checked=checked> Check All</label></span>
    <?php foreach($students as $student){
      echo "<h3>".$student['info']['first_name']."".$student['last_name']."</h3>";
      foreach($student['fees'] as $fee){
        ?>
        <div class="well well-small">
          <div class="title"><?php echo $fee['name']; ?>: $<?php echo $fee['amount']; ?></div><input style="float: right; margin-top: -18px;" type="checkbox" class="feesToAdd" name="feesToAdd[]" data-tsm-amount="<?php echo $fee['amount']; ?>" value="<?php echo $fee['family_fee_id']; ?>" checked=checked/>
        </div>
        <?php
      }
    } ?>
    <div style="text-align: right; font-size: 20px">Invoice Total: $<span id="planTotal"><?php echo $total; ?></span></div>
    <br />
    <span class="center">
      <div class="right"><input type="text" name="invoice_description" placeholder="Invoice Description" /></div>
      <br style="width: 100%; clear: both" />
      <input type="submit" class="btn btn-success btn-large right approvePlan" value="Invoice Now" />
    </span>
  </form>
</div>
<script type="text/javascript">
  $(document).ready( function(){
    $('#checkAll').click(function(){
      if($(this).attr('checked') == 'checked'){
        $('input:checkbox').attr('checked','checked');
      } else {
        $('input:checkbox').removeAttr('checked');
      }
    });
    $('input:checkbox').click( function(){
      var totalAmount = 0;
      $("input:checkbox").not("#checkAll").each( function(){
        if($(this).attr("checked") == "checked"){
          totalAmount = totalAmount + parseFloat($(this).attr('data-tsm-amount'));
        }
      });
      $("#planTotal").html(totalAmount);
    });
  });
  $("#paymentPlanForm").submit( function(){
    var formData = $("#paymentPlanForm").serialize();
    $.post($(this).attr("action"), formData, function (data) {
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