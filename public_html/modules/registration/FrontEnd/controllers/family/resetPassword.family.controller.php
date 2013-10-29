<?php
$family = new TSM_REGISTRATION_FAMILY;
if(isset($email) && isset($campus_id)){
	$status = $family->resetPassword($campus_id,$email);
	if($status==true){
		$_SESSION['flash'] = 'A link to change you password has been sent on your e-mail address. Please check your e-mail.';
		header('Location:/');
	}
	else{
		$error = 'We could not find an account associated with the e-mail address you provided. Please try again.';
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
			$_SESSION['flash'] = 'The token was either invalid or it has expired. Please try to reset the password again.';
			header('Location:/');
		}
	}
	elseif($method =='POST'){
		if($family->changePassword($email,$password,$token)){
			$_SESSION['flash'] = 'Your password has been successfully changed. Please login using the login form.';
			header('Location:/');
		}
		else{
			$error = 'There was no account found with the provided token and email.';
		}

	}
}
