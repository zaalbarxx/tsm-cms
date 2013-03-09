<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<style>
    .smallItem .title {
        cursor: pointer;
    }
</style>
<div class="span9">
    <h1>Families - <a
            href="index.php?com=registration&view=family&downloadCSV=1"
            class="button downloadButton" title="Download CSV"></a></h1>

    <p>There are <?php echo $numFamilies; ?> families enrolled.</p>
  <?php
  foreach ($families as $family) {
    ?>
      <div class="smallItem well well-small">
          <a href="index.php?com=registration&view=family&action=viewFamily&family_id=<?php echo $family['family_id']; ?>"
             class="title"><?php echo $family['father_last']; ?> Family <?php echo $family['status']; ?></a>
              <span class="buttons"><a
                      href="index.php?com=registration&view=family&action=viewFamily&family_id=<?php echo $family['family_id']; ?>"
                      class="reviewButton" title="Review This Family"></a></span>

          <div class="itemDetails">
            <?php
            //foreach($family['students'] as $student){
            //	echo $student['first_name'];
            //}
            ?>
          </div>
      </div>
    <?php
  }
  ?>
</div>
<script type="text/javascript">
    /*
    $(".smallItem .title").click( function(){
      $(this).parent().children(".itemDetails").slideToggle();
    });
    */
</script>