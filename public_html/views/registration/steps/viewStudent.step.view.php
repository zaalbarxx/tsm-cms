<div class="contentArea">
    <h1>
      <?php echo $pageTitle; ?> - <span style="font-size: 14px;"><?php echo $campusInfo['name']; ?></span></h1>

    <div style="width: 100%; display: block; position: relative; top:-55px;  text-align: right; float: right;">
        <a href="index.php?com=registration&reviewRegistration=1" class="submitButton"
           style="margin-right: 20px;float: right; text-decoration: none;">Review Family Registration</a><a
            href="index.php?com=registration&addAnotherStudent=1" class="submitButton"
            style="margin-right: 20px;float: right; text-decoration: none;">Add Another Student</a>
    </div>
    <div class="infoSection">
        <h2>Student Information - <a
                href="index.php?com=registration&student_id=<?php echo $student_id; ?>&action=editStudent"
                class="editButton" title="Edit Student"></a></h2>


        <div class="two-thirds">
            <span class="label">Nickname:</span> <?php if ($studentInfo['nickname'] == "") {
          echo "N/A";
        } else {
          echo $studentInfo['nickname'];
        } ?><br/>
            <span class="label">Age:</span> <?php echo $student->getAge(); ?><br/>
            <span class="label">Grade:</span> <?php echo $reg->getGradeDisplay($studentInfo['grade']); ?><br/>
            <span class="label">E-mail Address:</span> <?php if ($studentInfo['email'] == "") {
          echo "N/A";
        } else {
          echo $studentInfo['email'];
        } ?>
        </div>
        <!-- <div class="one-third">
            <span class="label">Status: </span><?php echo $studentStatus; ?>
        </div>-->

    </div>
    <div class="infoSection">
        <a href="" class="showDetails right small_button">Hide Details</a>

        <h2>Enrollment Summary</h2>
        <br/>
      <?php
      if (isset($programs)) {
        foreach ($programs as $program) {
          ?>
            <div class="bigItem">
                <span class="title"><img src="<?php echo $program['icon_url']; ?>"
                                         style="width: 40px; margin-top: -25px; margin-bottom: -15px; margin-right: 20px; margin-left: -30px;"/><?php echo $program['name']; ?>
                    <span class="tuition"
                          style="float:right; width: 200px; display: none;">Program Tuition: $<?php echo $program['tuition_total']; ?></span></span>
				<span class="buttons">
					<!--<a href="#" class="reviewButton" title="Review This Program"></a>
					<a href="#" class="editButton" title="Edit This Student"></a>-->
					<a href="index.php?com=registration&ajax=unenrollFromProgram&program_id=<?php echo $program['program_id']; ?>&student_id=<?php echo $studentInfo['student_id']; ?>"
             class="deleteButton" title="Unenroll From This Program"></a>
				</span>

                <div class="itemDetails" style="display: block;">
                  <?php if ($program['has_courses']) { ?>
                    <br/>
                    <table class="dataTable">
                        <tr class="header">
                            <td>Course Name</td>
                            <td>Period</td>
                            <td>Teacher</td>
                            <td>Tuition</td>
                            <td>Registration</td>
                            <td></td>
                        </tr>
                      <?php
                      $i = 1;
                      if ($program['courses']) {
                        foreach ($program['courses'] as $course) {
                          echo "<tr><td>".$i.". ".$course['name']."</td><td>".$reg->displayPeriod($course)."</td><td>".$course['teacher_name']."</td><td align=center>$".$course['tuition_amount']."</td><td align=center>$".$course['registration_amount']."</td><td><a href=\"index.php?com=registration&ajax=unenrollFromCourse&course_id=".$course['course_id']."&program_id=".$course['program_id']."&student_id=".$studentInfo['student_id']."\" class=\"button deleteButton\" title=\"Unenroll From This Course\"></a></td></tr>";
                          $i++;
                        }
                      } else {
                        echo "<tr><td colspan=5 align=center>This student is not in any courses for ".$program['name'].".</td></tr>";
                      }
                      ?>
                    </table>

                    <br/>
                    <span class="center"><a
                            href="index.php?com=registration&view=student&action=addCourse&student_id=<?php echo $studentInfo['student_id']; ?>&program_id=<?php echo $program['program_id']; ?>"
                            class="small_button fb">Add Course</a></span>

                    <hr class="divider"/>
                  <?php } ?>
                    <h3>Program Fee Summary</h3>

                    <div class="half">
                        <span class="label">Registration Fees:</span> $<?php echo $program['registration_total']; ?>
                        <br/>
                    </div>
                    <div class="half">
                        <span class="label">Program Tuition:</span> $<?php echo $program['tuition_total']; ?><br/>
                        <span class="label">Yearly Tuition:</span> $<?php echo $program['tuition_total']; ?><br/>
                    </div>

                </div>
              <?php if (isset($campusInfo['registration_review_footnote'])) {
              echo $campusInfo['registration_review_footnote'];
            } ?>
            </div>
          <?php
        }
      }
      ?>
        <span class="center"><a
                href="index.php?com=registration&view=student&action=addProgram&student_id=<?php echo $studentInfo['student_id']; ?>"
                class="med_button fb">Enroll in Programs</a></span>
        <br style="width: 100%; clear: both;"/>

        <h3 style="text-align: center;"><?php echo $studentInfo['first_name']; ?>'s Billing Summary</h3>

        <div style="width: 325px; margin-left: auto; margin-right: auto;">
            <span class="label" style="width: 200px;">Registration Total:</span>
            $<?php echo $registrationTotal; ?><br/>
            <span class="label" style="width: 200px;">Tuition Total:</span> $<?php echo $tuitionTotal; ?>
            <br/>
            <span class="label" style="width: 200px;">Student Total:</span> $<?php echo $grandTotal; ?>
        </div>
    </div>

    <br/>
    <a href="index.php?com=registration&reviewRegistration=1" class="submitButton"
       style="margin-right: 20px;float: right; text-decoration: none;">Review Family Registration</a><a
        href="index.php?com=registration&addAnotherStudent=1" class="submitButton"
        style="margin-right: 20px;float: right; text-decoration: none;">Add Another Student</a>
    <br style="width: 100%; clear: both;"/>
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
        $(this).children(".tuition").toggle(500);
    });
    $(".showDetails").click(function () {
        if ($(this).html() == "Show Details") {
            $(this).parent().children(".bigItem").children(".itemDetails").show(500);
            $(this).html("Hide Details");
            $(".tuition").toggle(500);
        } else {
            $(this).parent().children(".bigItem").children(".itemDetails").hide(500);
            $(this).html("Show Details");
            $(".tuition").fadeIn(500);
        }

        return false;
    });
</script>