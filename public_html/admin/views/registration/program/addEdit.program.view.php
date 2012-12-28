<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<script src="../includes/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/ckeditor/adapters/jquery.js"></script>
<div class="contentWithSideBar">
  <h1><?php echo $pageTitle; ?></h2>
  <form method="post" action="">
    <fieldset>
      <label for="name">Program Name: </label><input type="text" name="name" value="<?php echo $programInfo['name']; ?>" />
    </fieldset>
    <br />
    <textarea name="description" class="editor" /><?php echo $programInfo['description']; ?></textarea>
    <script type="text/javascript">
    $( 'textarea.editor' ).ckeditor();
    </script>
    <input type="hidden" name="campus_id" value="<?php echo $currentCampus->getCampusId(); ?>" />
    <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>" />
    <input type="hidden" name="school_year" value="<?php echo $reg->getSelectedSchoolYear(); ?>" />
    <input type="hidden" name="<?php echo $submitField; ?>" value="1" />
    <input type="submit" class="submitButton" style="margin-top: 20px; float: right;" value="Save Program" />
    <br /><br /><br />
  </form>
</div>