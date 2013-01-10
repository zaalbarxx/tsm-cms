<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?></h2>
        <form method="post" action="index.php?com=registration&ajax=formSubmission">
            <fieldset>
                <label for="name">Fee Name: </label><input type="text" name="name"
                                                           value="<?php echo $feeInfo['name']; ?>"/><br/>
                <label for="fee_type_id">Fee Type: </label><select name="fee_type_id">
                <option value="1" <?php if ($feeInfo['fee_type_id'] == 1) {
                  echo "selected=selected";
                } ?>>Tuition
                </option>
                <option value="2" <?php if ($feeInfo['fee_type_id'] == 2) {
                  echo "selected=selected";
                } ?>>Registration Fee
                </option>
            </select><br/>
                <label for="amount">Amount: </label><input type="text" name="amount"
                                                           value="<?php echo $feeInfo['amount']; ?>"/><br/>
              <?php if ($currentCampus->usesQuickbooks()) { ?>
                <label for="quickbooks_item_id">Quickbooks Item: </label><select name="quickbooks_item_id">
                <?php
                foreach ($quickbooksItems as $item) {
                  $unitPrice = $item->getUnitPrice();
                  if (isset($unitPrice)) {
                    $price = $unitPrice->getAmount();
                  }
                  $id = $item->getId();
                  if ($id == $feeInfo['quickbooks_item_id']) {
                    $selected = " selected=selected";
                  } else {
                    $selected = "";
                  }
                  echo "<option value='".$id."' $selected>".$item->getName()." - $".$price."</option>";
                  //echo $item->getId()."--".$item->getName()."--$".$price."<br />";
                }
                ?>
                </select>
              <?php } ?>
            </fieldset>
            <br/>
            <input type="hidden" name="fee_id" value="<?php echo $feeInfo['fee_id']; ?>"/>
            <input type="hidden" name="campus_id" value="<?php echo $currentCampus->getCampusId(); ?>"/>
            <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>"/>
            <input type="hidden" name="school_year" value="<?php echo $reg->getSelectedSchoolYear(); ?>"/>
            <input type="hidden" name="formAction" value="<?php echo $formAction; ?>"/>
            <input type="submit" class="submitButton" style="margin-top: 20px; float: right;" value="Save Fee"/>
            <br/><br/><br/>
        </form>
</div>
<script type="text/javascript">
    $(".submitButton").click(function () {
        form = $(this).parent();
        submitData = form.serialize();
        $.post(form.attr('action'), submitData, function (data) {
            if (data == "0") {

            } else if (data == "1") {

            } else {
                //alert(data);
                window.parent.location = data;
            }
        });

        return false;
    });
</script>