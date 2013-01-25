<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>

<div class="contentWithSideBar">
    <input id="searchItems" rel="smallItem" style="float: right; position: relative; right: 75px; top: 10px;"
           value="Search..."/>

    <h1><?php echo $pageTitle; ?></h1>
  <?php if ($courses) { ?>
  <?php foreach ($courses as $course) { ?>
        <div class="smallItem">
            <span class="title"><?php echo $course['name']; ?></span>
				<span class="buttons">
				<a href="index.php?com=registration&view=programs&action=addCourse&program_id=<?php echo $programInfo['program_id']; ?>&addCourse=<?php echo $course['course_id']; ?>"
           class="addButton24" title="Add to <?php echo $programInfo['name']; ?>"></a>
				</span>
        </div>
    <?php } ?>
  <?php } else { ?>
    <span>There are no courses available.</span><br/><br/>
  <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".addButton24").click(function () {
            $.get($(this).attr('href'), function (data) {
                if (data == "0") {
                    alert("There was an error adding <?php $course['name']; ?> to the program. It may already be added.");
                    parent.window.location.reload();
                } else {
                    parent.window.location.reload();
                }
            });

            return false;
        });
    });
</script>