<script src="../includes/3rdparty/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/3rdparty/ckeditor/adapters/jquery.js"></script>
<div class="span9">
  <h2>E-mail Invoice</h2>
  <p>Please edit the e-mail you would like to send below.</p>
  <form id="emailInvoiceForm" action="index.php?mod=registration&ajax=sendInvoices">
    <label for="email_subject">Email Subject: </label><input type="text" name="email_subject"
                                                             value=""/>
    <textarea name="email_contents" class="editor"/>{{name}},<br /><br /></textarea>
    <script type="text/javascript">
      $('textarea.editor').ckeditor();
    </script>
    <br />
    <?php
    foreach($familyInvoices as $family_invoice_id){
      ?>
      <input type="hidden" name="invoicesToSend[]" value="<?php echo $family_invoice_id; ?>" />
      <?php
    }
    ?>
    <input type="submit" value="Send Invoice" class="btn btn-primary right"/>
  </form>
</div>
<script type="text/javascript">
  $("#emailInvoiceForm").submit( function(){
    var formData = $("#emailInvoiceForm").serialize();
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
