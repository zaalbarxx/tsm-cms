<div class="contentArea">
    <h1><?php echo $pageTitle; ?></h2>
      <?php if ($eligiblePrograms) { ?>
        <?php foreach ($eligiblePrograms as $program) { ?>
                <div class="bigItem" style="margin-left: auto; margin-right: auto;">
                    <span class="title"><?php echo $program['name']; ?></span>
				<span class="buttons">
				<a href="index.php?com=registration&action=addProgram&student_id=<?php echo $studentInfo['student_id']; ?>&enrollInProgram=<?php echo $program['program_id']; ?>"
           class="addButton24"
           title="Enroll <?php echo $studentInfo['first_name']; ?> in <?php echo $program['name']; ?>"></a>
				</span>

                    <div class="itemDetails" style="display: block;">
                        <div class="half">
                            <span class="label">Registration Fee:</span>
                            $<?php echo $reg->addFees($student->getFeesForProgramAndCourses($program['program_id'], 2)); ?>
                        </div>
                        <div class="half">
                            <span class="label">Tuition:</span>
                            $<?php echo $reg->addFees($student->getFeesForProgramAndCourses($program['program_id'], 1)); ?>
                        </div>
                    </div>
                </div>
          <?php } ?>
        <?php } else { ?>
            <span>This student is not eligible for any programs.</span><br/><br/>
        <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".bigItem .title").click(function () {
            $(this).parent().children(".itemDetails").slideToggle();
        });
        $(".addButton24").click(function () {
            $.get($(this).attr('href'), function (data) {
                if (data == "1") {
                    parent.window.location.reload();
                } else {
                    alert("There was an error enrolling <?php $studentInfo['first_name']; ?> in the program. They may already be enrolled.");
                    parent.window.location.reload();
                }
            });

            return false;
        });
    });
</script>