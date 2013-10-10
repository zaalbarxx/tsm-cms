<!--<h2>Registration Login</h2>-->
<div class="passwordContainer">
    <div style="text-align: center;"><h2>Change password</h2></div>
    <p style="text-align:center;">Please, provide new password below.</p>
    
          <?php if (isset($error)) {
          echo "<span class=\"errorMessage\">".$error."</span><br />";
        } ?>

        <form name="formPassword" id="formPassword" method="post" action="">
            <label for="password">Password:<br><input type="password" id="password" name="password" value=""
                                                         class="textbox" autocomplete="off"></label>
            <label for="password">Confirm password:<br><input type="password" id="password_confirm" name="password_confirm" value=""
                                                         class="textbox" autocomplete="off"></label>                                             
            <input type="hidden" name="email" value="<?php echo $email;?>">
            <input type="hidden" name="token" value="<?php echo $token;?>">
            <input type="submit" value="Change password" class="small_button">
        </form>
        <br/>
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

<script type="text/javascript">
    $(document).ready(function(){
                console.log('dupa');
        $("#formPassword").validate({
            rules:{
                password:"required",
                password_confirm:{
                    required:true,
                    equalTo:"#password"
                }
            }
        });
    });
</script>