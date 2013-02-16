<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?></h1>
  <?php if ($periods) { ?>
  <?php foreach ($periods as $period) { ?>
        <div class="smallItem">
            <span class="title"><?php echo $reg->displayPeriod($period); ?></span>
				<span class="buttons">
				<a href="index.php?com=registration&ajax=changeStudentPeriodForCourse&course_period_id=<?php echo $course_period_id; ?>&student_id=<?php echo $student_id; ?>&course_id=<?php echo $courseInfo['course_id']; ?>&program_id=<?php echo $program_id; ?>&new_course_period_id=<?php echo $period['course_period_id']; ?>"
           class="addButton24" title="Change Period"></a>
				</span>

        </div>

    <?php } ?>
  <?php } else { ?>
    <span>This student is not eligible for any courses in <?php $programInfo['name']; ?>.</span><br/><br/>
  <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".addButton24").click(function () {
            var confirmChange = confirm("Are you sure you would like to change this student to the selected period and teacher?");
            if (confirmChange) {
                $.get($(this).attr('href'), function (data) {
                    if (data == "0") {
                        alert("There was an error changing this period.");
                        parent.window.location.reload();
                    } else {
                        parent.window.location.reload();
                    }
                });
            }
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