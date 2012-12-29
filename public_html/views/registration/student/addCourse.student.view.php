<div class="contentArea">
  <h1><?php echo $pageTitle; ?></h2>
  <?php if($eligibleCourses){ ?>
		<?php foreach($eligibleCourses as $course){ ?>
			<div class="bigItem" style="margin-left: auto; margin-right: auto;">
				<span class="title"><?php echo $course['name']; ?></span>
				<span class="buttons">
				<a href="#" class="addButton24" title="Enroll <?php echo $studentInfo['first_name']; ?> in <?php echo $course['name']; ?>"></a>
				</span>
				<div class="itemDetails" style="display: block;">
					<div class="half">
						<span class="label">Registration Fee:</span> $<?php echo $reg->addFees($student->getFeesForCourse($course['course_id'],$program_id,2)); ?>
					</div>
					<div class="half">
						<span class="label">Course Tuition:</span> $<?php echo $reg->addFees($student->getFeesForCourse($course['course_id'],$program_id,1)); ?>
					</div>
				</div>
				<div class="periods" style="display: none;">
				<h3>Select a Period</h3>
				<?php 
				if(isset($course['periods'])){
					foreach($course['periods'] as $period){ ?>
						<?php echo $tsm->intToDay($period['day']).". ".date("g:ia",strtotime($period['start_time']))." - ".date("g:ia",strtotime($period['end_time'])); ?>: <?php echo $period['first_name']." ".$period['last_name']; ?> - <a href="index.php?com=registration&action=addCourse&student_id=<?php echo $studentInfo['student_id']; ?>&program_id=<?php echo $programInfo['program_id']; ?>&enrollInCourse=<?php echo $course['course_id']; ?>&course_period_id=<?php echo $period['course_period_id']; ?>" class="addCourse" ref="<?php echo $course['name']; ?>">Choose</a><br />
					<?php }
				}?>
				</div>
			</div>  

		<?php } ?>
  <?php } else { ?>
  	<span>This student is not eligible for any courses in <?php echo $programInfo['name']; ?>.</span><br /><br />
  <?php } ?>
</div>
<script type="text/javascript">
$(document).ready( function(){
	$(".addButton24").click( function(){
			var docHeight = $(document).height();
			$("body").append("<div id='overlay'></div>");
			$("#overlay").height(docHeight);
			$(this).parent().parent().children(".periods").clone().addClass("activePeriod").prependTo("body").css({left: $(window).width() / 2 - 180}).show();
			
			return false;
	});
  $(".addCourse").live('click', function(){
  	var courseName = $(this).attr("ref");
    $.get($(this).attr('href'),function(data){
      if(data == "1"){
      	//alert("<?php echo $studentInfo['first_name']; ?> was successfully added to " + courseName + ". You can continue adding courses or select \"Add Another Program.\"");
        parent.window.location.reload();
      } else {
      	alert("There was an error enrolling <?php $studentInfo['first_name']; ?> in the course. They may already be enrolled.");
        parent.window.location.reload();
      }
    });
    
    return false;
  });
	$(document).mouseup(function (e){
			var container = $("body .activePeriod");
			if (container.has(e.target).length === 0)
			{
					container.remove();
					$("#overlay").remove();
			}
	});
});
</script>