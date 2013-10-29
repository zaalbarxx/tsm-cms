<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
    <h2>Report Generator</h2>

    <form id="reportChooserForm">
        <select id="reportChooser">
            <option>Choose Report Type</option>
            <option value="studentList">Student List</option>
	          <option value="tshirtSizes">T-Shirt Sizes</option>
            <option value="unenrolledStudents">Unenrolled Students</option>
            <option value="unfinalizedFamilies">Unfinalized Families</option>
            <option value="finalizedFamilies">Finalized Families</option>
	        <?php if($_SESSION['adminUser']['id'] == 1 or $_SESSION['adminUser']['id'] == 2){ ?>
            <option value="totalRevenue">Total Revenue</option>
	        <?php } ?>

        </select>
    </form>
</div>
<script type="text/javascript">
    $("#reportChooser").change(function () {
        window.location = window.location + "&action=" + $(this).val();
    });
</script>