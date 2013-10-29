<div class="span9">
  <input id="searchItems" rel="smallItem" class="search-query" value="Search..."/>

  <h1>Bulk Invoice</h1>

  <span class="right"><label class="checkbox"><input id="checkAll" type="checkbox" checked=checked> Check All</label></span>
  <br style="width: 100%; clear: both; "/>
  <br style="width: 100%; clear: both; "/>
  <form id="bulkAssign" method="post" action="index.php?mod=registration&ajax=bulkFeeInvoice&fee_id=<?php echo $fee_id; ?>">
    <?php
    if ($families) {
      foreach ($families as $family) {

        if(isset($family['fees'])){
          echo "<h2>".$family['father_last'].$family['finalized']."</h2>";
          foreach($family['fees'] as $fee){
            $student = $family['students'][$fee['student_id']];
            ?>
            <div class="smallItem well well-small">
              <span class="title"><?php echo $student['last_name'].", ".$student['first_name'].": ".$fee['name']." - $".$fee['amount']; ?></span>
            <span class="buttons">

            <input type="checkbox"
                   name="invoiceFamily[<?php echo $family['family_id']; ?>][]"
                   value="<?php echo $fee['family_fee_id']; ?>" data-tsm-amount="<?php echo $fee['amount']; ?>" checked=checked/>

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
    <span class="center">
      <div class="right"><input type="text" name="invoice_description" placeholder="Invoice Description" /><br />
        <input type="text" name="due_date" placeholder="Due Date (YYYY-MM-DD)" /></div>
      <br style="width: 100%; clear: both" />
    </span>
    <input type="submit" class="btn btn-primary" value="Invoice Now" style="float: right;" />
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
  $("#bulkAssign").submit( function(){
    var data = $("#bulkAssign").serialize();
    $.post($(this).attr("action"), data, function (data) {
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