<div id="sideBar">
    <ul>
        <li>
            <a href="index.php?com=registration" <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?com=registration") && $view == null) {
              echo "class='active'";
            } ?>>Dashboard</a>
        </li>
        <li>
            <a href="index.php?com=registration&view=family" <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?com=registration&view=family")) {
              echo "class='active'";
            } ?>>Families</a>
        </li>
        <li>
            <a href="index.php?com=registration&view=student" <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?com=registration&view=student")) {
              echo "class='active'";
            } ?>>Students</a>
        </li>
        <li>
            <a href="index.php?com=registration&view=teacher" <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?com=registration&view=teacher")) {
              echo "class='active'";
            } ?>>Teachers</a>
        </li>
        <li>
            <a href="index.php?com=registration&view=programs" <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?com=registration&view=programs")) {
              echo "class='active'";
            } ?>>Programs</a>
        </li>
        <li>
            <a href="index.php?com=registration&view=courses" <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?com=registration&view=courses")) {
              echo "class='active'";
            } ?>>Courses</a>
        </li>
        <li>
            <a href="index.php?com=registration&view=fees" <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?com=registration&view=fees")) {
              echo "class='active'";
            } ?>>Fees</a>
        </li>
        <li>
            <a href="index.php?com=registration&view=requirements" <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?com=registration&view=requirements")) {
              echo "class='active'";
            } ?>>Requirements</a>
        </li>
        <li>
            <a href="index.php?com=registration&view=periods" <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?com=registration&view=periods")) {
              echo "class='active'";
            } ?>>Periods</a>
        </li>
        <li>
            <a href="index.php?com=registration&view=reports" <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?com=registration&view=reports")) {
              echo "class='active'";
            } ?>>Reports</a>
        </li>
    </ul>
  <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?com=registration") && $view == null) { ?>
    <div style="text-align: center; width: 100%;">
        <form action="" method="post" id="selectSchoolYearForm" style="text-align: center;">
            <select name="setSelectedSchoolYear" id="selectSchoolYear"
                    style="font-size: 16px; padding: 10px; background: none; border: 1px solid #000;margin-left: 30px; ">
                <option value="">Change School Year</option>
              <?php for ($i = date('Y') - 1; $i < date('Y') + 5; $i++) {
              $display = $i + 1;
              echo "<option value='$i'>$i - ".$display."</option>";
            } ?>
            </select>
        </form>
        <script type="text/javascript">
            $("#selectSchoolYearForm").change(function () {
                $("#selectSchoolYearForm").submit();
            });
        </script>
        <br/>

        <form action="" method="post" id="selectCampusForm" style="text-align: center;">
            <select name="setCurrentCampusId" id="selectCampusId"
                    style="font-size: 16px; padding: 10px; background: none; border: 1px solid #000; margin-left: 30px;">
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
            $("#selectCampusId").change(function () {
                $("#selectCampusForm").submit();
            });
        </script>
        <br/><br/>
    </div>
  <?php } ?>
</div>
