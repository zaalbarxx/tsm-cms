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
    </ul>
</div>