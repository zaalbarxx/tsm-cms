<div id="sideBar">
    <ul>
        <li>
            <a href="index.php?mod=registration&view=student" <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=student")) {
              echo "class='active'";
            } ?>>Students</a>
        </li>
        <!--<li>
            <a href="index.php?mod=registration&view=fees" <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=fees")) {
          echo "class='active'";
        } ?>>Fees</a>
        </li>-->
    </ul>
</div>