<div class="contentArea">
<h1 style="text-align: center;">Registration Review</h1>
<p style="text-align: center;">Please review the registration information for your students below.</p>
<?php foreach($students as $studentInfo){ ?>
	<div class="infoSection">
		<a href="index.php?com=registration&reviseStudent=1&student_id=<?php echo $studentInfo['student_id']; ?>" class="right small_button">Revise Student</a>
		<h2><?php echo $studentInfo['last_name'].", ".$studentInfo['first_name']; ?></h2>
		<div class="two-thirds">
			<span class="label">Nickname:</span> <?php echo $studentInfo['nickname']; ?><br />
			<span class="label">Age:</span> <?php echo $studentInfo['age']; ?><br />
			<span class="label">Grade:</span> <?php echo $studentInfo['grade']; ?><br />
			<span class="label">E-mail Address:</span> <?php echo $studentInfo['email']; ?>
		</div>
		<div class="one-third">
		<span class="label">Status: </span><?php echo $studentStatus; ?>
		</div>
		
		<br style="width: 100%; clear: both;" />
		<br style="width: 100%; clear: both;" />
		<!--<a href="" class="showDetails small_button">Hide Details</a>-->
		<h3 style="text-align: center;"><?php echo $studentInfo['first_name']; ?>'s Enrollment Summary</h3>
		<br />
	<?php
	if(isset($studentInfo['programs'])){
		foreach($studentInfo['programs'] as $program){
			?>
			<div class="bigItem">
				<span class="title"><?php echo $program['name']; ?></span>
				<div class="itemDetails" style="display: block;">
					<br />
					<table class="dataTable">
						<tr class="header"><td>Course Name</td><td>Period</td><td>Teacher</td><td>Tuition</td><td>Registration</td></tr>
						<?php 
						$i = 1;
						if($program['courses']){
							foreach($program['courses'] as $course){
								echo "<tr><td>".$i.". ".$course['name']."</td><td>".$tsm->intToDay($course['day']).". ".date("g:ia",strtotime($course['start_time']))." - ".date("g:ia",strtotime($course['end_time']))."</td><td>".$course['teacher_name']."</td><td align=center>$".$course['tuition_amount']."</td><td align=center>$".$course['registration_amount']."</td></tr>";
								$i++;
							}
						} else {
							echo "<tr><td colspan=5 align=center>This student is not in any courses for ".$program['name'].".</td></tr>";
						}
						?>
					</table>
					<br />
					<hr class="divider" />
					<h3>Program Fee Summary</h3>
					<div class="half">
						<span class="label">Registration Fees:</span> $<?php echo $program['registration_total']; ?><br />
					</div>
					<div class="half">
						<span class="label">Program Tuition:</span> $<?php echo $program['tuition_total']; ?><br />
						<span class="label">Yearly Tuition:</span> $<?php echo $program['tuition_total']; ?><br />
					</div>
					
				</div>
			</div>
			<?php
		}
	}
	?>
	<br style="width: 100%; clear: both;" />
	<h3 style="text-align: center;"><?php echo $studentInfo['first_name']; ?>'s Billing Summary</h3>
	<div style="width: 325px; margin-left: auto; margin-right: auto;">
		<span class="label" style="width: 200px;">Registration Total:</span> $<?php echo $studentInfo['registrationTotal']; ?><br />
		<span class="label" style="width: 200px;">Tuition Total:</span> $<?php echo $studentInfo['tuitionTotal']; ?><br />
		<span class="label" style="width: 200px;">Student Total:</span> $<?php echo $studentInfo['studentTotal']; ?>
	</div>
	</div>
<?php } ?>
<br />
<a href="index.php?com=registration&choosePaymentPlan=1" class="submitButton" style="margin-right: 20px;float: right; text-decoration: none;">Finalize Registration</a><a href="index.php?com=registration&addAnotherStudent=1" class="submitButton" style="margin-right: 20px;float: right; text-decoration: none;">Add Another Student</a>
  <br style="width: 100%; clear: both;" />
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