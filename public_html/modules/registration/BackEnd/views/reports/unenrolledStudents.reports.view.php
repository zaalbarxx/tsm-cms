<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
    <h2>Unenrolled Students - <a
            href="index.php?mod=registration&view=reports&action=unenrolledStudents&downloadCSV=1"
            class="button downloadButton" title="Download CSV"></a></h2>
  <?php
  if (isset($students)) {
    foreach ($students as $student) {
      ?>
        <div class="smallItem well well-small">
            <a class="title"
               href="index.php?mod=registration&view=student&action=viewStudent&student_id=<?php echo $student['student_id']; ?>"><?php echo $student['last_name'].", ".$student['first_name']; ?></a>
              <span class="buttons"><a
                      href="index.php?mod=registration&view=student&action=viewStudent&student_id=<?php echo $student['student_id']; ?>"
                      class="reviewButton" title="Review This Student"></a></span>

            <div class="itemDetails">
            </div>
        </div>
      <?php
    }
  }
  ?>
</div>