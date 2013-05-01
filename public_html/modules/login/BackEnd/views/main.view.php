<?php
if (isset($errorMessage)) {
  echo "<div class='errorMessage'>".$errorMessage."</div>";
}
?>
<style>
    body {
        background: #f5f5f5;
    }

    .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
        -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
        box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
    }

    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }

    .form-signin input[type="text"],
    .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
    }
</style>
<form class="form-signin" method="post">
    <h2 class="form-signin-heading">Admin Login</h2>
    <label for="username">Username: </label><input type="text" name="username" id="username"
                                                   autocomplete="off"/><br/>
    <label for="password">Password: </label><input type="password" name="password" id="password"
                                                   autocomplete="off"/>
    <input type="submit" value="Login Now" class="btn btn-primary pull-right"/>
    <br/><br/>
    <input type="hidden" name="login" value="1"/>
</form>