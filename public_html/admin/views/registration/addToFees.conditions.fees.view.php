<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<style>
    .smallItem .buttons input {
        top: 2px;
    }
</style>
<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?></h1>
  <?php if (isset($programs)) { ?>
  <form id="addToFees" method="post">
  <?php foreach ($programs as $program) {
    //if (isset($program['fees'])) {
    ?>
        <h2><?php echo $program['name']." Fees"; ?></h2>
    <?php
    if (isset($program['fees'])) {
      foreach ($program['fees'] as $fee) {
        ?>
          <div class="smallItem">
              <span class="title"><?php echo $fee['name']." - $".$fee['amount']; ?></span>
          <span class="buttons">
              <input type="checkbox"
                     name="programId:<?php echo $program['program_id']; ?>_feeId:<?php echo $fee['fee_id']; ?>"
                     value="1"/>
          </span>
          </div>
        <?php
      }
    }?>
        <div style="margin-left: 40px;">
          <?php foreach ($program['courses'] as $course) { ?>
            <h3><?php echo $program['name']." ".$course['name']." Fees "; ?></h3>
          <?php
          if (isset($course['fees'])) {
            foreach ($course['fees'] as $fee) {
              ?>
                <div class="smallItem" style="width: 610px;">
                    <span class="title"><?php echo $fee['name']." - $".$fee['amount']; ?></span>
              <span class="buttons">
                  <input type="checkbox"
                         name="courseId:<?php echo $course['course_id']; ?>_programId:<?php echo $program['program_id']; ?>_feeId:<?php echo $fee['fee_id']; ?>"
                         value="<?php echo $fee['course_fee_id']; ?>"/>
              </span>
                </div>
              <?php
            }
          }
          ?>
          <?php
          if (isset($course['courseOnlyFees'])) {
            foreach ($course['courseOnlyFees'] as $fee) {
              ?>
                <div class="smallItem" style="width: 610px;">
                    <span class="title"><?php echo $fee['name']." - $".$fee['amount']; ?> - All Programs</span>
              <span class="buttons">
                  <input type="checkbox"
                         name="courseId:<?php echo $course['course_id']; ?>_programId:null_feeId:<?php echo $fee['fee_id']; ?>"
                         value="<?php echo $fee['course_fee_id']; ?>"/>
              </span>
                </div>
              <?php
            }
          } ?>
          <?php } ?>
        </div>
    <?php //} ?>
    <?php } ?>
  <?php } else { ?>
    <span>There are no fees available.</span><br/><br/>
  <?php } ?>
    <input type="hidden" name="addToFees" value="1"/>
    <input type="submit" style="float: right;" class="submitButton" value="Add To Selected"/>
    <br/><br/>
</form>
</div>
<script type="text/javascript">
    $("#addToFees").submit(function () {
        var formData = $(this).serialize();
        $.post(window.location, formData, function (data) {
            if (data == "1") {
                parent.window.location.reload();
            } else {
                alert("There was an error adding the condition to the fees.");
                parent.window.location.reload();
            }
        });

        return false;
    });
</script>