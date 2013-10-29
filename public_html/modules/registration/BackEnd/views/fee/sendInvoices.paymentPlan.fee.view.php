<script src="../includes/3rdparty/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/3rdparty/ckeditor/adapters/jquery.js"></script>
<div class="span9">
  <h2>Send Invoices</h2>
  <span class="right"><label class="checkbox"><input id="checkAll" type="checkbox" checked=checked> Check All</label></span>
  <p>Please select the invoices you would like to send.</p>
  <form action="index.php?mod=registration&ajax=sendInvoices&payment_plan_id=<?php echo $payment_plan_id; ?>" method="post" id="sendInvoicesForm">

    <?php
  foreach($invoiceInfos as $invoice){
    $invoiceObject = $invoiceObjects[$invoice['family_invoice_id']];
    $familyObject = $familyObjects[$invoice['family_id']];
    $timesSent = $invoice['times_sent'];
    ?>
    <div class="smallItem well well-small">
      <span class="title"><?php echo $familyObject->getDisplayName(); ?>: <br />
        <?php echo $invoice['invoice_description']; ?><br />
        Amt Due: $<?php echo number_format($invoiceObject->getAmountDue(),2); ?>
      <br />Sent <?php echo $timesSent; ?> time(s).
      </span>
      <input style="float: right; " type="checkbox" class="invoicesToSend" name="invoicesToSend[]" value="<?php echo $invoice['family_invoice_id']; ?>" checked=checked/>
    </div>
    <?php
  }
  ?>
    <br />
    <label for="email_subject">Email Subject: </label><input type="text" name="email_subject"
                                                             value="<?php echo $emailSubject; ?>"/>
    <textarea name="email_contents" class="editor"/><?php echo $emailContents; ?></textarea>
    <script type="text/javascript">
      $('textarea.editor').ckeditor();
    </script>


    <span class="center">
      <input type="submit" class="btn btn-success btn-large right sendInvoices" value="Send Invoices" />
    </span>
    </form>

</div>
<script type="text/javascript">
  $('#checkAll').click(function(){
    if($(this).attr('checked') == 'checked'){
      $('input:checkbox').attr('checked','checked');
    } else {
      $('input:checkbox').removeAttr('checked');
    }
  });
  $("#sendInvoicesForm").submit( function(){
    var formData = $("#sendInvoicesForm").serialize();
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