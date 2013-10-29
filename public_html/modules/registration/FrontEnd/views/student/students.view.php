<?php
require_once(__TSM_ROOT__."modules/registration/FrontEnd/views/sidebar.view.php");
?>

<div class="contentWithSideBar">

<h2 style="text-align: center;">Registered Students</h2>
<?php foreach ($students as $studentInfo) { ?>
<div class="infoSection" data-tsm-student-id="<?php echo $studentInfo['student_id']; ?>">

    <h2 class="title"><?php echo $studentInfo['last_name'].", ".$studentInfo['first_name']; ?> - <span
            class="showDetails" style="font-size: 14px; text-decoration: underline;">show details</span>

        <div class="summary">
            <div class="icons">
              <?php
              if (isset($studentInfo['programs'])) {
                foreach ($studentInfo['programs'] as $program) {
                  echo "<img src='".$program['icon_url']."' />";
                }
              }
              ?>

            </div>
            <div class="feeTotals" style="font-weight: normal; text-align: right;">
                Registration Total: $<?php echo $studentInfo['registrationTotal']; ?><br/>Tuition Total:
                $<?php echo $studentInfo['tuitionTotal']; ?>
            </div>
        </div>
    </h2>
</div>
  <?php } ?>
<br/>
<div style="text-align: center;"><a class="med_button" href="index.php?mod=registration&view=student&action=addEditStudent">Add Student</a></div>

<br style="width: 100%; clear: both;"/>
</div>
<script type="text/javascript">
    $(".bigItem .title,.infoSection .title").click(function () {
      window.location = "index.php?mod=registration&view=student&action=viewStudent&student_id=" + $(this).parent().attr("data-tsm-student-id")
    });
</script>
<style>
    .infoSection .title {
        width: 93%;
    }
</style>