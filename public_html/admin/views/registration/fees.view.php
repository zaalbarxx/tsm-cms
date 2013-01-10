<?php
require_once(__TSM_ROOT__."admin/views/registration/fees.sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1>Fees</h2>
        <span style="float: right; margin-top: -45px; right: 20px; position: relative;"><a
                href="index.php?com=registration&view=fees&action=addEditFee" class="addButton"
                title="Add a Fee"></a></span>
      <?php
      if ($feesList) {
        foreach ($feesList as $fee) {
          ?>
            <div class="smallItem">
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