<?php
if (isset($fee_condition_id)) {
  $condition = $currentCampus->getFeeCondition($fee_condition_id);
} else {
  $condition = null;
}
switch ($fee_condition_type_id) {
  case "1":
    ?>
  <label for="config_1">Age is: </label><select name="config_1">
      <option value="">Condition</option>
      <option value="-1" <?php if ($condition['config_1'] == "-1") {
        echo "selected=selected";
      } ?>>Less Than
      </option>
      <option value="1" <?php if ($condition['config_1'] == "1") {
        echo "selected=selected";
      } ?>>Greater Than
      </option>
  </select>
  <select name="config_2">
    <?php
    for ($i = 1; $i <= 30; $i++) {
      if ($condition['config_2'] == $i) {
        $selected = "selected=selected";
      } else {
        $selected = "";
      }
      echo "<option value=\"$i\" $selected>$i</option>";
    }
    ?>
  </select>
  <?php
    break;
  case "2":
    ?>
  <label for="config_1">Grade is: </label><select name="config_1">
      <option value="">Condition</option>
      <option value="-1" <?php if ($condition['config_1'] == "-1") {
        echo "selected=selected";
      } ?>>Less Than
      </option>
      <option value="1" <?php if ($condition['config_1'] == "1") {
        echo "selected=selected";
      } ?>>Greater Than
      </option>
  </select>
  <select name="config_2">
    <?php
    for ($i = 1; $i <= 14; $i++) {
      if ($condition['config_2'] == $i) {
        $selected = "selected=selected";
      } else {
        $selected = "";
      }
      if ($i == 13) {
        $name = "Kindergarten";
      } elseif ($i == 14) {
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
  case "3":
    ?>
  <label for="config_1">Registers Between: </label>
  <select name="config_1">
    <?php
    for ($i = 1; $i <= 12; $i++) {
      if ($condition['config_1'] == $i) {
        $selected = "selected=selected";
      } else {
        $selected = "";
      }
      $name = $tsm->intToMonth($i);
      echo "<option value=\"$i\" $selected>$name</option>";
    }
    ?>
  </select>/
  <select name="config_2">
    <?php
    for ($i = 1; $i <= 31; $i++) {
      if ($condition['config_2'] == $i) {
        $selected = "selected=selected";
      } else {
        $selected = "";
      }
      $name = $i;
      echo "<option value=\"$i\" $selected>$name</option>";
    }
    ?>
  </select>/
  <select name="config_3">
    <?php
    for ($i = date('Y') - 5; $i <= date('Y') + 5; $i++) {
      if ($condition['config_3'] == $i) {
        $selected = "selected=selected";
      } elseif ($i == date('Y')) {
        $selected = "selected=selected";
      } else {
        $selected = "";
      }
      $name = $i;
      echo "<option value=\"$i\" $selected>$name</option>";
    }
    ?>
  </select> and
  <select name="config_4">
    <?php
    for ($i = 1; $i <= 12; $i++) {
      if ($condition['config_4'] == $i) {
        $selected = "selected=selected";
      } else {
        $selected = "";
      }
      $name = $tsm->intToMonth($i);
      echo "<option value=\"$i\" $selected>$name</option>";
    }
    ?>
  </select>/
  <select name="config_5">
    <?php
    for ($i = 1; $i <= 31; $i++) {
      if ($condition['config_5'] == $i) {
        $selected = "selected=selected";
      } else {
        $selected = "";
      }
      $name = $i;
      echo "<option value=\"$i\" $selected>$name</option>";
    }
    ?>
  </select>/
  <select name="config_6">
    <?php
    for ($i = date('Y') - 5; $i <= date('Y') + 5; $i++) {
      if ($condition['config_6'] == $i) {
        $selected = "selected=selected";
      } elseif ($i == date('Y')) {
        $selected = "selected=selected";
      } else {
        $selected = "";
      }
      $name = $i;
      echo "<option value=\"$i\" $selected>$name</option>";
    }
    ?>
  </select>
  <?php
    break;
  case "4":
    ?>
  <label for="config_1">Enrolled in: </label><select name="config_1">
      <option value="">#</option>
    <?php for ($i = 0; $i < 41; $i++) { ?>
      <option value="<?php echo $i; ?>" <?php if ($condition['config_1'] == $i) {
        echo "selected=selected";
      } ?>><?php echo $i; ?></option>
    <?php } ?>
  </select><b> classes assigned to the </b>
  <select name="config_2">
    <?php
    $programList = $currentCampus->getPrograms();
    foreach ($programList as $program) {
      echo "<option value=\"".$program['program_id']."\" $selected>".$program['name']."</option>";
    }
    ?>
  </select> <b>program.</b>
  <?php
    break;
  case "5":
    ?>
  <label for="config_1">Enrolled In: </label><select name="config_1">
    <?php
    $programList = $currentCampus->getPrograms();
    foreach ($programList as $program) {
      echo "<option value=\"".$program['program_id']."\" $selected>".$program['name']."</option>";
    }
    ?>
  </select>
  <?php
    break;
  case "6":
    ?>
  <label for="config_1">Not Enrolled In: </label><select name="config_1">
    <?php
    $programList = $currentCampus->getPrograms();
    foreach ($programList as $program) {
      echo "<option value=\"".$program['program_id']."\" $selected>".$program['name']."</option>";
    }
    ?>
  </select>
  <?php
    break;
  case "7":
    ?>
  <label for="config_1">Not Enrolled In: </label><select name="config_1">
    <?php
    $programList = $currentCampus->getPrograms();
    foreach ($programList as $program) {
      echo "<option value=\"".$program['program_id']."\" $selected>".$program['name']."</option>";
    }
    ?>
  </select>
  <?php
    break;
  case "8":
    ?>
  <label for="config_1">Not Enrolled In: </label><select name="config_1">
    <?php
    $programList = $currentCampus->getPrograms();
    foreach ($programList as $program) {
      echo "<option value=\"".$program['program_id']."\" $selected>".$program['name']."</option>";
    }
    ?>
  </select>
  <?php
    break;
  case "9":
    ?>
  <label for="config_1">Student # is: </label><select name="config_1">
      <option value="">Condition</option>
      <option value="-1" <?php if ($condition['config_1'] == "-1") {
        echo "selected=selected";
      } ?>>Less Than
      </option>
      <option value="0" <?php if ($condition['config_1'] == "0") {
        echo "selected=selected";
      } ?>>Equal To
      </option>
      <option value="1" <?php if ($condition['config_1'] == "1") {
        echo "selected=selected";
      } ?>>Greater Than
      </option>
  </select>
  <select name="config_2">
    <?php
    for ($i = 1; $i < 11; $i++) {
      if ($i == $condition['config_2']) {
        $selected = "selected=selected";
      } else {
        $selected = "";
      }
      echo "<option value=\"".$i."\" $selected>".$i."</option>";
    }
    ?>
  </select>
  <?php
    break;
}
die();
?>