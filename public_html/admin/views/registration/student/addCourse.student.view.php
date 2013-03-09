<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="span9">
    <input id="searchItems" rel="bigItem" class="search-query" style="float: right; position: relative; top: 10px;"
           value="Search..."/>

    <h1><?php echo $pageTitle; ?></h1>
  <?php if ($eligibleCourses) { ?>
  <?php foreach ($eligibleCourses as $course) { ?>
        <div class="bigItem well well-small">
          <span class="title"><?php echo $course['name']; ?> - <span
                  style="font-size: 12px; position: relative; top: -1px;">Click for Details</span></span>
          <span class="buttons">
          <a href="#" class="addButton24" title="Add to <?php echo $studentInfo['first_name']; ?>"></a>
          </span>

            <div class="itemDetails">
                <div class="description">
                  <?php echo html_entity_decode($course['description']); ?>
                </div>
                <h4>Applicable Fees</h4>

                <div class="half">
                    <strong>Registration Fee:</strong>
                    $<?php echo $reg->addFees($student->getFeesForCourse($course['course_id'], $program_id, $campusInfo['registration_fee_type_id'])); ?>
                </div>
                <div class="half">
                    <strong>Course Tuition:</strong>
                    $<?php echo $reg->addFees($student->getFeesForCourse($course['course_id'], $program_id, $campusInfo['tuition_fee_type_id'])); ?>
                </div>
                <div style="text-align: center; position: relative; top: 20px;">
                    <a href="#" class="btn btn-primary enrollNow" style="margin-left: -30px;">Enroll in Course</a>
                </div>

            </div>

            <div class="periods" style="display: none;">
                <h3>Select a Period</h3>
              <?php
              if (isset($course['periods'])) {
                foreach ($course['periods'] as $period) {
                  ?>
                  <?php echo $tsm->intToDay($period['day']).". ".date("g:ia", strtotime($period['start_time']))." - ".date("g:ia", strtotime($period['end_time'])); ?>
                    : <?php echo $period['first_name']." ".$period['last_name']; ?> - <a
                            href="index.php?com=registration&view=student&action=addCourse&student_id=<?php echo $studentInfo['student_id']; ?>&program_id=<?php echo $programInfo['program_id']; ?>&enrollInCourse=<?php echo $course['course_id']; ?>&course_period_id=<?php echo $period['course_period_id']; ?>"
                            class="addCourse">Choose</a><br/>
                  <?php
                }
              }?>
            </div>
        </div>

    <?php } ?>
  <?php } else { ?>
    <div class="alert text-center">This student is not eligible for any courses in <?php echo $programInfo['name']; ?>
        .
    </div><br/><br/>
  <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".bigItem .title").click(function () {
            $(this).parent().children(".itemDetails").slideToggle();
        });
        $(".addButton24,.enrollNow").click(function () {
            var docHeight = $(document).height();
            $("body").append("<div id='overlay'></div>");
            $("#overlay").height(docHeight);
            var curPosition = $(this).offset();
            $(this).parents(".bigItem").children(".periods").clone().addClass("activePeriod").prependTo("body").css({left:$(window).width() / 2 - 170, top:curPosition.top - 30}).show();

            return false;
        });
        $(".addCourse").live('click', function () {
            $.get($(this).attr('href'), function (data) {
                if (data == "0") {
                    alert("There was an error enrolling <?php $studentInfo['first_name']; ?> in the course. They may already be enrolled.");
                    parent.window.location.reload();
                } else {
                    parent.window.location.reload();
                }
            });

            return false;
        });
        $(document).mouseup(function (e) {
            var container = $("body .activePeriod");
            if (container.has(e.target).length === 0) {
                container.remove();
                $("#overlay").remove();
            }
        });
    });
</script>