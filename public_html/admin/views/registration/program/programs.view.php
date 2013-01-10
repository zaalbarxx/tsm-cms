<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1>Available Programs</h2>
        <span style="float: right; margin-top: -45px; right: 20px; position: relative;"><a
                href="index.php?com=registration&view=programs&action=addEditProgram" class="addButton"
                title="Add a Program"></a></span>
      <?php
      if ($programList) {
        foreach ($programList as $program) {
          ?>
            <div class="bigItem">
                <a class="title"
                   href="index.php?com=registration&view=programs&action=viewProgram&program_id=<?php echo $program['program_id']; ?>"><?php echo $program['name']; ?></a>
                <span class="buttons"><a
                        href="index.php?com=registration&view=programs&action=viewProgram&program_id=<?php echo $program['program_id']; ?>"
                        class="reviewButton" title="Review This Program"></a><a
                        href="index.php?com=registration&view=programs&action=addEditProgram&program_id=<?php echo $program['program_id']; ?>"
                        class="editButton" title="Edit This Program"></a><a
                        href="index.php?com=registration&view=programs&action=deleteProgram&programId=<?php echo $program['program_id']; ?>"
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
    /*
    $(".bigItem .title").click( function(){
      $(this).parent().children(".itemDetails").slideToggle();
    });
    */
</script>