<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
//todo: add the list of fees that apply to each program here
?>
<div class='span9'>
<h1><?php echo $pageTitle; ?></h1>
    <div class="smallItem well well-small">
		<form method='POST' action="index.php?mod=registration&view=student&action=editRegistrationDate&student_id=<?php echo $student_id; ?>&student_program_id=<?php echo $student_program_id;?>">
			<label for='registration_date'>Registration date:</label><input type='text' name='registration_date' value="<?php echo $student_program['registration_date'];?>">
			<br>
			<input type='submit' class='btn btn-primary' value='Edit'>
		</form>

    </div>
</div>