<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<style>
.smallItem .title{
	cursor: pointer;
}
</style>
<div class="contentWithSideBar">
  <h1>Families</h2>
  <?php 
  foreach($families as $family){
  	?>
		<div class="smallItem">
			<span class="title"><?php echo $family['father_last']; ?> Family</span>
			<span class="buttons"><a href="index.php?com=registration&view=family&action=viewFamily&family_id=<?php echo $family['family_id']; ?>" class="reviewButton" title="Review This Family"></a></span>
			<div class="itemDetails">
			<?php 
			foreach($family['students'] as $student){
				echo $student['first_name'];
			}
			?>
			</div>
		</div>
  	<?php
  }
  ?>
</div>
<script type="text/javascript">
$(".smallItem .title").click( function(){
  $(this).parent().children(".itemDetails").slideToggle();
});
</script>