<!--<h2>Registration Login</h2>-->
<span style="position: relative; top: -40px;"><a href="index.php?browseOfferings=1" class="small_button">Preview Class Offerings</a> | <a
        class="fb noext" href="http://player.vimeo.com/video/58812049">Registration Tutorial</a></span>
<div class="registrationLogin">
    <div class="half" style="text-align: center;"><h3>Current Families</h3></div>
    <div class="half" style="text-align: center;"><h3>New Families</h3></div>
    <p style="margin-left: 60px;">Last year's login is not valid. Everyone must log in as a New Family first.</p>

    <div class="half">
        <form name="familyLoginForm" id="familyLoginForm" method="post" action="">
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

        <!--<div class="forgotPassword">
            <form action="http://www.artiosacademies.com/index.php?page=32&amp;resetpassword=1" method="POST">
                <label for="email_check">Forgot Password? <input type="text" name="email_check"
                                                                 value="Your e-mail address..." class="textbox"
                                                                 onfocus="this.value='';"></label>
                <input name="send_pass" value="1" type="hidden">
                <input type="submit" value="Submit" class="small_button">
            </form>
        </div>-->
    </div>

    <div class="half">

        <form name="familyRegistrationForm" id="familyRegistrationForm" method="post" action="">
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
<br style="width: 100%; clear: both;"/>
<br style="width: 100%; clear: both;"/>
<br style="width: 100%; clear: both;"/>
<br style="width: 100%; clear: both;"/>
<br style="width: 100%; clear: both;"/>
<br style="width: 100%; clear: both;"/>
<div style="width: 33%; float: left; text-align:center;">
    <img src="templates/100/images/art.png" style="width:240px;"/>
</div>
<div style="width: 33%; float: left; text-align:center;">
    <img src="templates/100/images/heart.png" style="width:240px;"/>
</div>
<div style="width: 33%; float: left; text-align:center;">
    <img src="templates/100/images/smart.png" style="width:240px;"/>
</div>
<style>
    .registrationLogin {
        margin-left: auto;
        margin-right: auto;
        width: 666px;
        height: 304px;
        padding-left: 30px;
    }

    .registrationLogin .half {
        width: 240px;
        margin-right: 65px;
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
        font-weight: bold;
        font-size: 14px;
    }

    .registrationLogin .textbox {
        font-family: "Rokkitt";
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
<script type="text/javascript">
    $("#familyRegistrationForm").validate({
        rules:{
            campus_id:"required",
            primary_email:"required",
            password:"required",
            confirm_password:"required"
        }
    });
    $("#familyLoginForm").validate({
        rules:{
            campus_id:"required",
            primary_email:"required",
            password:"required"
        }
    });
</script>