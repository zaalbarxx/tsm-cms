<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h2>Report Generator</h2>

    <form id="reportChooserForm">
        <select id="reportChooser">
            <option>Choose Report Type</option>
            <option value="studentList">Student List</option>
        </select>
    </form>
</div>
<script type="text/javascript">
    $("#reportChooser").change(function () {
        window.location = window.location + "&action=" + $(this).val();
    });
</script>