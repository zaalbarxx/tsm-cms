<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
<h1><?php echo $pageTitle; ?> - <a href="index.php?com=registration&view=programs&action=addEditProgram&program_id=<?php echo $programInfo['program_id']; ?>" class="editButton" title="Edit Program"></a></h2>
  <div class="programDescription">
  <h3>Description:</h3>
  <?php echo html_entity_decode($programInfo['description']); ?>
  <h2></h2>
  </div>
  <div class="programRequirements">
  <h3>Enrollment Requirements - <a href="index.php?com=registration&view=programs&action=addRequirement&program_id=<?php echo $program_id; ?>" class="addButton24 fb" style="bottom:-5px" title="Add a Requirement"></a></h3>
  <?php
  if(isset($programRequirements)){
  	foreach($programRequirements as $requirement){
  		?>
  		<div class="smallItem">
				<span class="title"><?php echo $requirement['name']; ?></span>
				<span class="buttons"><a href="index.php?com=registration&view=programs&action=deleteRequirement&program_requirement_id=<?php echo $requirement['program_requirement_id']; ?>" class="deleteButton" title="Delete Requirement"></a></span>
			</div>
  		<?php
  	}
  }
  ?>
  </div>
  <div class="programFees">
  <h3>Applicable Fees - <a href="index.php?com=registration&view=programs&action=addFee&program_id=<?php echo $program_id; ?>" class="addButton24 fb" style="bottom:-5px" title="Add a Fee"></a></h3>
  
  <?php if(isset($programFees)) { 
  	foreach($programFees as $fee){ ?>
			<div class="bigItem">
				<span class="title"><?php echo $fee['name']; ?> - $<?php echo $fee['amount']; ?></span>
				<span class="buttons"><a href="index.php?com=registration&view=programs&action=deleteProgram&programId=<?php echo $fee['fee_id']; ?>" class="deleteButton" title="Delete Fee"></a></span>
				<div class="itemDetails">
				<b>Conditions</b> - <a href="index.php?com=registration&view=programs&action=addCondition&program_id=<?php echo $program_id; ?>&fee_id=<?php echo $fee['fee_id'] ?>" class="fb">Add</a>
				<br />This fee is applied only if applicant matches the condition(s) below.<br /><br />
				<?php 
				if($fee['conditions']){
					$i = 1;
					foreach($fee['conditions'] as $condition){
						echo "<span id=\"condition_".$condition['program_fee_condition_id']."\">".$i.". ".$condition['name']." - <a href=\"\" class=\"deleteCondition\" ref=\"".$condition['program_fee_condition_id']."\" title=\"Delete this condition.\">Delete</a></span>";
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
  $.get("index.php?com=registration&ajax=deleteFeeConditionFromProgram&program_id=<?php echo $program_id; ?>&program_fee_condition_id=" + $(this).attr('ref'), function(data){
    if(data == "1"){
      alert("Condition successfully deleted.");
      $("#condition_" + $(this).attr('ref')).remove();
    } else {
      alert("There was a problem deleting this condition.");
    }
  });
  return false;
});
$(".bigItem .title").click( function(){
  $(this).parent().children(".itemDetails").slideToggle();
});
</script>