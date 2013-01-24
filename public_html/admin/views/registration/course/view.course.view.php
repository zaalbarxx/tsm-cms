<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?> - <a
            href="index.php?com=registration&view=courses&action=addEditCourse&course_id=<?php echo $courseInfo['course_id']; ?>"
            class="editButton" title="Edit Course"></a></h1>

    <div class="courseDescription">
        <h3>Description:</h3>
      <?php echo html_entity_decode($courseInfo['description']); ?>
        <h2></h2>
    </div>
    <div class="availablePeriods">
        <h3>Available Periods - <a
                href="index.php?com=registration&view=courses&action=addPeriod&course_id=<?php echo $course_id; ?>"
                class="addButton24 fb" style="bottom:-5px" title="Add a Period"></a></h3>
      <?php if (isset($coursePeriods)) {
      foreach ($coursePeriods as $period) {
        ?>
          <div class="smallItem">
                  <span class="title"><?php echo $tsm->intToDay($period['day']).". ".date("g:ia", strtotime($period['start_time']))." - ".date("g:ia", strtotime($period['end_time'])); ?>
                      : <?php echo $period['first_name']." ".$period['last_name']; ?></span>
                  <span class="buttons"><a
                          href="index.php?com=registration&ajax=deletePeriodFromCourse&course_id=<?php echo $courseInfo['course_id']; ?>&course_period_id=<?php echo $period['course_period_id']; ?>"
                          class="deleteButton" title="Delete Period"
                          ref="<?php echo $period['period_id']; ?>"></a></span>
          </div>
        <?php
      }
    }?>
    </div>
    <div class="courseRequirements">
        <h3>Enrollment Requirements - <a
                href="index.php?com=registration&view=courses&action=addRequirement&course_id=<?php echo $course_id; ?>"
                class="addButton24 fb" style="bottom:-5px" title="Add a Requirement"></a></h3>
      <?php
      if (isset($courseRequirements)) {
        foreach ($courseRequirements as $requirement) {
          ?>
            <div class="smallItem">
                <span class="title"><?php echo $requirement['name']; ?></span>
                <span class="buttons"><a
                        href="index.php?com=registration&ajax=deleteRequirementFromCourse&course_id=<?php echo $course_id; ?>&course_requirement_id=<?php echo $requirement['course_requirement_id']; ?>"
                        class="deleteButton" title="Delete Requirement"></a></span>
            </div>
          <?php
        }
      }
      ?>
    </div>
    <div class="courseFees">
        <h3>Applicable Fees - <a
                href="index.php?com=registration&view=courses&action=addFee&course_id=<?php echo $course_id; ?>"
                class="addButton24 fb" style="bottom:-5px" title="Add a Fee"></a></h3>

      <?php if (isset($courseFees)) {
      foreach ($courseFees as $fee) {
        ?>
          <div class="bigItem">
              <span class="title"><?php echo $fee['name']; ?> - $<?php echo $fee['amount']; ?></span>
                  <span class="buttons"><a
                          href="index.php?com=registration&ajax=deleteFeeFromCourse&course_id=<?php echo $course_id; ?>&course_fee_id=<?php echo $fee['course_fee_id']; ?>"
                          class="deleteButton" title="Delete Fee"></a></span>

              <div class="itemDetails">
                  <b><span class="tooltip"
                           title="This fee is applied only if applicant matches the condition(s) below.">Conditions:</span></b>
                  - <a
                      href="index.php?com=registration&view=courses&action=addCondition&course_id=<?php echo $course_id; ?>&fee_id=<?php echo $fee['fee_id'] ?>"
                      class="fb">Add</a>
                  <br/>
                <?php
                if ($fee['conditions']) {
                  $i = 1;
                  foreach ($fee['conditions'] as $condition) {
                    echo "<span id=\"condition_".$condition['course_fee_condition_id']."\">".$i.". ".$condition['name']." - <a href=\"index.php?com=registration&ajax=deleteFeeConditionFromCourse&course_id=".$course_id."&course_fee_condition_id=".$condition['course_fee_condition_id']."\" class=\"deleteButton button\" title=\"Delete this condition.\"></a></span><br />";
                    $i++;
                  }
                }
                ?>
              </div>
          </div>
        <?php
      }
    } ?>
    </div>

</div>
<script type="text/javascript">
    $(".deleteButton").click(function () {
        $.get($(this).attr("href"), function (data) {
            var response = JSON.parse(data);
            if (response.alertMessage != null) {
                alert(response.alertMessage);
            }
            if (response.success == true) {
                window.location.reload();
            }
        });
        return false;
    });
    $(".bigItem .title").click(function () {
        $(this).parent().children(".itemDetails").slideToggle();
    });
</script>