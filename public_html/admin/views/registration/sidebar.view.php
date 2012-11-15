<div id="sideBar">
  <ul>
    <li>
      <a href="index.php?com=registration" <?php if(stristr($_SERVER["REQUEST_URI"],"index.php?com=registration") && $view == null){ echo "class='active'"; } ?>>Dashboard</a>
    </li>
    <li>
      <a href="index.php?com=registration&view=family" <?php if(stristr($_SERVER["REQUEST_URI"],"index.php?com=registration&view=family")){ echo "class='active'"; } ?>>Families</a>
    </li>
    <li>
      <a href="index.php?com=registration&view=students" <?php if(stristr($_SERVER["REQUEST_URI"],"index.php?com=registration&view=students")){ echo "class='active'"; } ?>>Students</a>
    </li>
    <li>
      <a href="index.php?com=registration&view=teachers" <?php if(stristr($_SERVER["REQUEST_URI"],"index.php?com=registration&view=teachers")){ echo "class='active'"; } ?>>Teachers</a>
    </li>
    <li>
      <a href="index.php?com=registration&view=programs" <?php if(stristr($_SERVER["REQUEST_URI"],"index.php?com=registration&view=programs")){ echo "class='active'"; } ?>>Programs</a>
    </li>
    <li>
      <a href="index.php?com=registration&view=classes" <?php if(stristr($_SERVER["REQUEST_URI"],"index.php?com=registration&view=classes")){ echo "class='active'"; } ?>>Classes</a>
    </li>
    <li>
      <a href="index.php?com=registration&view=fees" <?php if(stristr($_SERVER["REQUEST_URI"],"index.php?com=registration&view=fees")){ echo "class='active'"; } ?>>Fees</a>
    </li>
    <li>
      <a href="index.php?com=registration&view=requirements" <?php if(stristr($_SERVER["REQUEST_URI"],"index.php?com=registration&view=requirements")){ echo "class='active'"; } ?>>Requirements</a>
    </li>
  </ul>
</div>