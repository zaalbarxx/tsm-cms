<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1>Periods</h2>
        <span style="float: right; margin-top: -45px; right: 20px; position: relative;"><a
                href="index.php?com=registration&view=periods&action=addEditPeriod" class="addButton"
                title="Add a Period"></a></span>
      <?php
      if ($periods) {
        foreach ($periods as $period) {
          ?>
            <div class="smallItem">
                <span class="title"><?php echo $tsm->intToDay($period['day']).". ".date("g:ia", strtotime($period['start_time']))." - ".date("g:ia", strtotime($period['end_time'])); ?></span>
                <span class="buttons"><a
                        href="index.php?com=registration&view=periods&action=addEditPeriod&period_id=<?php echo $period['period_id']; ?>"
                        class="editButton" title="Edit This Period"></a><a
                        href="index.php?com=registration&view=periods&action=deletePeriod&period_id=<?php echo $period['period_id']; ?>"
                        class="deleteButton" title="Delete Period"></a></span>
            </div>
          <?php
        }
      }
      ?>
</div>