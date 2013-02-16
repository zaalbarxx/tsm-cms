<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <input id="searchItems" rel="smallItem" style="float: right; position: relative; right: 75px; top: 10px;"
           value="Search..."/>

    <h1><?php echo $pageTitle; ?> - <a
            href="index.php?com=registration&view=programs&action=viewRoster&program_id=<?php echo $program_id; ?>&downloadCSV=1"
            class="button downloadButton" title="Download CSV"></a></h1>

    <div class="programStudents">

      <?php if (isset($programStudents)) {
      foreach ($programStudents as $student) {
        ?>
          <div class="smallItem">
              <span class="title"
                    style="cursor: pointer;"><?php echo $student['first_name']." ".$student['last_name']; ?>
                  , Grade: <?php echo $student['grade']; ?></span>
              <span class="buttons"></span>

              <div class="itemDetails">
                  <span class="label">E-mail:</span> <?php
                if ($student['email'] != "") {
                  echo $student['email'];
                } else {
                  echo "N/A";
                }  ?>
              </div>
          </div>
        <?php
      }
    } else {
      echo "This program has no students enrolled.";
    } ?>
    </div>

</div>
<script type="text/javascript">
    $(".smallItem .title").click(function () {
        $(this).parent().children(".itemDetails").slideToggle();
    });
</script>