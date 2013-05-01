<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
    <h1><?php echo $pageTitle; ?></h1>
    <!--<div class="availablePeriods">
  	<h3>Available Periods - <a href="index.php?com=registration&view=courses&action=addPeriod&course_id=<?php echo $course_id; ?>" class="addButton24 fb" style="bottom:-5px" title="Add a Period"></a></h3> 
  	<?php if (isset($coursePeriods)) {
      foreach ($coursePeriods as $period) {
        ?>
  		<div class="smallItem well well-small">
  		<span class="title"><?php echo $tsm->intToDay($period['day']).". ".date("g:ia", strtotime($period['start_time']))." - ".date("g:ia", strtotime($period['end_time'])); ?>: <?php echo $period['first_name']." ".$period['last_name']; ?></span>
				<span class="buttons"><a href="#" class="deleteButton deletePeriod" title="Delete Period" ref="<?php echo $period['period_id']; ?>"></a></span>
			</div>
  		<?php
      }
    }?>
  </div>-->
    <div class="courseRequirements">
        <h3>Enrollment Requirements - <a
                href="index.php?com=registration&view=courses&action=addRequirement&course_id=<?php echo $course_id; ?>&program_id=<?php echo $program_id; ?>"
                class="addButton24 fb" style="bottom:-5px" title="Add a Requirement"></a></h3>
      <?php
      if (isset($courseRequirements)) {
        foreach ($courseRequirements as $requirement) {
          ?>
            <div class="smallItem well well-small">
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
                href="index.php?com=registration&view=courses&action=addFee&course_id=<?php echo $course_id; ?>&program_id=<?php echo $program_id; ?>"
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
                      href="index.php?com=registration&view=courses&action=addCondition&course_id=<?php echo $course_id; ?>&fee_id=<?php echo $fee['fee_id'] ?>&program_id=<?php echo $program_id; ?>"
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
    <div class="courseRoster">
        <h3>Course Roster - <a
                href="index.php?com=registration&view=programs&action=viewProgram&action=viewCourse&program_id=<?php echo $program_id; ?>&course_id=<?php echo $course_id; ?>&downloadCSV=1"
                class="button downloadButton" title="Download CSV"></a></h3>
      <?php
      if (isset($courseStudents)) {
        foreach ($courseStudents as $student) {
          ?>
            <div class="smallItem well well-small">
                <span class="title"
                      style="cursor: pointer;"><?php echo $student['first_name']." ".$student['last_name']; ?>
                    , Grade: <?php echo $student['grade']; ?></span>
                <span class="buttons"></span>

                <div class="itemDetails">
                    <span class="label">E-mail:</span> <?php
                  if ($student['email'] != "") {
                    echo $student['email'];
                  } else {
                    echo "N/A";
                  }  ?>
                </div>
            </div>
          <?php
        }
      } else {
        echo "No students are currently enrolled in this course within this program.";
      }
      ?>
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