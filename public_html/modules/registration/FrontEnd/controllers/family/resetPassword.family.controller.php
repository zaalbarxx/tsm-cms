<?php
$family = new TSM_REGISTRATION_FAMILY;
if(isset($email) && isset($campus_id)){
	$status = $family->resetPassword($campus_id,$email);
	if($status==true){
		$_SESSION['flash'] = 'Email with link to change password has been sent on your e-mail.';
		header('Location:/');
	}
	else{
		$error = 'There was not account found with provided data. Try again.';
	}
}
elseif(isset($token) && isset($email)){
	$method = $_SERVER['REQUEST_METHOD'];
	$valid = $family->checkResetToken($email,$token);
	if($method == 'GET'){
		if($valid){
			$activeView = __TSM_ROOT__."modules/registration/FrontEnd/views/family/confirmResetPassword.family.view.php";
		}
		else{
			$_SESSION['flash'] = 'Token was either not valid or it expired. Try to reset password again.';
			header('Location:/');
		}
	}
	elseif($method =='POST'){
		if($family->changePassword($email,$password,$token)){
			$_SESSION['flash'] = 'Password has been successfully changed. You can log in now.';
			header('Location:/');
		}
		else{
			$error = 'There was no account found with provided token and email.';
		}

	}
}
