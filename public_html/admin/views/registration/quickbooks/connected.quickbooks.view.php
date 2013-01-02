<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
  <h1>Quickbooks Connection</h2>
  <?php if(isset($message)) { ?>
  <p style="text-align: center; color: red; font-weight: bold;"><?php echo $message; ?></p>
  <?php } ?>
  <p>This campus has been connected to Quickbooks. If you would like to use Quickbooks with this campus, you must enable it below.</p>
  <form action="" method="POST">
  	<label for="quickbooks_enabled" style="width: 160px;">Quickbooks Status:</label> <select name="quickbooks_enabled">
  		<option value="0" <?php if($campusInfo['quickbooks_enabled'] == 0){ echo "selected=selected"; } ?>>Disabled</option>
  		<option value="1" <?php if($campusInfo['quickbooks_enabled'] == 1){ echo "selected=selected"; } ?>>Enabled</option>
  	</select>
  	<input type="hidden" name="saveQuickbooksStatus" value="1" />
  	<input type="submit" class="submitButton" value="Save Status" />
  </form>
  <p style="text-align: center;">
  </p>
</div>


