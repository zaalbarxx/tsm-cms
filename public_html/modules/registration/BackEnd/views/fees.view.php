<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
    <input id="searchItems" rel="smallItem" class="search-query" value="Search..."/>

    <h1>Fees - <a href="index.php?mod=registration&view=fees&action=addEditFee" class="btn btn-primary"
                  title="Add a Fee">Add</a></h1>

  <?php
  if ($feesList) {
    foreach ($feesList as $fee) {
      ?>
        <div class="smallItem well well-small">
            <span class="title"><?php echo $fee['name']; ?> - $<?php echo $fee['amount']; ?></span>
          <span class="btn-group">
            <a href="index.php?mod=registration&view=fees&action=bulkStudentAssign&fee_id=<?php echo $fee['fee_id']; ?>" class="fb btn btn-primary btn-small">Bulk Assign</a>
            <a href="index.php?mod=registration&view=fees&action=bulkFeeInvoice&fee_id=<?php echo $fee['fee_id']; ?>" class="fb btn btn-primary btn-small">Bulk Invoice</a>
          </span>
          <span class="buttons">

          <a href="index.php?mod=registration&view=fees&action=addEditFee&fee_id=<?php echo $fee['fee_id']; ?>"
             class="editButton fb" title="Edit This Fee"></a>
          <a href="index.php?mod=registration&ajax=deleteFee&fee_id=<?php echo $fee['fee_id']; ?>" class="deleteButton"
             title="Delete Fee"></a>
          </span>
        </div>
      <?php
    }
  }
  ?>
</div>
<script type="text/javascript">
    $(".deleteButton").click(function () {
        $.get($(this).attr('href'), function (data) {
            if (data == "1") {
                window.location.reload();
            } else {
                alert("Fees cannot yet be deleted. This feature is not yet complete.");
            }
        });
        return false;
    });
</script>