<?php 
if(isset($_POST['father_first']) && count($_POST)==12){
	if($family->editInfo($_POST)){
		header('Location:index.php?mod=registration');
	}
	else{
		$error = 'error';
	}
}
$familyInfo = $family->getInfo(true);
