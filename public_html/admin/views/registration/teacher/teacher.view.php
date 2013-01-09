<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<style>
.smallItem .title{
	cursor: pointer;
}
</style>
<div class="contentWithSideBar">
  <h1>Teachers</h2>
  <?php 
  foreach($teachers as $teacher){
  	?>
		<div class="smallItem">
			<a class="title" href="index.php?com=registration&view=student&action=viewTeacher&teacher_id=<?php echo $teacher['teacher_id']; ?>"><?php echo $teacher['last_name'].", ".$teacher['first_name']; ?></a>
			<span class="buttons"><a href="index.php?com=registration&view=student&action=viewTeacher&teacher_id=<?php echo $teacher['teacher_id']; ?>" class="reviewButton" title="Review This Teacher"></a></span>
			<div class="itemDetails">
			</div>
		</div>
  	<?php
  }
  ?>
</div>