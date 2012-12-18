<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
	<h1><?php echo $pageTitle; ?> - <a href="index.php?com=registration&view=student&action=addEditStudent&student_id=<?php echo $studentInfo['student_id']; ?>" class="editButton" title="Edit Student"></a></h1>
	<div class="infoSection">
		<h2>Student Information</h2>
		<div class="two-thirds">
			<span class="label">Nickname:</span> <?php echo $studentInfo['nickname']; ?><br />
			<span class="label">Age:</span> <?php echo $studentInfo['age']; ?><br />
			<span class="label">Grade:</span> <?php echo $studentInfo['grade']; ?><br />
			<span class="label">E-mail Address:</span> <?php echo $studentInfo['email']; ?>
		</div>
		<div class="one-third">
		<span class="label">Status: </span>Unapproved
		</div>
		
	</div>
	<div class="infoSection">
		<a href="" class="showDetails right small_button">Show Details</a>
		<h2>Enrollment Summary</h2>
		<br />
	<?php
	if(isset($programs)){
		foreach($programs as $program){
			?>
			<div class="bigItem">
				<span class="title"><?php echo $program['name']; ?></span>
				<span class="buttons">
					<!--<a href="#" class="reviewButton" title="Review This Program"></a>
					<a href="#" class="editButton" title="Edit This Student"></a>-->
					<a href="#" class="deleteButton" title="Unenroll From This Program"></a>
				</span>
				<div class="itemDetails">
					<br />
					<table class="dataTable">
						<tr class="header"><td>Course Name</td><td>Period</td><td>Total Fees</td></tr>
						<?php 
						$i = 1;
						foreach($program['courses'] as $course){
							echo "<tr><td>".$i.". ".$course['name']."</td><td>".$tsm->intToDay($course['day']).". ".date("g:ia",strtotime($course['start_time']))." - ".date("g:ia",strtotime($course['end_time']))."</td><td></td></tr>";
							$i++;
						}
						?>
					</table>
					<br />
					<span class="center"><a href="" class="small_button">Add Course</a></span>
					<hr class="divider" />
					<h3>Program Fee Summary</h3>
					<div class="half">
						<span class="label">Registration Fee:</span> $0.00<br />
					</div>
					<div class="half">
										<span class="label">Yearly Tuition:</span> $0.00<br />
					</div>
					
				</div>
			</div>
			<span class="center"><a href="index.php?com=registration&view=student&action=addProgram&student_id=<?php echo $studentInfo['student_id']; ?>" class="med_button fb">Enroll in Additional Programs</a></span>
			<?php
		}
	}
	?>
	</div>
	<div class="infoSection">
		<h2>Billing Summary</h2>
	</div>
	
</div>
<script type="text/javascript">
$(".bigItem .title").click( function(){
  $(this).parent().children(".itemDetails").slideToggle();
});
$(".showDetails").click( function(){
		if($(this).html() == "Show Details"){
			$(this).parent().children(".bigItem").children(".itemDetails").show(500);
			$(this).html("Hide Details");
		} else {
			$(this).parent().children(".bigItem").children(".itemDetails").hide(500);
			$(this).html("Show Details");
		}
		
		
		return false;
});
</script>