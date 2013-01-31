<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>

<div class="contentWithSideBar">
    <input id="searchItems" rel="smallItem" style="float: right; position: relative; right: 75px; top: 10px;"
           value="Search..."/>

    <h1><?php echo $pageTitle; ?></h1>
  <?php if ($courses) { ?>
  <form id="addCourses" method="post">
  <?php foreach ($courses as $course) { ?>
        <div class="smallItem">
            <span class="title"><?php echo $course['name']; ?></span>
				<span class="buttons">
				<a href="index.php?com=registration&view=programs&action=addCourse&program_id=<?php echo $programInfo['program_id']; ?>&addCourse=<?php echo $course['course_id']; ?>"
           class="addButton24" title="Add to <?php echo $programInfo['name']; ?>"></a>
            <input type="checkbox" name="course_<?php echo $course['course_id']; ?>"
                   value="<?php echo $course['course_id']; ?>"/>
				</span>
        </div>
    <?php } ?>
  <?php } else { ?>
    <span>There are no courses available.</span><br/><br/>
  <?php } ?>
    <input type="hidden" name="addCourses" value="1"/>
    <input type="submit" style="float: right;" class="submitButton" value="Add Selected"/>
</form>
</div>
<script type="text/javascript">
    $("#addCourses").submit(function () {
        var formData = $(this).serialize();
        $.post(window.location, formData, function (data) {
            if (data == "1") {
                parent.window.location.reload();
            } else {
                alert("There was an error adding <?php $course['name']; ?> to the program. It may already be added.");
                parent.window.location.reload();
            }
        });

        return false;
    });
    $(document).ready(function () {
        $(".addButton24").click(function () {
            $.get($(this).attr('href'), function (data) {
                if (data == "0") {
                    alert("There was an error adding <?php $course['name']; ?> to the program. It may already be added.");
                    parent.window.location.reload();
                } else {

                }
            });

            return false;
        });
    });
</script>