<h1>Select a Campus</h1>
<form action="" method="post" id="selectCampusForm">
<select name="setCurrentCampusId" id="selectCampusId">
  <option value="">Choose a Campus</option>
<?php
if($campusList != NULL){
  foreach($campusList as $array){
    echo "  <option value='".$array['campus_id']."'>".$array['name']."</option>\n";
  }
} else {

}
?>
</select>
</form>
<script type="text/javascript">
  $("#selectCampusId").change( function(){
    $("#selectCampusForm").submit();
  });
</script>