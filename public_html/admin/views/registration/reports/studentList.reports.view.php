<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h2>Student Report</h2>

    <form id="studentReport">
        <p>Display students who meet the following conditions:</p>
        <label>Status: </label><select>
        <option>Any</option>
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
                                                                                                 name="program:<?php $program['program_id']; ?>_courses[]"
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
        <label>Include Columns: </label><br/>
      <?php foreach ($studentColumns as $column) {
      ?>
        <input type="checkbox" value="<?php echo $column['Field']; ?>" name="includeStudentColumns[]"
               class="programCheckBox"/> - <?php echo $column['Field']; ?><br/>

      <?php

    } ?>
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