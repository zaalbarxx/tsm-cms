<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
    <h1><?php echo $pageTitle; ?></h1>

    <p>Please use the list below to select which QuickBooks item each fee should be associated with. Each fee can only
        be associated with one item.</p>

    <form action="" method="post" id="qbInfo" class="form-inline">
      <?php
      if (isset($fees)) {
        foreach ($fees as $fee) {
          ?>
            <div class="well well-small">
                <label><strong><?php echo $fee['name']; ?>:</strong></label> <select class="pull-right"
                                                                                     name="fee_id:<?php echo $fee['fee_id']; ?>:quickbooks_item_id">
              <?php
              foreach ($quickbooksItems2 as $item) {
                //$item = new QuickBooks_IPP_Object_Item();

                if ($item['id'] == $fee['quickbooks_item_id']) {
                  $selected = " selected=selected";
                } else {
                  $selected = "";
                }

                echo "<option value='".$item['id']."' $selected>".$item['name']." - $".$item['price']."</option>";
              }
              ?>
            </select>
            </div>

          <?php
        }
      }
      ?>
        <input type="hidden" name="saveAll" value="1"/>
        <input type="submit" class="btn btn-primary" style="margin-top: 20px; float: right;" value="Save All"/>
        <br/><br/>
    </form>
</div>