<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
//todo: add the list of fees that apply to each program here
?>
<script>
	$(document).ready(function(){
			$('#datetimepicker').datetimepicker({
				language:'en',
				weekStart:1
			})
	});
</script>
<div class='span9'>
<h1><?php echo $pageTitle; ?></h1>
    <div class="smallItem well well-small">
		<form method='POST' action="index.php?mod=registration&view=student&action=editRegistrationDate&student_id=<?php echo $student_id; ?>&student_program_id=<?php echo $student_program_id;?>">
			<label for='registration_date'>Registration date:</label>
			<div id='datetimepicker' class='input-append date'>
				<input data-format='yyyy-MM-dd hh:mm:ss' type='text' name='registration_date' value="<?php echo $registration_date;?>">
				<span class='add-on'>
					<i data-time-icon='icon-time' data-time-icon='icon-calendar'></i>
				</span>
			</div>
			<br>
			<input type='submit' class='btn btn-primary' value='Edit'>
		</form>
    </div>
</div>