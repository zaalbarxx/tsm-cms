<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<script src="../includes/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/ckeditor/adapters/jquery.js"></script>
<div class="contentWithSideBar">
  <h1><?php echo $pageTitle; ?></h2>
  <form method="post" action="">
    <fieldset>
      <label for="name">Program Name: </label><input type="text" name="name" value="<?php echo $programInfo['name']; ?>" /><br /><br />
  <!--    <label for="payment_address_attn">Address Attn: </label><input type="text" name="address_attn" />
      <label for="payment_address">Address: </label><input type="text" name="address" />
      <label for="payment_address2">Address 2: </label><input type="text" name="address2" />
      <label for="payment_city">City Name: </label><input type="text" name="city" />
      <label for="payment_state">State Name: </label><input type="text" name="state" />
      <label for="payment_zip">Zip Code: </label><input type="text" name="zip" /> -->
    </fieldset>
    <textarea name="description" class="editor" /><?php echo $programInfo['description']; ?></textarea>
    <script type="text/javascript">
    $( 'textarea.editor' ).ckeditor();
    </script>
    <input type="hidden" name="campus_id" value="<?php echo $campus->getCampusId(); ?>" />
    <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>" />
    <input type="hidden" name="school_year" value="<?php echo $campus->getCurrentSchoolYear(); ?>" />
    <input type="hidden" name="<?php echo $submitField; ?>" value="1" />
    <input type="submit" class="submitButton" style="margin-top: 20px;" value="Save Program" />
    <br /><br /><br />
  </form>
</div>
<script type="text/javascript">
$(".program .title").click( function(){
  $(this).parent().children(".programDetails").slideToggle();
});
</script>