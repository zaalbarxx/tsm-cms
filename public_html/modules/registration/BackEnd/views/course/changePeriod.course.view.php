<div class="span9">
    <h1><?php echo $pageTitle; ?></h1>
  <?php if ($periods) { ?>
  <?php foreach ($periods as $period) { ?>
        <div class="smallItem well well-small">
            <span class="title"><?php echo $reg->displayPeriod($period); ?></span>
				<span class="buttons">
				<a href="#" class="addButton24" title="Add Period"></a>
				</span>

            <div class="periods" style="display: none;">
                <h3>Select a Teacher for this Period</h3>
              <?php foreach ($teachers as $teacher) { ?>
              <?php echo $teacher['first_name']." ".$teacher['last_name']; ?> - <a
                        href="index.php?com=registration&ajax=changePeriodInCourse&course_period_id=<?php echo $course_period_id; ?>&course_id=<?php echo $courseInfo['course_id']; ?>&new_teacher_id=<?php echo $teacher['teacher_id']; ?>&new_period_id=<?php echo $period['period_id']; ?>"
                        class="changePeriod">Choose</a><br/>
              <?php } ?>
            </div>
        </div>

    <?php } ?>
  <?php } else { ?>
    <span>This student is not eligible for any courses in <?php $programInfo['name']; ?>.</span><br/><br/>
  <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".addButton24").click(function () {
            var docHeight = $(document).height();
            $("body").append("<div id='overlay'></div>");
            $("#overlay").height(docHeight);
            var offset = $(this).offset();
            $(this).parent().parent().children(".periods").clone().addClass("activePeriod").prependTo("body").css({left:$(window).width() / 2 - 180, top:(($(window).height() - $(this).height()) / 2) + $(window).scrollTop()}).show();

            return false;
        });
        $(".changePeriod").live('click', function () {
            var confirmChange = confirm("Are you sure you would like to change this period and teacher and move all students enrolled to the new period?");
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