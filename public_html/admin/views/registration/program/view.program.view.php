<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="span9">
    <h1><?php echo $pageTitle; ?> - <a
            href="index.php?com=registration&view=programs&action=addEditProgram&program_id=<?php echo $programInfo['program_id']; ?>"
            class="editButton" title="Edit Program"></a></h1>

    <div class="programDescription">
        <!--<h3>Description:</h3>-->
      <?php echo html_entity_decode($programInfo['description']); ?>
        <h2></h2>
    </div>
    <div class="courses">
        <h3>Available Courses - <a
                href="index.php?com=registration&view=programs&action=addCourse&program_id=<?php echo $program_id; ?>"
                class="addButton24 fb" style="bottom:-5px" title="Add a Course"></a></h3>

        <form id="removeCourses" method="post">
          <?php if (isset($programCourses)) {
          foreach ($programCourses as $course) {
            ?>
              <div class="smallItem well well-small">
                  <a href="index.php?com=registration&view=programs&action=viewCourse&course_id=<?php echo $course['course_id']; ?>&program_id=<?php echo $program_id; ?>"
                     class="title"><?php echo $course['name']; ?></a>
                  <span class="buttons"><a
                          href="index.php?com=registration&ajax=removeCourseFromProgram&program_id=<?php echo $program_id; ?>&course_id=<?php echo $course['course_id']; ?>"
                          class="deleteButton deleteCourse" title="Remove Course"
                          ref="<?php echo $course['course_id']; ?>"></a>
                  <input type="checkbox" name="course_<?php echo $course['course_id']; ?>"
                         value="<?php echo $course['course_id']; ?>"/>
                  </span>
              </div>
            <?php
          }
        } else {
          echo "There are no courses available for this Program.";
        }?>
            <input type="hidden" name="removeCourses" value="1"/>
            <input type="submit" style="float: right; margin-right: 20px;" class="btn btn-primary"
                   value="Remove Selected"/>
        </form>
        <br/>
    </div>
    <div class="programRequirements">
        <h3>Enrollment Requirements - <a
                href="index.php?com=registration&view=programs&action=addRequirement&program_id=<?php echo $program_id; ?>"
                class="addButton24 fb" style="bottom:-5px" title="Add a Requirement"></a></h3>
      <?php
      if (isset($programRequirements)) {
        foreach ($programRequirements as $requirement) {
          ?>
            <div class="smallItem well well-small">
                <span class="title"><?php echo $requirement['name']; ?></span>
                <span class="buttons"><a
                        href="index.php?com=registration&ajax=deleteRequirementFromProgram&program_id=<?php echo $program_id; ?>&requirement_id=<?php echo $requirement['requirement_id']; ?>"
                        class="deleteButton" title="Delete Requirement"></a></span>
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
          <div class="bigItem well">
              <span class="title"><?php echo $fee['name']; ?> - $<?php echo $fee['amount']; ?></span>
              <span class="buttons"><a
                      href="index.php?com=registration&ajax=deleteFeeFromProgram&program_id=<?php echo $program_id; ?>&fee_id=<?php echo $fee['fee_id']; ?>"
                      class="deleteButton deleteFee" title="Delete Fee"></a></span>

              <div class="itemDetails well">
                  <b><span
                          title="This fee is applied only if applicant matches the condition(s) below.">Conditions:</span></b>
                  - <a
                      href="index.php?com=registration&view=programs&action=addCondition&program_id=<?php echo $program_id; ?>&fee_id=<?php echo $fee['fee_id'] ?>"
                      class="btn btn-small btn-primary fb">Add</a>
                  <br/>
                <?php
                if ($fee['conditions']) {
                  $i = 1;
                  foreach ($fee['conditions'] as $condition) {
                    echo "<span id=\"condition_".$condition['program_fee_condition_id']."\">".$i.". ".$condition['name']." - <a href=\"index.php?com=registration&ajax=deleteFeeConditionFromProgram&program_id=".$program_id."&program_fee_condition_id=".$condition['program_fee_condition_id']."\" class=\"deleteButton btn btn-small btn-danger\" ref=\"".$condition['program_fee_condition_id']."\" title=\"Delete this condition.\">Remove</a></span><br />";
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
    $("#removeCourses").submit(function () {
        var formData = $(this).serialize();
        $.post(window.location, formData, function (data) {
            if (data == "1") {
                alert("The courses were removed");
                parent.window.location.reload();
            } else {
                alert("There was an error removing the courses.");
                parent.window.location.reload();
            }
        });

        return false;
    });
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