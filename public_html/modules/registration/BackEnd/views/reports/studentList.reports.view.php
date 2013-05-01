<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
    <h2>Student Report</h2>

    <form id="studentReport" method="post" action="">
        <p>Display students who meet the following conditions:</p>
        <label>Status: </label><select name="student_status">
        <option value="">Any</option>
        <option value="0">Unapproved</option>
        <option value="1">Approved</option>
    </select><br/>
        <label>Between Grades: </label> <select name="grade_1">
        <option value="">Any</option>
      <?php
      for ($i = -1; $i <= 12; $i++) {
        if ($i == 0) {
          $name = "Kindergarten";
        } elseif ($i == -1) {
          $name = "Preschool";
        } else {
          $name = $i;
        }
        echo "<option value=\"$i\" $selected>$name</option>";
      }
      ?>
    </select> and <select name="grade_2">
        <option value="">Any</option>
      <?php
      for ($i = -1; $i <= 12; $i++) {
        if ($i == 0) {
          $name = "Kindergarten";
        } elseif ($i == -1) {
          $name = "Preschool";
        } else {
          $name = $i;
        }
        echo "<option value=\"$i\" $selected>$name</option>";
      }
      ?>
    </select><br/>
        <label>In Programs: </label><br/>
      <?php if (isset($programs)) {
      foreach ($programs as $program) {
        ?>
          <div style="margin: 10px;">
              <input type="checkbox" value="<?php echo $program['program_id']; ?>" name="programs[]"
                     class="programCheckBox"/> - <?php echo $program['name']; ?><br/>

              <div class="programCourseList" style="display: none; padding-left: 60px">

                <?php
                if (isset($program['courses'])) {
                  ?>
                    <br/>Also in courses: <br/><br/>
                  <?php
                  foreach ($program['courses'] as $course) {
                    ?>
                      <span style="display: inline-block; margin: 5px; 10px; width: 45%;"><input type="checkbox"
                                                                                                 value="<?php echo $course['course_id']; ?>"
                                                                                                 name="program:<?php echo $program['program_id']; ?>:courses[]"
                                                                                                 class="programCheckBox"/> - <?php echo $course['name']; ?></span>
                    <?php
                  }
                }
                ?>
              </div>
          </div>
        <?php
      }
    }
      ?>
        <!--
        <label>Include Columns: </label><br/>
      <?php foreach ($studentColumns as $column) {
          ?>
        <input type="checkbox" value="<?php echo $column['Field']; ?>" name="includeStudentColumns[]"
               class="programCheckBox"/> - <?php echo $column['Field']; ?><br/>

      <?php

        } ?>
    -->
        <br/><br/>
        <input type="hidden" name="generateReport" value="1"/>
        <input type="submit" class="btn btn-primary" value="Generate Report"/>
    </form>
</div>
<script type="text/javascript">
    $(".programCheckBox").click(function () {
        if ($(this).is(':checked')) {
            $(this).parent().children(".programCourseList").slideToggle();
        } else {
            $(this).parent().children(".programCourseList").slideToggle();
        }
    });
</script>