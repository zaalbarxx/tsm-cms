<?php
require_once(__TSM_ROOT__."admin/views/registration/fees.sidebar.view.php");
?>
<div class="contentWithSideBar">
    <input id="searchItems" rel="smallItem" style="float: right; position: relative; right: 75px; top: 10px;"
           value="Search..."/>

    <h1>Fee Conditions</h1>
        <span style="float: right; margin-top: -45px; right: 20px; position: relative;"><a
                href="index.php?com=registration&view=fees&action=addEditCondition" class="addButton"
                title="Add a Condition"></a></span>
  <?php
  if ($conditionsList) {
    foreach ($conditionsList as $condition) {
      ?>
        <div class="smallItem">
            <span class="title"><?php echo $condition['name']; ?></span>
                <span class="buttons"><a
                        href="index.php?com=registration&view=fees&action=addEditCondition&fee_condition_id=<?php echo $condition['fee_condition_id']; ?>"
                        class="editButton" title="Edit This Condition"></a><a
                        href="index.php?com=registration&view=fees&action=deleteFee&fee_id=<?php echo $condition['fee_condition_id']; ?>"
                        class="deleteButton" title="Delete Condition"></a><a
                        href="index.php?com=registration&view=fees&action=addConditionToFees&fee_condition_id=<?php echo $condition['fee_condition_id']; ?>"
                        class="addButton fb" title="Add To Fees"></a></span>
        </div>
      <?php
    }
  }
  ?>
</div>