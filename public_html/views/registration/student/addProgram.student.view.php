<div class="contentArea">
    <h1><?php echo $pageTitle; ?></h1>
    <input id="searchItems" rel="bigItem"
           value="Search..."/>
  <?php if ($eligiblePrograms) { ?>
  <?php foreach ($eligiblePrograms as $program) { ?>
        <div class="bigItem" style="margin-left: auto; margin-right: auto;">
            <span class="title"><img src="<?php echo $program['icon_url']; ?>"
                                     style="width: 40px; margin-top: -25px; margin-bottom: -15px; margin-right: 20px; margin-left: -30px;"/><?php echo $program['name']; ?>
                - <span
                        style="font-size: 12px; position: relative; top: -1px;">Click for Details</span></span>
				<span class="buttons">
				<a href="index.php?com=registration&action=addProgram&student_id=<?php echo $studentInfo['student_id']; ?>&enrollInProgram=<?php echo $program['program_id']; ?>"
           class="addButton24"
           title="Enroll <?php echo $studentInfo['first_name']; ?> in <?php echo $program['name']; ?>"></a>
				</span>

            <div class="itemDetails">
                <div class="description">
                  <?php echo html_entity_decode($program['description']); ?>
                </div>
                <h4>Applicable Fees</h4>

                <div class="half">
                    <span class="label">Registration Fee:</span>
                    $<?php echo $reg->addFees($student->getFeesForProgramAndCourses($program['program_id'], $campusInfo['registration_fee_type_id'])); ?>
                </div>
                <div class="half">
                    <span class="label">Tuition:</span>
                    $<?php echo $reg->addFees($student->getFeesForProgramAndCourses($program['program_id'], $campusInfo['tuition_fee_type_id'])); ?>
                </div>
                <div style="text-align: center; position: relative; top: 20px;">
                    <a href="index.php?com=registration&action=addProgram&student_id=<?php echo $studentInfo['student_id']; ?>&enrollInProgram=<?php echo $program['program_id']; ?>"
                       class="med_button enrollNow" style="margin-left: -30px;">Enroll in Program</a>
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
        $(".addButton24,.enrollNow").click(function () {
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