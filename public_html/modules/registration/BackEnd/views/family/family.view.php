<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<style>
    .smallItem .title {
        cursor: pointer;
    }
</style>
<div class="span9">
    <input id="searchItems" rel="smallItem" class="search-query" style="float: right; position: relative; top: 10px;"
           value="Search..."/>

    <h1>Families - <a
            href="index.php?mod=registration&view=family&downloadCSV=1"
            class="button downloadButton" title="Download CSV"></a></h1>

    <p>There are <?php echo $numFamilies; ?> families enrolled.</p>
  <?php
  foreach ($families as $family) {
    ?>
      <div class="smallItem well well-small">
          <a href="index.php?mod=registration&view=family&action=viewFamily&family_id=<?php echo $family['family_id']; ?>"
             class="title"><?php echo $family['father_last']; ?> Family <?php echo $family['status']; ?></a>
            <?php if ($currentCampus->usesQuickbooks() && $family['quickbooks_customer_id'] == "" && $family['status'] == " - Finalized") { ?>
              <span style="margin-left: 100px;">
                <a href="index.php?mod=registration&view=family&action=linkToQuickbooks&family_id=<?php echo $family['family_id']; ?>" class="btn fb">Link To Quickbooks</a>
              </span>
            <?php } ?>
            <span class="buttons"><a
              href="index.php?mod=registration&view=family&action=viewFamily&family_id=<?php echo $family['family_id']; ?>"
              class="reviewButton" title="Review This Family"></a>
            </span>
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