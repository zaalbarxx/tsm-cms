<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="span8">
    <h1><?php echo $campusInfo['name']; ?> Dashboard</h1>

    <p>You can use the links on the left to manage this campus.</p>

    <div style="margin-top: 20px;">
        <form action="" method="post" id="selectSchoolYearForm">
            <select name="setSelectedSchoolYear" id="selectSchoolYear">
                <option value="">Change School Year</option>
              <?php for ($i = date('Y'); $i < date('Y') + 1; $i++) {
              $display = $i + 1;
              echo "<option value='$i'>$i - ".$display."</option>";
            } ?>
            </select>
        </form>
        <form action="" method="post" id="selectCampusForm">
            <select name="setCurrentCampusId" id="selectCampusId">
                <option value="">Change Campus</option>
              <?php
              if ($campusList != NULL) {
                foreach ($campusList as $array) {
                  echo "  <option value='".$array['campus_id']."'>".$array['name']."</option>\n";
                }
              } else {

              }
              ?>
            </select>
        </form>
        <script type="text/javascript">
            $("#selectSchoolYearForm").change(function () {
                $("#selectSchoolYearForm").submit();
            });
            $("#selectCampusId").change(function () {
                $("#selectCampusForm").submit();
            });
        </script>
    </div>
</div>