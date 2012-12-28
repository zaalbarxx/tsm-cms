<h2>Registration Login</h2>
<div class="registrationLogin">
	<div class="half">
		<form name="familyLoginForm" method="post" action="">
			<label for="campus_id">Campus: <select id="campus_id" name="campus_id" class="select">
			<option value="">Select a Campus</option>
			<?php if(isset($campusList)){
				foreach($campusList as $campus){
					echo "<option value=\"".$campus['campus_id']."\">".$campus['name']."</option>";
				}
			} ?>
			</select>
			</label>
			<label for="email">E-mail Address:<br><input type="text" id="loginemail" name="email" value="" class="textbox"></label>
			<label for="password">Password: <br><input type="password" id="loginpassword" name="password" value="" class="textbox"></label>
			<input type="hidden" name="login" value="1">
			<input type="submit" value="Login" class="loginButton">
		</form>
		<div class="forgotPassword">
			<form action="http://www.artiosacademies.com/index.php?page=32&amp;resetpassword=1" method="POST">
			<label for="email_check">Forgot Password? <input type="text" name="email_check" value="Your e-mail address..." class="textbox" onfocus="this.value='';"></label>
			<input name="send_pass" value="1" type="hidden">
			<input type="submit" value="Submit" class="forgotPasswordButton">
			</form>
		</div>
	</div>

	<div class="half">
		<form name="familyRegistrationForm" method="post" action="http://www.artiosacademies.com/index.php?page=32&amp;registration=1">
		<label for="register_campus_id">Campus: <select id="register_campus_id" name="campuses_id" class="select">
		<option value="">Select a Campus</option>
		<?php if(isset($campusList)){
			foreach($campusList as $campus){
				echo "<option value=\"".$campus['campus_id']."\">".$campus['name']."</option>";
			}
		} ?>
		</select>
		</label>
		<label for="username">E-mail Address:<br><input type="text" id="registerusername" name="primary_email" class="textbox"></label>
		<label for="password1">Password: <br><input type="password" id="registerpassword1" name="password1" class="textbox"></label>
		<label for="password2">Confirm Password: <br><input type="password" id="registerpassword2" name="password2" class="textbox"></label>
		<input type="hidden" name="login" value="1">
		<input type="submit" value="Register Now" class="registerButton">
		</form>
	</div>
</div>
<style>
	.registrationLogin {
		background: url(images/registration_background.png);
		margin-left: auto;
		margin-right: auto;
		width: 566px;
		height: 304px;
	}
	.registrationLogin .forgotPassword {
		width: 240px;
		padding: 17px;
		padding-left: 22px;
	}
	.registrationLogin .select {
		padding: 5px;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		width: 237px;
		height: 30px;
		border: 1px solid black;
		background-color: white;
	}
	.registrationLogin label {
		display: block;
		margin-bottom: 4px;
		font-family: Tahoma, Geneva, sans-serif;
		font-weight: bold;
		font-size: 12px;
		color: #666;
	}
	.registrationLogin .textbox {
		font-size: 14px;
		padding: 3px;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		width: 228px;
		height: 20px;
		border: 1px solid black;
		background-color: white;
	}
	.registrationLogin .loginButton {
		background: url(images/login_button.png);
		height: 26px;
		width: 110px;
		border: 0px;
		display: block;
		float: right;
		cursor: pointer;
		margin-right: 5px;
	}
	.registrationLogin .forgotPassword {
		width: 240px;
		padding: 17px;
		padding-left: 22px;
	}
	.registrationLogin .forgotPassword .forgotPasswordButton {
		margin-top: -2px;
		float: left;
		background: url(images/submit.png);
		height: 24px;
		width: 63px;
		border: 0px;
		display: block;
		float: right;
		cursor: pointer;
	}
	.registrationLogin .forgotPassword .textbox {
		float: left;
		width: 160px;
	}
	.registrationLogin .registerButton {
		background: url(images/register.png);
		height: 26px;
		width: 110px;
		border: 0px;
		display: block;
		float: right;
		cursor: pointer;
		margin-right: 5px;
	}
</style>