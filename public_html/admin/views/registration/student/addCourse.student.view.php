<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?></h2>
      <?php if ($eligibleCourses) { ?>
        <?php foreach ($eligibleCourses as $course) { ?>
                <div class="smallItem">
                    <span class="title"><?php echo $course['name']; ?></span>
				<span class="buttons">
				<a href="#" class="addButton24" title="Add to <?php echo $studentInfo['first_name']; ?>"></a>
				</span>

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
            <span>This student is not eligible for any courses in <?php echo $programInfo['name']; ?>.</span><br/><br/>
        <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".addButton24").click(function () {
            var docHeight = $(document).height();
            $("body").append("<div id='overlay'></div>");
            $("#overlay").height(docHeight);
            $(this).parent().parent().children(".periods").clone().addClass("activePeriod").prependTo("body").css({left:$(window).width() / 2 - 180}).show();

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