<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="span9">
    <input id="searchItems" rel="smallItem" class="search-query" value="Search..."/>

    <h1>Available Courses - <a
            href="index.php?com=registration&view=courses&action=addEditCourse" class="btn btn-primary"
            title="Add a Course">Add</a></h1>

  <?php
  if ($courseList) {
    foreach ($courseList as $course) {
      ?>
        <div class="smallItem well well-small">
            <a class="title"
               href="index.php?com=registration&view=courses&action=viewCourse&course_id=<?php echo $course['course_id']; ?>"><?php echo $course['name']; ?></a>
                <span class="buttons"><a
                        href="index.php?com=registration&view=courses&action=viewRoster&course_id=<?php echo $course['course_id']; ?>"
                        class="rosterButton" title="Course Roster"></a><a
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