<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
    <h2>Unfinalized Families - <a
            href="index.php?mod=registration&view=reports&action=unfinalizedFamilies&downloadCSV=1"
            class="button downloadButton" title="Download CSV"></a></h2>
  <?php
  if (isset($families)) {
    foreach ($families as $family) {
      ?>
        <div class="smallItem well well-small">
            <a class="title"
               href="index.php?mod=registration&view=family&action=viewFamily&family_id=<?php echo $family['family_id']; ?>"><?php echo $family['father_last']; ?></a>
              <span class="buttons"><a
                      href="index.php?mod=registration&view=family&action=viewFamily&family_id=<?php echo $family['family_id']; ?>"
                      class="reviewButton" title="Review This Family"></a></span>

            <div class="itemDetails">
            </div>
        </div>
      <?php
    }
  }
  ?>
</div>