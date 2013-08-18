<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
    <h2>Revenue Summary</h2>
    Total Tuition: <?php echo "$".$totalTuition; ?><br/>
		Total Revenue (Finalized Families): <?php echo "$".number_format($totalFinalizedRevenue,2); ?><br />
    Total Registration: <?php echo "$".$totalRegistration; ?><br/>
</div>