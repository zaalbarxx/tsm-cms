<?php
//require_once(__TSM_ROOT__."views/registration/sidebar.view.php");
?>
<div class="contentArea">
    <h1 style="text-align: center;">Registration Summary</h1>

    <p style="text-align: center;">Your family registration information is below. Your account details will be available
        soon.</p>
  <?php foreach ($students as $studentInfo) { ?>
    <div class="infoSection">

        <h2><?php echo $studentInfo['last_name'].", ".$studentInfo['first_name']; ?></h2>

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
        <a href="" class="showDetails right small_button">Hide Details</a>

        <h3 style="text-align: center;"><?php echo $studentInfo['first_name']; ?>'s Enrollment Summary</h3>
        <br/>
      <?php
      if (isset($studentInfo['programs'])) {
        foreach ($studentInfo['programs'] as $program) {
          ?>
            <div class="bigItem">
                <span class="title"><?php echo $program['name']; ?><span class="tuition"
                                                                         style="margin-left: 60px; display: none;">Program Tuition: $<?php echo $program['tuition_total']; ?></span></span>

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
            <span class="label" style="width: 200px;">Tuition Total:</span> $<?php echo $studentInfo['tuitionTotal']; ?>
            <br/>
            <span class="label" style="width: 200px;">Student Total:</span> $<?php echo $studentInfo['studentTotal']; ?>
        </div>
    </div>
  <?php } ?>
    <br/>
    <br style="width: 100%; clear: both;"/>
</div>
<script type="text/javascript">
    $(".bigItem .title").click(function () {
        $(this).parent().children(".itemDetails").slideToggle();
    });
    $(".showDetails").click(function () {
        if ($(this).html() == "Show Details") {
            $(this).parent().children(".bigItem").children(".itemDetails").show(500);
            $(this).html("Hide Details");
            $(".tuition").toggle(500);
        } else {
            $(this).parent().children(".bigItem").children(".itemDetails").hide(500);
            $(this).html("Show Details");
            $(".tuition").toggle(500);
        }


        return false;
    });
</script>