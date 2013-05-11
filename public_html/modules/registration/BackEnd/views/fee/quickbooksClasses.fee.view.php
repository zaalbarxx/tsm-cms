<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<style>
    .smallItem .buttons input {
        top: 2px;
    }
</style>
<div class="span9">
    <h1><?php echo $pageTitle; ?></h1>
  <?php if (isset($programs)) { ?>
  <form id="addToFees" method="post">
  <?php foreach ($programs as $program) {
    //if (isset($program['fees'])) {
    ?>
        <h2><?php echo $program['name']." Fees"; ?></h2>
    <?php
    if (isset($program['fees'])) {
      foreach ($program['fees'] as $fee) {
        ?>
          <div class="smallItem well well-small">
              <span class="title"><?php echo $fee['name']." - $".$fee['amount']; ?></span>
          <span class="buttons">
            QB Class: <select name="programFeeId:<?php echo $fee['program_fee_id']; ?>">
              <option value="" <?php if($fee['quickbooks_class_id'] == ""){
                echo " selected=selected ";
              } ?>>None</option>
              <?php
              if(isset($classes)){
                foreach($classes as $classId=>$className){
                  echo "<option value=\"$classId\"";
                  if($fee['quickbooks_class_id'] == $classId){
                    echo " selected=selected ";
                  }
                  echo ">".$className."</option>";
                }

              }
              ?>
            </select>
          </span>
          </div>
        <?php
      }
    }?>
        <div style="margin-left: 40px;">
          <?php
          if(isset($program['courses'])){
          foreach ($program['courses'] as $course) { ?>
            <h3><?php echo $program['name']." ".$course['name']." Fees "; ?></h3>
          <?php
          if (isset($course['fees'])) {
            foreach ($course['fees'] as $fee) {
              ?>
                <div class="smallItem well well-small" style="width: 810px;">
                    <span class="title"><?php echo $fee['name']." - $".$fee['amount']; ?></span>
              <span class="buttons">
                QB Class: <select name="courseFeeId:<?php echo $fee['course_fee_id']; ?>">
                  <option value="" <?php if($fee['quickbooks_class_id'] == ""){
                    echo " selected=selected ";
                  } ?>>None</option>
                  <?php
                  if(isset($classes)){
                    foreach($classes as $classId=>$className){
                      echo "<option value=\"$classId\"";
                      if($fee['quickbooks_class_id'] == $classId){
                        echo " selected=selected ";
                      }
                      echo ">".$className."</option>";
                    }

                  }
                  ?>
                </select>
              </span>
                </div>
              <?php
            }
          }
          ?>
          <?php
          if (isset($course['courseOnlyFees'])) {
            foreach ($course['courseOnlyFees'] as $fee) {
              ?>
                <div class="smallItem well well-small" style="width: 710px;">
                    <span class="title"><?php echo $fee['name']." - $".$fee['amount']; ?> - All Programs</span>
              <span class="buttons">
                QB Class: <select name="courseFeeId:<?php echo $fee['course_fee_id']; ?>">
                  <option value="" <?php if($fee['quickbooks_class_id'] == ""){
                    echo " selected=selected ";
                  } ?>>None</option>
                  <?php
                  if(isset($classes)){
                    foreach($classes as $classId=>$className){
                      echo "<option value=\"$classId\"";
                      if($fee['quickbooks_class_id'] == $classId){
                        echo " selected=selected ";
                      }
                      echo ">".$className."</option>";
                    }

                  }
                  ?>
                </select>
              </span>
                </div>
              <?php
            }
          } ?>
          <?php }
          }
          ?>
        </div>
    <?php //} ?>
    <?php } ?>
  <?php } else { ?>
    <span>There are no fees available.</span><br/><br/>
  <?php } ?>
    <input type="hidden" name="saveClasses" value="1"/>
    <input type="submit" style="float: right;" class="btn btn-primary" value="Save Selected"/>
    <br/><br/>
</form>
</div>
<script type="text/javascript">
    $("#addToFees").submit(function () {
        var formData = $(this).serialize();
        $.post(window.location, formData, function (data) {
            if (data == "1") {
                parent.window.location.reload();
            } else {
                alert("There was an error adding the condition to the fees.");
                parent.window.location.reload();
            }
        });

        return false;
    });
</script>