<!--<h2>Registration Login</h2>-->
<div class="passwordContainer">
    <div style="text-align: center;"><h2>Remind password</h2></div>
    <p style="text-align:center;">Please, choose campus you belong to and e-mail address you provided.</p>
    
          <?php if (isset($error)) {
          echo "<span class=\"errorMessage\">".$error."</span><br />";
        } ?>

        <form name="formPassword" id="formPassword" method="post" action="">

            <label for="campus_id">Campus: <select id="campus_id" name="campus_id" class="select">
                <option value="">Select a Campus</option>
              <?php if (isset($campusList)) {
              foreach ($campusList as $campus) {
                echo "<option value=\"".$campus['campus_id']."\">".$campus['name']."</option>";
              }
            } ?>
            </select>
            </label>
            <label for="email">E-mail Address:<br><input type="text" id="email" name="email" value=""
                                                         class="textbox" autocomplete="off"></label>
            <input type="hidden" name="login" value="1">
            <input type="submit" value="Reset password" class="small_button">
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
        $("#formPassword").validate({
            rules:{
                campus_id:"required",
                email:"required",
            }
        });
    });
</script>