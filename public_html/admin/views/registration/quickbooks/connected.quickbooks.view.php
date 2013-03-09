<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="span9">
    <h1>Quickbooks Connection</h1>
  <?php if (isset($message)) { ?>
    <p style="text-align: center; color: red; font-weight: bold;"><?php echo $message; ?></p>
  <?php } ?>
    <p>This campus has been connected to Quickbooks. If you would like to use Quickbooks with this campus, you must
        enable it below.</p>

    <form action="" method="POST">
        <label for="quickbooks_enabled" style="width: 160px;">Quickbooks Status:</label> <select
            name="quickbooks_enabled">
        <option value="0" <?php if ($campusInfo['quickbooks_enabled'] == 0) {
          echo "selected=selected";
        } ?>>Disabled
        </option>
        <option value="1" <?php if ($campusInfo['quickbooks_enabled'] == 1) {
          echo "selected=selected";
        } ?>>Enabled
        </option>
    </select><br/>
        <label for="qb_paypal_payment_method_id" style="width: 200px;">PayPal Payment Method:</label><select
            name="qb_paypal_payment_method_id">
      <?php
      foreach ($paymentMethods as $method) {
        ?>
          <option value="<?php echo $method->getId(); ?>" <?php if ($campusInfo['qb_paypal_payment_method_id'] == $method->getId()) {
            echo "selected=selected";
          } ?>><?php echo $method->getName(); ?>
          </option>
        <?php
      }
      ?>
    </select><br/><label for="qb_creditmemo_account_id" style="width: 200px;">Credit Memo Account:</label><select
            name="qb_creditmemo_account_id">
      <?php
      foreach ($quickbooksAccounts as $account) {
        ?>
          <option value="<?php echo $account->getId(); ?>" <?php if ($campusInfo['qb_creditmemo_account_id'] == $account->getId()) {
            echo "selected=selected";
          } ?>><?php echo $account->getName(); ?>
          </option>
        <?php
      }
      ?>
    </select><br/><br/>
        <input type="hidden" name="saveQuickbooksStatus" value="1"/>
        <input type="submit" class="btn btn-primary" value="Save Configuration"/>
    </form>
    <p style="text-align: center;">
    </p>
</div>


