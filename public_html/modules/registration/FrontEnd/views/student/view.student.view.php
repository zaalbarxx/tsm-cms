<?php
require_once(__TSM_ROOT__."modules/registration/FrontEnd/views/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?> - <a
            href="index.php?mod=registration&view=student&action=addEditStudent&student_id=<?php echo $studentInfo['student_id']; ?>"
            class="editButton" title="Edit Student"></a></h1>

    <div class="infoSection">
        <h2>Student Information</h2>

        <div class="two-thirds">
            <span class="label">Nickname:</span> <?php echo $studentInfo['nickname']; ?><br/>
            <span class="label">Age:</span> <?php echo $student->getAge(); ?><br/>
            <span class="label">Grade:</span> <?php echo $studentInfo['grade']; ?><br/>
            <span class="label">E-mail Address:</span> <?php echo $studentInfo['email']; ?>
            <br/><br/>
            <span class="label">
              <a href="index.php?mod=registration&view=student&action=editInfo&student_id=<?php echo $studentInfo['student_id']; ?>" class="small_button">Edit information</a>
            </span>
        </div>

    </div>
    <div class="infoSection">

        <h2>Enrollment Summary</h2>
        <br/>
      <?php
      if (isset($programs)) {
        foreach ($programs as $program) {
          ?>
            <div class="bigItem">
                <span class="title"><img src="<?php echo $program['icon_url']; ?>"
                                         style="width: 40px; margin-top: -25px; margin-bottom: -15px; margin-right: 20px; margin-left: -30px;"/><?php echo $program['name']; ?></span>
				<span class="buttons">
					<!--<a href="#" class="reviewButton" title="Review This Program"></a>
					<a href="#" class="editButton" title="Edit This Student"></a>-->
					<a href="index.php?mod=registration&ajax=unenrollFromProgram&student_id=<?php echo $student_id; ?>&program_id=<?php echo $program['program_id']; ?>" class="deleteButton" data-tsm-confirm-message="Are you sure that you want to unenroll <?php echo $studentInfo['first_name']; ?> from <?php echo $program['name']; ?>?" title="Unenroll From This Program"></a>
				</span>

                <div class="itemDetails" style="display: block;">
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
                          echo "<tr><td>".$i.". ".$course['name']."</td><td>".$tsm->intToDay($course['day']).". ".date("g:ia", strtotime($course['start_time']))." - ".date("g:ia", strtotime($course['end_time']))."</td><td>".$course['teacher_name']."</td><td align=center>$".$course['tuition_amount']."</td><td align=center>$".$course['registration_amount']."</td><td><a href=\"index.php?mod=registration&ajax=unenrollFromCourse&course_id=".$course['course_id']."&student_id=".$student_id."&program_id=".$course['program_id']."\" title=\"Unenroll From This Course\" data-tsm-course-id=\"".$course['course_id']."\" data-tsm-program-id=\"".$course['program_id']."\"  data-tsm-confirm-message=\"Are you sure that you want to unenroll ".$studentInfo['first_name']." from ".$course['name']."?\"  class=\"deleteButton button\"></a></td></tr>";
                          $i++;
                        }
                      } else {
                        echo "<tr><td colspan=5 align=center>This student is not in any courses for ".$program['name'].".</td></tr>";
                      }
                      ?>
                    </table>
                    <br/>
                    <span class="center"><a
                            href="index.php?mod=registration&view=student&action=addCourse&student_id=<?php echo $studentInfo['student_id']; ?>&program_id=<?php echo $program['program_id']; ?>"
                            class="small_button fb">Add Course</a></span>
                    <hr class="divider"/>
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
        <span class="center"><a
                href="index.php?mod=registration&view=student&action=addProgram&student_id=<?php echo $studentInfo['student_id']; ?>"
                class="med_button fb">Enroll in Additional Programs</a></span>
    </div>
    <div class="infoSection">
        <h2>Billing Summary</h2>
        Registration Total: $<?php echo $registrationTotal; ?><br/>
        Tuition Total: $<?php echo $tuitionTotal; ?><br/>
        Grand Total: $<?php echo $grandTotal; ?>

    </div>

</div>
<script type="text/javascript">
    $(".bigItem .title").click(function () {
        $(this).parent().children(".itemDetails").slideToggle();
        $(this).children(".summary").toggle(500);
        if ($(this).children(".showDetails").html() == "show details") {
            $(this).children(".showDetails").html("hide details");
        } else {
            $(this).children(".showDetails").html("show details");
        }
    });
    $(".deleteButton").click(function () {
      var confirmDelete = confirm($(this).attr("data-tsm-confirm-message"));
      if(confirmDelete){
        $.get($(this).attr("href"), function (data) {
          var response = JSON.parse(data);
          if (response.alertMessage != null) {
            alert(response.alertMessage);
          }
          if (response.success == true) {
            window.location.reload();
          }
        });
      }
        return false;

     });

    /*
    $(".showDetails").click(function () {
        if ($(this).html() == "Show Details") {
            $(this).parent().children(".bigItem").children(".itemDetails").show(500);
            $(this).html("Hide Details");
        } else {
            $(this).parent().children(".bigItem").children(".itemDetails").hide(500);
            $(this).html("Show Details");
        }


        return false;
    });
    */
</script>