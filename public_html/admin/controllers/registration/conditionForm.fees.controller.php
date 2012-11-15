<?php
if(isset($fee_condition_id)){
  $condition = $currentCampus->getFeeCondition($fee_condition_id);
} else {
  $condition = null;
}
switch($fee_condition_type_id){
  case "1":
    ?>
    <label for="config_1">Age is: </label>
    <select name="config_1">
      <option value="">Condition</option>
      <option value="-1" <?php if($condition['config_1'] == "-1"){ echo "selected=selected"; } ?>>Less Than</option>
      <option value="1" <?php if($condition['config_1'] == "1"){ echo "selected=selected"; } ?>>Greater Than</option>
    </select>
    <select name="config_2">
    <?php
    for($i = 1; $i <= 30; $i++){
      if($condition['config_2'] == $i){ $selected = "selected=selected"; } else { $selected = ""; }
      echo "<option value=\"$i\" $selected>$i</option>";
    }
    ?>
    </select>
    <?php
    break;
  case "2":
    ?>
    <label for="config_1">Grade is: </label>
    <select name="config_1">
      <option value="">Condition</option>
      <option value="-1" <?php if($condition['config_1'] == "-1"){ echo "selected=selected"; } ?>>Less Than</option>
      <option value="1" <?php if($condition['config_1'] == "1"){ echo "selected=selected"; } ?>>Greater Than</option>
    </select>
    <select name="config_2">
    <?php
    for($i = 1; $i <= 14; $i++){
      if($condition['config_2'] == $i){ $selected = "selected=selected"; } else { $selected = ""; }
      if($i == 13){
        $name = "Kindergarten";
      } elseif($i == 14){
        $name = "Preschool";
      } else {
        $name = $i;
      }
      echo "<option value=\"$i\" $selected>$name</option>";
    }
    ?>
    </select>
    <?php
    break;
}
 die();
?>