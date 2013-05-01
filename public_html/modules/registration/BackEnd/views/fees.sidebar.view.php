<div id="sideBar" class="well span2">
    <ul class="nav nav-list">
        <li <?php if ($tsm->stringEndsWith($_SERVER["REQUEST_URI"], "index.php?mod=registration")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration">Registration</a>
        </li>
        <li <?php if ($tsm->stringEndsWith($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=fees")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=fees">Fees</a>
        </li>
      <?php if ($currentCampus->usesQuickbooks()) { ?>
        <li <?php if ($tsm->stringEndsWith($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=fees&action=quickbooksInfo")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=fees&action=quickbooksInfo">Quickbooks Info</a>
        </li>
      <?php } ?>
        <li <?php if ($tsm->stringEndsWith($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=fees&action=conditions")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=fees&action=conditions">Fee Conditions</a>
        </li>
        <li <?php if ($tsm->stringEndsWith($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=fees&action=paymentPlans")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=fees&action=paymentPlans">Payment Plans</a>
        </li>
    </ul>
</div>