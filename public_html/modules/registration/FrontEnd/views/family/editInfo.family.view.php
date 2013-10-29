<?php
require_once(__TSM_ROOT__."modules/registration/FrontEnd/views/sidebar.view.php");
?>
<div class="contentArea">

  <h1 style="text-align: center;">Edit Family Information</h1>

  <div class="infoSection">
    <div class="familyEditInfo">
      <form action='' method='POST' id="familyEditInfo">
        <div class="half">
          <span class="title"
                        style="width: 150px;">Father First Name:</span> <input type='text' name='father_first' value="<?php echo $familyInfo['father_first']; ?>">
          <br/>
                    <span class="title"
                        style="width: 150px;">Father Last Name:</span> <input type='text' name='father_last' value="<?php echo $familyInfo['father_last']; ?>">
          <br/>
          <span class="title" style="width: 150px;">Father Cell:</span> <input type='text' id='father_cell' name='father_cell' value="<?php echo $familyInfo['father_cell']; ?>">
          <br/><br/>

          <span class="title" style="width: 150px;">Primary E-mail:</span> <input type='text' name='email_primary' value="<?php echo $familyInfo['primary_email']; ?>">
          <br/>
          
          <span class="title"
                        style="width: 150px;">Seconary E-mail:</span> <input type='text' name='email_secondary' value="<?php echo $familyInfo['secondary_email']; ?>">
          <br/><br/>
        </div>
        <div class="half">
                    <span class="title"
                          style="width: 150px;">Mother First Name:</span> <input type='text' name='mother_first' value="<?php echo $familyInfo['mother_first']; ?>">
          <br/>
          <span class="title"
                style="width: 150px;">Mother Last Name:</span> <input type='text' name='mother_last' value="<?php echo $familyInfo['mother_last']; ?>">
          <br/>
          <span class="title" style="width: 150px;">Mother Cell:</span> <input type='text' id='mother_cell' name='mother_cell' value="<?php echo $familyInfo['mother_cell']; ?>">
          <br/><br/>
              <span class="title" style="width: 150px;">Address:</span> <input type='text' name='address' value="<?php echo $familyInfo['address']; ?>">
          <br/>
              <span class="title" style="width: 150px;">City:</span> <input type='text' name='city' value="<?php echo $familyInfo['city']; ?>">
          <br/>
                  <span class="title" style="width: 150px;">State:</span> <input type='text' name='state' value="<?php echo $familyInfo['state']; ?>">
          <br/>
                  <span class="title" style="width: 150px;">Zip code:</span> <input type='text' name='zip' value="<?php echo $familyInfo['zip']; ?>">
          <br/>
          <br/>

        </div>
        <input type="submit" class="submitButton right" style="clear: both;" value="Save Information"/>
      </form>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    <?php if(isset($error)) echo 'alert("There was an error encountered. Please, try again.");'?>
    $("#father_cell,#mother_cell").mask("(999) 999-9999");
    
    $("#familyEditInfo").validate({
        rules:{
            father_first:"required",
            father_last:"required",
            mother_first:"required",
            mother_last:"required",
            father_cell:{
                required:function (element) {
                    if ($("#father_cell").val() == "" && $("#mother_cell").val() == "") {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
            mother_cell:{
                required:function (element) {
                    if ($("#father_cell").val() == "" && $("#mother_cell").val() == "") {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
            address:"required",
            city:"required",
            state:"required",
            zip:"required",
            email_primary:{
                required:true,
                email:true
            },
            email_secondary:{
                required:false
            }
        }
    });



  });

</script>