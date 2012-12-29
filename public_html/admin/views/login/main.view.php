<h1>Admin Login</h1>
<?php 
if(isset($errorMessage)){ 
  echo "<div class='errorMessage'>".$errorMessage."</div>"; 
} 
?>
<p style="text-align: center;">You must login below to continue.</p>
<form id="adminLoginForm" method="post" style="width: 330px; margin: auto;">
  <fieldset>
    <br />
    <label for="username">Username: </label><input type="text" name="username" id="username" autocomplete="off" /><br />
    <label for="password">Password: </label><input type="password" name="password" id="password" autocomplete="off" />
  <input type="submit" value="Login Now" style="margin-top: 20px; float: right;" class="submitButton" />
  </fieldset>
  <input type="hidden" name="login" value="1" />

</form>