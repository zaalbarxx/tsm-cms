<div id="sideBar" class="well span2">
    <ul class="nav nav-list">
        <li class="nav-header">General Info</li>
        <li <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?mod=registration") && $view == null) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration">Dashboard</a>
        </li>
        <li class="nav-header">Reg Info</li>
        <li <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=family")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=family">Families</a>
        </li>
        <li <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=student")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=student">Students</a>
        </li>
        <li class="nav-header">Campus Setup</li>

        <li <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=teacher")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=teacher">Teachers</a>
        </li>
        <li <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=programs")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=programs">Programs</a>
        </li>
        <li <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=courses")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=courses">Courses</a>
        </li>
        <li <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=requirements")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=requirements">Requirements</a>
        </li>
        <li <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=periods")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=periods">Periods</a>
        </li>
        <li class="nav-header">Fee Information</li>
        <li <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=fees")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=fees">Fee List</a>
        </li>
      <?php if ($currentCampus->usesQuickbooks()) { ?>
        <li <?php if ($tsm->stringEndsWith($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=fees&action=quickbooksInfo")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=fees&action=quickbooksInfo">Quickbooks Info</a>
        </li>
        <li <?php if ($tsm->stringEndsWith($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=fees&action=quickbooksClasses")) {
          echo "class='active'";
        } ?>>
          <a href="index.php?mod=registration&view=fees&action=quickbooksClasses">Quickbooks Classes</a>
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
        <li <?php if ($tsm->stringEndsWith($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=invoice")) {
          echo "class='active'";
        } ?>>
          <a href="index.php?mod=registration&view=invoice">Invoices</a>
        </li>
        <li class="nav-header">Reporting</li>
        <li <?php if (stristr($_SERVER["REQUEST_URI"], "index.php?mod=registration&view=reports")) {
          echo "class='active'";
        } ?>>
            <a href="index.php?mod=registration&view=reports">Reports</a>
        </li>
    </ul>
</div>
