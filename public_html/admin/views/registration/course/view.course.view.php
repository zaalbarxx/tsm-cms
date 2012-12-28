<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
<h1><?php echo $pageTitle; ?> - <a href="index.php?com=registration&view=courses&action=addEditCourse&course_id=<?php echo $courseInfo['course_id']; ?>" class="editButton" title="Edit Course"></a></h2>
  <div class="courseDescription">
  <h3>Description:</h3>
  <?php echo html_entity_decode($courseInfo['description']); ?>
  <h2></h2>
  </div>
  <div class="availablePeriods">
  	<h3>Available Periods - <a href="index.php?com=registration&view=courses&action=addPeriod&course_id=<?php echo $course_id; ?>" class="addButton24 fb" style="bottom:-5px" title="Add a Period"></a></h3> 
  	<?php if(isset($coursePeriods)){
  		foreach($coursePeriods as $period){
  		?>
  		<div class="smallItem">
  		<span class="title"><?php echo $tsm->intToDay($period['day']).". ".date("g:ia",strtotime($period['start_time']))." - ".date("g:ia",strtotime($period['end_time'])); ?>: <?php echo $period['first_name']." ".$period['last_name']; ?></span>
				<span class="buttons"><a href="#" class="deleteButton deletePeriod" title="Delete Period" ref="<?php echo $period['period_id']; ?>"></a></span>
			</div>
  		<?php
  		}
  	}?>
  </div>
  <div class="courseRequirements">
  <h3>Enrollment Requirements - <a href="index.php?com=registration&view=courses&action=addRequirement&course_id=<?php echo $course_id; ?>" class="addButton24 fb" style="bottom:-5px" title="Add a Requirement"></a></h3>
  <?php
  if(isset($courseRequirements)){
  	foreach($courseRequirements as $requirement){
  		?>
  		<div class="smallItem">
				<span class="title"><?php echo $requirement['name']; ?></span>
				<span class="buttons"><a href="#" class="deleteButton deleteRequirement" title="Delete Requirement" ref="<?php echo $requirement['course_requirement_id']; ?>"></a></span>
			</div>
  		<?php
  	}
  }
  ?>
  </div>
  <div class="courseFees">
  <h3>Applicable Fees - <a href="index.php?com=registration&view=courses&action=addFee&course_id=<?php echo $course_id; ?>" class="addButton24 fb" style="bottom:-5px" title="Add a Fee"></a></h3>
  
  <?php if(isset($courseFees)) { 
  	foreach($courseFees as $fee){ ?>
			<div class="bigItem">
				<span class="title"><?php echo $fee['name']; ?> - $<?php echo $fee['amount']; ?></span>
				<span class="buttons"><a href="index.php?com=registration&view=courses&action=deleteCourseFee&courseId=<?php echo $fee['fee_id']; ?>" class="deleteButton" title="Delete Fee"></a></span>
				<div class="itemDetails">
				<b><span class="tooltip" title="This fee is applied only if applicant matches the condition(s) below.">Conditions:</span></b> - <a href="index.php?com=registration&view=courses&action=addCondition&course_id=<?php echo $course_id; ?>&fee_id=<?php echo $fee['fee_id'] ?>" class="fb">Add</a>
				<br />
				<?php 
				if($fee['conditions']){
					$i = 1;
					foreach($fee['conditions'] as $condition){
						echo "<span id=\"condition_".$condition['course_fee_condition_id']."\">".$i.". ".$condition['name']." - <a href=\"\" class=\"deleteCondition\" ref=\"".$condition['course_fee_condition_id']."\" title=\"Delete this condition.\">Delete</a></span><br />";
						$i++;
					}
				}
				?>
				</div>
			</div>  
    <?php }
  	} ?>
  </div>
  
</div>
<script type="text/javascript">
$(".deleteCondition").click( function(){
  $("#condition_" + $(this).attr('ref')).remove();
  $.get("index.php?com=registration&ajax=deleteFeeConditionFromCourse&course_id=<?php echo $course_id; ?>&course_fee_condition_id=" + $(this).attr('ref'), function(data){
    if(data == "1"){
      alert("Condition successfully deleted.");
      $("#condition_" + $(this).attr('ref')).remove();
    } else {
      alert("There was a problem deleting this condition.");
    }
  });
  return false;
});
$(".deleteRequirement").click( function(){
	var requirementDiv = $(this).parent().parent();
  $.get("index.php?com=registration&ajax=deleteRequirementFromCourse&course_id=<?php echo $course_id; ?>&course_requirement_id=" + $(this).attr('ref'), function(data){
    if(data == "1"){
      alert("Requirement successfully deleted.");
      requirementDiv.remove();
    } else {
      alert("There was a problem deleting this requirement.");
    }
  });

  return false;
});
$(".bigItem .title").click( function(){
  $(this).parent().children(".itemDetails").slideToggle();
});
</script>