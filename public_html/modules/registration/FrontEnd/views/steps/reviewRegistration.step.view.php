<div class="contentArea">

    <h1 style="text-align: center;">Registration Review<br/><span
            style="font-size: 14px; position: relative; top: -15px;"><?php echo $campusInfo['name']; ?></h1>
    </span>

    <p style="text-align: center;">Please review the registration information for your students below.</p>

    <div style="width: 100%; display: block; position: relative;  text-align: right; float: right;">
        <a href="index.php?mod=registration&choosePaymentPlan=1" class="submitButton"
           style="margin-right: 20px;float: right; text-decoration: none;">Finalize Registration</a><a
            href="index.php?mod=registration&addAnotherStudent=1" class="submitButton"
            style="margin-right: 20px;float: right; text-decoration: none;">Add Another Student</a>
    </div>
    <br style="width: 100%; clear: both;"/>
    <br style="width: 100%; clear: both;"/>

    <div class="infoSection">
        <h2>Family Information - <a
                href="index.php?mod=registration&editFamilyInfo=1"
                class="editButton" title="Edit Family"></a></h2>

        <div class="half">
            <span class="title"
                  style="width: 150px;">Father:</span> <?php echo $familyInfo['father_first']." ".$familyInfo['father_last']; ?>
            <br/>
            <span class="title" style="width: 150px;">Father Cell:</span> <?php echo $familyInfo['father_cell']; ?>
            <br/><br/>
            <span class="title"
                  style="width: 150px;">Mother:</span> <?php echo $familyInfo['mother_first']." ".$familyInfo['mother_last']; ?>
            <br/>
            <span class="title" style="width: 150px;">Mother Cell:</span> <?php echo $familyInfo['mother_cell']; ?>

        </div>
        <div class="half">
            <span class="title" style="width: 150px;">Primary E-mail:</span> <?php echo $familyInfo['primary_email']; ?>
            <br/>
            <span class="title"
                  style="width: 150px;">Seconary E-mail:</span> <?php echo $familyInfo['secondary_email']; ?>
            <br/><br/>
            <span class="title" style="width: 150px;">Billing Address</span><br/>
            <span style="display: block; margin-left: 30px;">
            <?php echo $familyInfo['address']."<br />".$familyInfo['city'].", ".$familyInfo['state']." ".$familyInfo['zip']; ?>
            </span>
        </div>

    </div>
  <?php foreach ($students as $studentInfo) { ?>
    <div class="infoSection">
        <a href="index.php?mod=registration&reviseStudent=1&student_id=<?php echo $studentInfo['student_id']; ?>"
           class="right small_button">Revise Student</a>

        <a href="index.php?mod=registration&student_id=<?php echo $studentInfo['student_id']; ?>&action=editStudentInfo&backToReview=1"
           class="editButton" title="Edit Student" style="float: left;"></a>

        <h2 class="title"><?php echo $studentInfo['last_name'].", ".$studentInfo['first_name']; ?> - <span
                class="showDetails" style="font-size: 14px; text-decoration: underline;">show details</span>

            <div class="summary">
                <div class="icons" style="height: 45px;">
                  <?php
                  if (isset($studentInfo['programs'])) {
                    foreach ($studentInfo['programs'] as $program) {
                      echo "<img src='".$program['icon_url']."' />";
                    }
                  }
                  ?>

                </div>
                <div class="feeTotals" style="font-weight: normal; text-align: right;">
                    Registration Total: $<?php echo $studentInfo['registrationTotal']; ?><br/>Tuition Total:
                    $<?php echo $studentInfo['tuitionTotal']; ?>
                </div>
            </div>
        </h2>

        <div class="itemDetails" style="display: none">

            <div class="two-thirds">
                <span class="label">Nickname:</span> <?php if ($studentInfo['nickname'] == "") {
              echo "N/A";
            } else {
              echo $studentInfo['nickname'];
            } ?><br/>
                <span class="label">Age:</span> <?php echo $studentInfo['age']; ?><br/>
                <span class="label">Grade:</span> <?php echo $reg->getGradeDisplay($studentInfo['grade']); ?><br/>
                <span class="label">E-mail Address:</span> <?php if ($studentInfo['nickname'] == "") {
              echo "N/A";
            } else {
              echo $studentInfo['email'];
            } ?>
            </div>

            <br style="width: 100%; clear: both;"/>
            <br style="width: 100%; clear: both;"/>
            <!--<a href="" class="showDetails small_button">Hide Details</a>-->
            <h3 style="text-align: center;"><?php echo $studentInfo['first_name']; ?>'s Enrollment Summary</h3>
            <br/>
          <?php
          if (isset($studentInfo['programs'])) {
            foreach ($studentInfo['programs'] as $program) {
              ?>
                <div class="bigItem">
                <span class="title"><img src="<?php echo $program['icon_url']; ?>"
                                         style="width: 40px; margin-top: -25px; margin-bottom: -15px; margin-right: 20px; margin-left: -30px;"/><?php echo $program['name']; ?></span>
                    <a href="index.php?mod=registration&reviseStudent=1&student_id=<?php echo $studentInfo['student_id']; ?>"
                       class="right small_button" style="margin-top: -25px;">Revise Student</a>

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
                            </tr>
                          <?php
                          $i = 1;
                          if ($program['courses']) {
                            foreach ($program['courses'] as $course) {
                              echo "<tr><td>".$i.". ".$course['name']."</td><td>".$tsm->intToDay($course['day']).". ".date("g:ia", strtotime($course['start_time']))." - ".date("g:ia", strtotime($course['end_time']))."</td><td>".$course['teacher_name']."</td><td align=center>$".$course['tuition_amount']."</td><td align=center>$".$course['registration_amount']."</td></tr>";
                              $i++;
                            }
                          } else {
                            echo "<tr><td colspan=5 align=center>This student is not in any courses for ".$program['name'].".</td></tr>";
                          }
                          ?>
                        </table>
                        <br/>
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
                </div>
              <?php
            }
          }
          ?>
            <br style="width: 100%; clear: both;"/>

            <h3 style="text-align: center;"><?php echo $studentInfo['first_name']; ?>'s Billing Summary</h3>

            <div style="width: 325px; margin-left: auto; margin-right: auto;">
                <span class="label" style="width: 200px;">Registration Total:</span>
                $<?php echo $studentInfo['registrationTotal']; ?><br/>
                <span class="label" style="width: 200px;">Tuition Total:</span>
                $<?php echo $studentInfo['tuitionTotal']; ?>
                <br/>
                <span class="label" style="width: 200px;">Student Total:</span>
                $<?php echo $studentInfo['studentTotal']; ?>
            </div>
        </div>
    </div>
  <?php } ?>
  <?php if (isset($campusInfo['registration_review_footnote'])) {
  echo $campusInfo['registration_review_footnote'];
} ?>
    <br/>
    <a href="index.php?mod=registration&choosePaymentPlan=1" class="submitButton"
       style="margin-right: 20px;float: right; text-decoration: none;">Finalize Registration</a><a
        href="index.php?mod=registration&addAnotherStudent=1" class="submitButton"
        style="margin-right: 20px;float: right; text-decoration: none;">Add Another Student</a>
    <br style="width: 100%; clear: both;"/>
</div>
<script type="text/javascript">
    $(".bigItem .title,.infoSection .title").click(function () {
        $(this).parent().children(".itemDetails").slideToggle();
        $(this).children(".summary").toggle(500);
        if ($(this).children(".showDetails").html() == "show details") {
            $(this).children(".showDetails").html("hide details");
        } else {
            $(this).children(".showDetails").html("show details");
        }
    });
</script>