<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="span9">
    <h1>Available Programs</h1>
        <span style="float: right; margin-top: -45px; right: 20px; position: relative;"><a
                href="index.php?com=registration&view=programs&action=addEditProgram" class="addButton"
                title="Add a Program"></a></span>
  <?php
  if ($programList) {
    foreach ($programList as $program) {
      ?>
        <div class="smallItem well well-small">
            <span class="title"
                  href="index.php?com=registration&view=programs&action=viewProgram&program_id=<?php echo $program['program_id']; ?>"><?php echo $program['name']; ?></span>
                <span class="buttons"><a
                        href="index.php?com=registration&view=programs&action=viewRoster&program_id=<?php echo $program['program_id']; ?>"
                        class="rosterButton" title="Program Roster"></a><a
                        href="index.php?com=registration&view=programs&action=viewProgram&program_id=<?php echo $program['program_id']; ?>"
                        class="reviewButton" title="Review This Program"></a><a
                        href="index.php?com=registration&view=programs&action=addEditProgram&program_id=<?php echo $program['program_id']; ?>"
                        class="editButton" title="Edit This Program"></a><a
                        href="index.php?com=registration&ajax=deleteProgram&programId=<?php echo $program['program_id']; ?>"
                        class="deleteButton" title="Delete Program"></a></span>

            <div class="itemDetails">
                Students Enrolled: <?php echo $program['num_students']; ?>
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
                alert("Program successfully deleted.");
                window.location.reload();
            } else {
                alert("The Program could not be deleted.");
            }
        });
        return false;
    });
    $(".smallItem .title").click(function () {
        $(this).parent().children(".itemDetails").slideToggle();
    });
</script>