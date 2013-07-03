<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
  <input id="searchItems" rel="smallItem" class="search-query" value="Search..."/>

  <h1>Unsent Invoices</h1>

  <span class="right"><label class="checkbox"><input id="checkAll" type="checkbox"> Check All</label></span>
  <br style="width: 100%; clear: both; "/>
  <br style="width: 100%; clear: both; "/>
      <span class="btn-group" style="float: right;" >
      <a class="btn fb" id="sendSelected" href="index.php?mod=registration&view=invoice&action=sendInvoices">Send Selected</a>
      <a class="btn" id="markAsSent" href="index.php?mod=registration&ajax=markInvoicesAsSent">Mark as Sent</a>
    </span>
  <form id="invoicesForm" method="post" action="index.php?mod=registration&ajax=bulkFeeInvoice&fee_id=<?php echo $fee_id; ?>">
    <?php
    if ($families) {
      foreach ($families as $family) {

        if(isset($family['invoices'])){
          echo "<h2>".$family['father_last']."</h2>";
          foreach($family['invoices'] as $invoice){
            ?>
            <div class="smallItem well well-small">
              <span class="title"><?php echo $invoice['invoice_description']." - $".$invoice['amount']." ($".$invoice['amount_paid']." Paid)"; ?></span>
            <span class="buttons">

            <input type="checkbox"
                   name="familyInvoices[]"
                   value="<?php echo $invoice['family_invoice_id']; ?>" data-tsm-amount="<?php echo $fee['amount']; ?>" />

            </span>
            </div>
          <?php
          }
        }


      }
    }
    ?>
    <div style="text-align: right; font-size: 20px">Plan Total: $<span id="planTotal"><?php echo $total; ?></span></div>
    <br />

    <br /><br />
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
  $("#markAsSent").click( function(){
    var data = $("#invoicesForm").serialize();
    $.post($(this).attr("href"), data, function (data) {
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
  $("#sendSelected").click( function(){
    var data = $("#invoicesForm").serialize();
    data = decodeURI(data);

    $.fancybox({
      'width'          : 985,
      'height'          : '85%',
      'padding'       : 5,
      'autoSize'    : false,
      'leftRatio' : .51,
      'helpers': {
        title: null
      },
      'type'				: 'iframe',
      'href' : $(this).attr("href") + "&" + data
    });

    return false;
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
  $(document).ready( function(){
    var totalAmount = 0;
    $("input:checkbox").not("#checkAll").each( function(){
      if($(this).attr("checked") == "checked"){
        totalAmount = totalAmount + parseFloat($(this).attr('data-tsm-amount'));
      }
    });
    $("#planTotal").html(totalAmount);
  });
</script>