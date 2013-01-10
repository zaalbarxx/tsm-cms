<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?> - <a
            href="index.php?com=registration&view=programs&action=addEditProgram&program_id=<?php echo $programInfo['program_id']; ?>"
            class="editButton" title="Edit Program"></a></h2>
        <div class="programDescription">
            <h3>Description:</h3>
          <?php echo html_entity_decode($programInfo['description']); ?>
            <h2></h2>
        </div>
        <div class="courses">
            <h3>Available Courses - <a
                    href="index.php?com=registration&view=programs&action=addCourse&program_id=<?php echo $program_id; ?>"
                    class="addButton24 fb" style="bottom:-5px" title="Add a Course"></a></h3>
          <?php if (isset($programCourses)) {
          foreach ($programCourses as $course) {
            ?>
              <div class="smallItem">
                  <a href="index.php?com=registration&view=programs&action=viewCourse&course_id=<?php echo $course['course_id']; ?>&program_id=<?php echo $program_id; ?>"
                     class="title"><?php echo $course['name']; ?></a>
                  <span class="buttons"><a href="#" class="deleteButton deleteCourse" title="Remove Course"
                                           ref="<?php echo $course['course_id']; ?>"></a></span>
              </div>
            <?php
          }
        } else {
          echo "There are no courses available for this Program.";
        }?>
        </div>
        <div class="programRequirements">
            <h3>Enrollment Requirements - <a
                    href="index.php?com=registration&view=programs&action=addRequirement&program_id=<?php echo $program_id; ?>"
                    class="addButton24 fb" style="bottom:-5px" title="Add a Requirement"></a></h3>
          <?php
          if (isset($programRequirements)) {
            foreach ($programRequirements as $requirement) {
              ?>
                <div class="smallItem">
                    <span class="title"><?php echo $requirement['name']; ?></span>
                    <span class="buttons"><a href="#" class="deleteButton deleteRequirement" title="Delete Requirement"
                                             ref="<?php echo $requirement['requirement_id']; ?>"></a></span>
                </div>
              <?php
            }
          } else {
            echo "There are no enrollment requirements for this Program.";
          }
          ?>
        </div>
        <div class="programFees">
            <h3>Applicable Fees - <a
                    href="index.php?com=registration&view=programs&action=addFee&program_id=<?php echo $program_id; ?>"
                    class="addButton24 fb" style="bottom:-5px" title="Add a Fee"></a></h3>

          <?php if (isset($programFees)) {
          foreach ($programFees as $fee) {
            ?>
              <div class="bigItem">
                  <span class="title"><?php echo $fee['name']; ?> - $<?php echo $fee['amount']; ?></span>
                  <span class="buttons"><a href="#" class="deleteButton deleteFee" title="Delete Fee"
                                           ref="<?php echo $fee['fee_id']; ?>"></a></span>

                  <div class="itemDetails">
                      <b><span class="tooltip"
                               title="This fee is applied only if applicant matches the condition(s) below.">Conditions:</span></b>
                      - <a
                          href="index.php?com=registration&view=programs&action=addCondition&program_id=<?php echo $program_id; ?>&fee_id=<?php echo $fee['fee_id'] ?>"
                          class="fb">Add</a>
                      <br/>
                    <?php
                    if ($fee['conditions']) {
                      $i = 1;
                      foreach ($fee['conditions'] as $condition) {
                        echo "<span id=\"condition_".$condition['program_fee_condition_id']."\">".$i.". ".$condition['name']." - <a href=\"\" class=\"deleteCondition\" ref=\"".$condition['program_fee_condition_id']."\" title=\"Delete this condition.\">Delete</a></span><br />";
                        $i++;
                      }
                    }
                    ?>
                  </div>
              </div>
            <?php
          }
        } else {
          echo "This program has no applicable fees.";
        } ?>
        </div>

</div>
<script type="text/javascript">
    $(".deleteCondition").click(function () {
        $("#condition_" + $(this).attr('ref')).remove();
        $.get("index.php?com=registration&ajax=deleteFeeConditionFromProgram&program_id=<?php echo $program_id; ?>&program_fee_condition_id=" + $(this).attr('ref'), function (data) {
            if (data == "1") {
                alert("Condition successfully deleted.");
                $("#condition_" + $(this).attr('ref')).remove();
            } else {
                alert("There was a problem deleting this condition.");
            }
        });
        return false;
    });
    $(".deleteRequirement").click(function () {
        var requirementDiv = $(this).parent().parent();
        $.get("index.php?com=registration&ajax=deleteRequirementFromProgram&program_id=<?php echo $program_id; ?>&requirement_id=" + $(this).attr('ref'), function (data) {
            if (data == "1") {
                alert("Requirement successfully deleted.");
                requirementDiv.remove();
            } else {
                alert("There was a problem deleting this requirement.");
            }
        });

        return false;
    });
    $(".deleteFee").click(function () {
        var requirementDiv = $(this).parent().parent();
        $.get("index.php?com=registration&ajax=deleteFeeFromProgram&program_id=<?php echo $program_id; ?>&fee_id=" + $(this).attr('ref'), function (data) {
            if (data == "1") {
                alert("The fee was successfully deleted from this program. However, if any students have already been approved, this fee will still apply to their account.");
                requirementDiv.remove();
            } else {
                alert("There was a problem removing this Fee from the program.");
            }
        });

        return false;
    });
    $(".bigItem .title").click(function () {
        $(this).parent().children(".itemDetails").slideToggle();
    });
</script>