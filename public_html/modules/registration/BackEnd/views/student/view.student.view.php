<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
//todo: add the list of fees that apply to each program here
?>
<div class="span9">
    <h1><?php echo $pageTitle; ?> - <a
            href="index.php?mod=registration&view=student&action=addEditStudent&student_id=<?php echo $studentInfo['student_id']; ?>"
            class="editButton fb" title="Edit Student"></a></h1>

    <div class="well well-large">
        <h2>Student Information</h2>
        <strong>Nickname:</strong> <?php echo $studentInfo['nickname']; ?><br/>
        <strong>Age:</strong> <?php echo $student->getAge(); ?><br/>
        <strong>Grade:</strong> <?php echo $studentInfo['grade']; ?><br/>
        <strong>E-mail Address:</strong> <?php echo $studentInfo['email']; ?><br/>
        <strong>Status: </strong><?php echo $studentStatus; ?><br/>
    </div>
    <div class="well well-large">
        <a href="" class="showDetails right btn">Hide Details</a>

        <h2>Enrollment Summary</h2>
        <br/>
      <?php
      if (isset($programs)) {
        foreach ($programs as $program) {
          ?>
            <div class="bigItem well">
                <span class="title"><?php echo $program['name']; ?></span>
				<span class="buttons">
					<!--<a href="#" class="reviewButton" title="Review This Program"></a>
					<a href="#" class="editButton" title="Edit This Student"></a>-->
					<a href="index.php?mod=registration&ajax=unenrollStudentFromProgram&student_id=<?php echo $student_id; ?>&program_id=<?php echo $program['program_id']; ?>"
             class="deleteButton deleteProgram" title="Unenroll From This Program" data-tsm-program-id="<?php echo $program['program_id']; ?>"></a>
				</span>

                <div class="itemDetails" style="display: block;">
                    <br/>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <td>Course Name</td>
                            <td>Period</td>
                            <td>Teacher</td>
                            <td>Tuition</td>
                            <td>Registration</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                          <?php
                          $i = 1;
                          if ($program['courses']) {
                            foreach ($program['courses'] as $course) {
                              echo "<tr><td>".$i.". ".$course['name']."</td><td><a href='index.php?mod=registration&view=student&action=changeStudentPeriodForCourse&course_period_id=".$course['course_period_id']."&student_id=".$student_id."&course_id=".$course['course_id']."&program_id=".$program['program_id']."' class='fb'>".$tsm->intToDay($course['day']).". ".date("g:ia", strtotime($course['start_time']))." - ".date("g:ia", strtotime($course['end_time']))."</a></td><td>".$course['teacher_name']."</td><td align=center>";
                              if(isset($course['tuition_popover'])){
                                echo "<span class=\"hiddenFees\" data-content=\"".$course['tuition_popover']."\" data-original-title=\"Tuition Fees\" style=\"display: block;\">$".$course['tuition_amount']."</span>";
                              } else {
                                echo "$".$course['tuition_amount'];
                              }
                              echo "</td><td align=center>";
                              if(isset($course['registration_popover'])){
                                echo "<span class=\"hiddenFees\" data-content=\"".$course['registration_popover']."\" data-original-title=\"Registration Fees\" style=\"display: block;\">$".$course['registration_amount']."</span>";
                              } else {
                                echo "$".$course['registration_amount'];
                              }
                              echo "</td><td><a href=\"index.php?mod=registration&ajax=unenrollStudentFromCourse&course_id=".$course['course_id']."&student_id=".$student_id."&program_id=".$course['program_id']."\" title=\"Unenroll From This Course\" data-tsm-course-id=\"".$course['course_id']."\" data-tsm-program-id=\"".$course['program_id']."\" class=\"deleteButton deleteCourse btn btn-danger btn-small\">Unenroll</a></td></tr>";
                              $i++;
                            }
                          } else {
                            echo "<tr class='warning'><td colspan=6 align=center style='text-align: center;'>This student is not in any courses for ".$program['name'].".</td></tr>";
                          }
                          ?>
                        </tbody>
                    </table>
                    <br/>
                    <span class="center"><a
                            href="index.php?mod=registration&view=student&action=addCourse&student_id=<?php echo $studentInfo['student_id']; ?>&program_id=<?php echo $program['program_id']; ?>"
                            class="btn btn-primary fb">Add Course</a></span>
                    <hr class="divider"/>
                    <h3>Program Fee Summary</h3>

                    <div class="half">
                        <strong>Registration Fees:</strong> $<?php echo $program['registration_total']; ?>
                        <br/>
                    </div>
                    <div class="half">
                        <strong>Registration Time:</strong> <?php echo $program['registration_date']; ?>&nbsp;&nbsp;<a class='btn btn-mini' href='index.php?mod=registration&view=student&action=editRegistrationDate&student_id=<?php echo $studentInfo['student_id']; ?>&student_program_id=<?php echo $program['student_program_id']; ?>'>Edit</a><br/>
                        <strong>Program Tuition:</strong> $<?php echo $program['tuition_total']; ?><br/>
                        <strong>Yearly Tuition:</strong> $<?php echo $program['tuition_total']; ?><br/>
                    </div>

                </div>
            </div>
          <?php
        }
      }
      ?>
        <span class="center"><a
                href="index.php?mod=registration&view=student&action=addProgram&student_id=<?php echo $studentInfo['student_id']; ?>"
                class="btn btn-large fb">Enroll in Additional Programs</a></span>
    </div>
    <div class="well well-large">
        <h2>Billing Summary</h2>
        Registration Total: $<?php echo $registrationTotal; ?><br/>
        Tuition Total: $<?php echo $tuitionTotal; ?><br/>
        Grand Total: $<?php echo $grandTotal; ?>

    </div>

</div>
<script type="text/javascript">
    $(".bigItem .title").click(function () {
        $(this).parent().children(".itemDetails").slideToggle();
    });
    $(".hiddenFees").popover({
      html: true,
      trigger: 'hover',
      placement: 'top'
    });
    $(".deleteProgram").click(function () {
      var program_id = $(this).attr("data-tsm-program-id");
      $.get($(this).attr("href"), function (data) {
        var response = JSON.parse(data);
        if (response.success == true) {
          window.location.reload();
        } else if(response.error == 1){
          //handle enrolled in courses
          alert(response.alertMessage);

        } else if(response.error == 2){
          //handle fees can't be removed.
          $.get("index.php?mod=registration&ajax=getHandleFeesView&student_id=<?php echo $student_id; ?>&program_id=" + program_id + "&feesToHandle=" + response.nonRemovableFees,function(data){
            $("body").append(data);
            $("#feesToHandle").modal().on("hidden",function(){
              $(this).remove();
            });

            //alert(data);
          });


        }
      });
      return false;
    });
    $(".deleteCourse").click(function () {
      var course_id = $(this).attr("data-tsm-course-id");
      var program_id = $(this).attr("data-tsm-program-id");
      $.get($(this).attr("href"), function (data) {
        var response = JSON.parse(data);
        if (response.success == true) {
          window.location.reload();
        } else if(response.error == 1){
          //handle enrolled in courses
          alert(response.alertMessage);

        } else if(response.error == 2){
          //handle fees can't be removed.
          $.get("index.php?mod=registration&ajax=getHandleFeesView&student_id=<?php echo $student_id; ?>&program_id=" + program_id + "&course_id=" + course_id + "&feesToHandle=" + response.nonRemovableFees,function(data){
            $("body").append(data);
            $("#feesToHandle").modal().on("hidden",function(){
              $(this).remove();
            });

            //alert(data);
          });


        }
      });
      return false;
    });

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
    /*
    $(".button").click(function () {
        $.get($(this).attr('href'), function (data) {
            if (data == "1") {
                window.location.reload();
            } else {
                alert("Fees cannot yet be deleted. This feature is not yet complete.");
            }
        });
        return false;
    });
    */
</script>