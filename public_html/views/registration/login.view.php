<!--<h2>Registration Login</h2>-->
<div class="registrationLogin">
    <div class="half">
        <form name="familyLoginForm" method="post" action="">
            <h3>Current Families</h3>
          <?php if (isset($error)) {
          echo "<span class=\"errorMessage\">".$error."</span><br /><br />";
        } ?>
            <label for="campus_id">Campus: <select id="campus_id" name="campus_id" class="select">
                <option value="">Select a Campus</option>
              <?php if (isset($campusList)) {
              foreach ($campusList as $campus) {
                echo "<option value=\"".$campus['campus_id']."\">".$campus['name']."</option>";
              }
            } ?>
            </select>
            </label>
            <label for="email">E-mail Address:<br><input type="text" id="loginemail" name="email" value=""
                                                         class="textbox" autocomplete="off"></label>
            <label for="password">Password: <br><input type="password" id="loginpassword" name="password" value=""
                                                       class="textbox" autocomplete="off"></label>
            <input type="hidden" name="login" value="1">
            <input type="submit" value="Login" class="small_button">
        </form>
        <br/>

        <div class="forgotPassword">
            <form action="http://www.artiosacademies.com/index.php?page=32&amp;resetpassword=1" method="POST">
                <label for="email_check">Forgot Password? <input type="text" name="email_check"
                                                                 value="Your e-mail address..." class="textbox"
                                                                 onfocus="this.value='';"></label>
                <input name="send_pass" value="1" type="hidden">
                <input type="submit" value="Submit" class="small_button">
            </form>
        </div>
    </div>

    <div class="half">
        <h3>New Families</h3>

        <form name="familyRegistrationForm" method="post" action="">
            <label for="campus_id">Campus: <select id="campus_id" name="campus_id" class="select">
                <option value="">Select a Campus</option>
              <?php if (isset($campusList)) {
              foreach ($campusList as $campus) {
                echo "<option value=\"".$campus['campus_id']."\">".$campus['name']."</option>";
              }
            } ?>
            </select>
            </label>
            <label for="primary_email">E-mail Address:<br><input type="text" name="primary_email" class="textbox"
                                                                 autocomplete="off"></label>
            <label for="password">Password: <br><input type="password" id="registerpassword1" name="password"
                                                       class="textbox" autocomplete="off"></label>
            <label for="confirm_password">Confirm Password: <br><input type="password" id="registerpassword2"
                                                                       name="confirm_password" class="textbox"
                                                                       autocomplete="off"></label>
            <input type="hidden" name="registerNow" value="1">
            <input type="submit" value="Register Now" class="small_button">
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

    .registrationLogin .select {
        padding: 10px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        width: 247px;
        height: 40px;
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
        padding: 8px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        width: 228px;
        height: 20px;
        border: 1px solid black;
        background-color: white;
    }
</style>