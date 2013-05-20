<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<style>
    .smallItem .title {
        cursor: pointer;
    }
</style>
<div class="span9">
    <input id="searchItems" rel="smallItem" class="search-query" style="float: right; position: relative; top: 10px;"
           value="Search..."/>

    <h1>Students</h1>

    <p>There are <?php echo $numStudents; ?> students enrolled.</p>
  <?php
  foreach ($students as $student) {
    ?>
      <div class="smallItem well well-small">
          <a class="title"
             href="index.php?mod=registration&view=student&action=viewStudent&student_id=<?php echo $student['student_id']; ?>"><?php echo $student['last_name'].", ".$student['first_name']; ?></a>
              <span class="buttons"><a
                      href="index.php?mod=registration&view=student&action=viewStudent&student_id=<?php echo $student['student_id']; ?>"
                      class="reviewButton" title="Review This Student"></a></span>

          <div class="itemDetails">
            <?php
            /* This code is useful for making sure everyone was assigned the correct fees
            $studentObject = new TSM_REGISTRATION_STUDENT($student['student_id']);
            $processFees = $studentObject->processFees(true);
            if((isset($processFees['addFees']) || isset($processFees['removeFees'])) && !isset($processFees['removeButInvoiced'])){
              echo "Okay to process: ";
              print_r($processFees);
              //$studentObject->processFees();
            } else if(isset($processFees['addFees']) || isset($processFees['removeFees']) || isset($processFees['removeButInvoiced'])){
              echo "Not okay to process: ";
              print_r($processFees);
              //$studentObject->processFees();
              //die();
            }
            */
            ?>
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