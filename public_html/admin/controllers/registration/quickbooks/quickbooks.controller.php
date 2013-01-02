<?php
if(isset($action)){
	switch($action){
		case "connect":
      require_once(__TSM_ROOT__."admin/controllers/registration/quickbooks/connect.quickbooks.controller.php"); 
			break;
		case "connected":
      require_once(__TSM_ROOT__."admin/controllers/registration/quickbooks/connected.quickbooks.controller.php"); 
      $activeView = __TSM_ROOT__."admin/views/registration/quickbooks/connected.quickbooks.view.php";
			break;
	}
} else {
	if($quickbooks->creds == null){
		$activeView = __TSM_ROOT__."admin/views/registration/quickbooks/quickbooks.view.php";
	} else {
		require_once(__TSM_ROOT__."admin/controllers/registration/quickbooks/connected.quickbooks.controller.php"); 
		$activeView = __TSM_ROOT__."admin/views/registration/quickbooks/connected.quickbooks.view.php";
	}
}



?>
