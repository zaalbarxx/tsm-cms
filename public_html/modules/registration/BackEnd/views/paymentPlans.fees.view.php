<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
    <input id="searchItems" rel="smallItem" class="search-query" style="float: right; position: relative; top: 10px;"
           value="Search..."/>

    <h1>Payment Plans - <a class="btn btn-primary"
                           href="index.php?com=registration&view=fees&action=addEditPaymentPlan" class="addButton"
                           title="Add a Payment Plan">Add</a></h1>
  <?php
  if ($paymentPlans) {
    foreach ($paymentPlans as $plan) {
      ?>
        <div class="smallItem well well-small">
            <span class="title"><?php echo $plan['name']; ?> - <?php echo $plan['num_families']; ?></span>
          <span class="buttons">
          <a href="index.php?com=registration&view=fees&action=addEditPaymentPlan&payment_plan_id=<?php echo $plan['payment_plan_id']; ?>"
             class="editButton fb" title="Edit This Payment Plan"></a>
          <a href="index.php?com=registration&ajax=deletePaymentPlan&payment_plan_id=<?php echo $plan['payment_plan_id']; ?>"
             class="deleteButton" title="Delete Payment Plan"></a>
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