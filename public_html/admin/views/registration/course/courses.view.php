<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1>Available Courses</h1>
        <span style="float: right; margin-top: -45px; right: 20px; position: relative;"><a
                href="index.php?com=registration&view=courses&action=addEditCourse" class="addButton"
                title="Add a Course"></a></span>
  <?php
  if ($courseList) {
    foreach ($courseList as $course) {
      ?>
        <div class="smallItem">
            <a class="title"
               href="index.php?com=registration&view=courses&action=viewCourse&course_id=<?php echo $course['course_id']; ?>"><?php echo $course['name']; ?></a>
                <span class="buttons"><a
                        href="index.php?com=registration&view=courses&action=viewCourse&course_id=<?php echo $course['course_id']; ?>"
                        class="reviewButton" title="Review This Course"></a><a
                        href="index.php?com=registration&view=courses&action=addEditCourse&course_id=<?php echo $course['course_id']; ?>"
                        class="editButton" title="Edit This Course"></a><a
                        href="index.php?com=registration&ajax=deleteCourse&courseId=<?php echo $course['course_id']; ?>"
                        class="deleteButton" title="Delete Course"></a></span>

            <div class="itemDetails">
                Students Enrolled: <?php echo $course['num_students']; ?>
            </div>
        </div>
      <?php
    }
  }
  ?>
</div>
<script type="text/javascript">
    $(".deleteButton").click(function () {
        $.get($(this).attr("href"), function (data) {
            if (data == "1") {
                alert("Course successfully deleted.");
                window.location.reload();
            } else {
                alert("The Course could not be deleted.");
            }
        });
        return false;
    });
</script>