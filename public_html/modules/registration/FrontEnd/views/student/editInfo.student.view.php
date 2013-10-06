<?php
require_once(__TSM_ROOT__."modules/registration/FrontEnd/views/sidebar.view.php");
?>
<div class="contentArea">

  <h1 style="text-align: center;">Edit information</h1>

  <p style="text-align: center;">Below you can edit student information.</p>

  <div class="infoSection">
    <h2>Family Information</h2>
    <div class="studentEditInfo">
      <form action='' method='POST' id="studentEditInfo">
        <div class="half">
          <span class="title"
                        style="width: 150px;">Nickname:</span> <input type='text' name='nickname' value="<?php echo $studentInfo['nickname']; ?>">
          <br/>
                    <span class="title"
                        style="width: 150px;">Birth date:</span>
                        <br/>
                        <span class='tips'>(Format yyyy-mm-dd)</span>
                         <input type='text' id='birth_date' name='birth_date' value="<?php echo $studentInfo['birth_date']; ?>">
          <br/>
          <span class="title" style="width: 150px;">Grade:</span> <input type='text' id='grade' name='grade' value="<?php echo $studentInfo['grade']; ?>">
          <br/><br/>
          <span class="title"
                        style="width: 150px;">E-mail:</span> <input type='text' name='email' value="<?php echo $studentInfo['email']; ?>">
          <br/>
          <br/><br/>
                    <input type="submit" class="submitButton" value="Save"/>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    <?php if(isset($error)) echo 'alert("There was an error encountered. Please, try again.");'?>
    $("#birth_date").mask("9999-99-99");
    $("#studentEditInfo").validate({
        rules:{
            nickname:"required",
            birth_date:{
              required:true,
              date:true
            },
            grade:{
              required:true,
              digits:true
            },
            email:{
                email:true
            }
        }
    });



  });

</script>