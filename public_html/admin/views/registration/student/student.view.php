<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<style>
    .smallItem .title {
        cursor: pointer;
    }
</style>
<div class="span9">
    <h1>Students</h1>

    <p>There are <?php echo $numStudents; ?> students enrolled.</p>
  <?php
  foreach ($students as $student) {
    ?>
      <div class="smallItem well well-small">
          <a class="title"
             href="index.php?com=registration&view=student&action=viewStudent&student_id=<?php echo $student['student_id']; ?>"><?php echo $student['last_name'].", ".$student['first_name']; ?></a>
              <span class="buttons"><a
                      href="index.php?com=registration&view=student&action=viewStudent&student_id=<?php echo $student['student_id']; ?>"
                      class="reviewButton" title="Review This Student"></a></span>

          <div class="itemDetails">
          </div>
      </div>
    <?php
  }
  ?>
</div>
<script type="text/javascript">
    /*
    $(".smallItem .title").click( function(){
      $(this).parent().children(".itemDetails").slideToggle();
    });
    */
</script>