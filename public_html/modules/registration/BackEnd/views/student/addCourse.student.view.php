<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
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
            <a href="#myModal<?php echo $course['course_id']; ?>" class="btn btn-primary pull-right" title="Add Course"
               data-toggle="modal">Select</a>

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
                    <a href="#myModal<?php echo $course['course_id']; ?>" class="btn btn-primary"
                       style="margin-left: -30px;" data-toggle="modal">Enroll in Course</a>
                </div>

            </div>


            <div id="myModal<?php echo $course['course_id']; ?>" class="modal hide fade" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h3 id="myModalLabel">Select a Period</h3>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <caption>You must select a period to continue.</caption>
                        <tr>
                            <th>Period</th>
                            <th>Teacher</th>
                            <th></th>
                        </tr>
                      <?php
                      if (isset($course['periods'])) {
                        foreach ($course['periods'] as $period) {

                          ?>
                          <tr><td>
                            <?php echo $tsm->intToDay($period['day']).". ".date("g:ia", strtotime($period['start_time']))." - ".date("g:ia", strtotime($period['end_time'])); ?>
                            </td>
                            <td><?php echo $period['first_name']." ".$period['last_name']; ?></td>
                            <td><a
                                    href="index.php?com=registration&view=student&action=addCourse&student_id=<?php echo $studentInfo['student_id']; ?>&program_id=<?php echo $programInfo['program_id']; ?>&enrollInCourse=<?php echo $course['course_id']; ?>&course_period_id=<?php echo $period['course_period_id']; ?>"
                                    class="addCourse btn btn-primary pull-right">Choose</a></td>
                          <?php
                        } ?>
                        </tr>
                      <?php } ?>
                    </table>
                </div>
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
    });
</script>