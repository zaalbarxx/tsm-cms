<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
  <h1><?php echo $pageTitle; ?></h2>
  <form method="post" action="index.php?com=registration&ajax=formSubmission">
    <fieldset>
      <label for="name">Fee Name: </label><input type="text" name="name" value="<?php echo $feeInfo['name']; ?>" /><br />
      <label for="amount">Amount: </label><input type="text" name="amount" value="<?php echo $feeInfo['amount']; ?>" />
    </fieldset>
    <br />
    <input type="hidden" name="fee_id" value="<?php echo $feeInfo['fee_id']; ?>" />
    <input type="hidden" name="campus_id" value="<?php echo $currentCampus->getCampusId(); ?>" />
    <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>" />
    <input type="hidden" name="school_year" value="<?php echo $currentCampus->getCurrentSchoolYear(); ?>" />
    <input type="hidden" name="formAction" value="<?php echo $formAction; ?>" />
    <input type="submit" class="submitButton" style="margin-top: 20px; float: right;" value="Save Fee" />
    <br /><br /><br />
  </form>
</div>
<script type="text/javascript">
$(".submitButton").click( function(){
  form = $(this).parent();
  submitData = form.serialize();
  $.post(form.attr('action'),submitData, function(data){
    if(data == "0"){
    
    } else if (data == "1"){
      
    } else {
      alert(data);
      //window.parent.location = data;
    }
  });
  
  return false;
});
</script>