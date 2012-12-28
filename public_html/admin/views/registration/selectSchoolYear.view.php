<h1>Select a School Year</h1>
<form action="" method="post" id="selectSchoolYearForm">
<select name="setSelectedSchoolYear" id="selectSchoolYear">
  <option value="">Choose a School Year</option>
  <?php for($i=date('Y');$i<date('Y') + 5; $i++){
  	echo "<option value='$i'>$i</option>";
  } ?>
</select>
</form>
<script type="text/javascript">
  $("#selectSchoolYearForm").change( function(){
    $("#selectSchoolYearForm").submit();
  });
</script>