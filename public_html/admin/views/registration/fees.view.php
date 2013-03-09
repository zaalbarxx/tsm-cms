<?php
require_once(__TSM_ROOT__."admin/views/registration/fees.sidebar.view.php");
?>
<div class="span9">
    <input id="searchItems" rel="smallItem" class="search-query" style="float: right; position: relative; top: 10px;"
           value="Search..."/>

    <h1>Fees</h1>
        <span style="float: right; margin-top: -45px; right: 20px; position: relative;"><a
                href="index.php?com=registration&view=fees&action=addEditFee" class="addButton"
                title="Add a Fee"></a></span>
  <?php
  if ($feesList) {
    foreach ($feesList as $fee) {
      ?>
        <div class="smallItem well well-small">
            <span class="title"><?php echo $fee['name']; ?> - $<?php echo $fee['amount']; ?></span>
          <span class="buttons">
          <a href="index.php?com=registration&view=fees&action=addEditFee&fee_id=<?php echo $fee['fee_id']; ?>"
             class="editButton fb" title="Edit This Fee"></a>
          <a href="index.php?com=registration&ajax=deleteFee&fee_id=<?php echo $fee['fee_id']; ?>" class="deleteButton"
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