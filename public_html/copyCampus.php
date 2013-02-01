<?php
ini_set('max_execution_time', 0);
//REQUIRE THE CONFIG FILE
require_once('tsm_config.php');
//REQUIRE THE CORE CLASSES
require_once(__TSM_ROOT__.'tsm_core.php');
//INSTANTIATE THE TSM CLASS
$tsm = TSM::getInstance();
//START SAFE GLOBAL VARIABLES
extract($tsm->makeArraySafe($_REQUEST), EXTR_OVERWRITE);
//INSTANTIATE THE DB CONNECTION
require_once(__TSM_ROOT__.'tsm_db_conn.php');

if (isset($from_campus) && isset($to_campus)) {
  $tableNames = Array(
    "tsm_reg_fees",
    "tsm_reg_fee_types",
    "tsm_reg_fee_conditions",
    "tsm_reg_fee_payment_plans",
    "tsm_reg_programs",
    "tsm_reg_program_requirements",
    "tsm_reg_program_fee",
    "tsm_reg_program_fee_condition",
    "tsm_reg_courses",
    "tsm_reg_course_program",
    "tsm_reg_course_fee",
    "tsm_reg_course_fee_condition",
    "tsm_reg_course_requirements",
    "tsm_reg_requirements",
    "tsm_reg_shirt_sizes"
  );

  foreach ($tableNames as $table) {
    $sql = "SELECT * FROM $table LIMIT 1";
    $res = mysql_query($sql) or die(mysql_error());
    $col_names = "";
    $select_col_names = "";
    for ($i = 0; $i < mysql_num_fields($res); $i++) {
      if ($i > 0 && (($i + 1) != mysql_num_fields($res))) {
        if (mysql_field_name($res, $i) == "campus_id") {
          $select_col_names .= "'$to_campus', ";
        } else {
          $select_col_names .= $table.".".mysql_field_name($res, $i).", ";
        }

        $col_names .= mysql_field_name($res, $i).", ";

      } elseif (($i + 1) != mysql_num_fields($res)) {
        $old_col = "old_".mysql_field_name($res, $i);
        $col_names .= "old_".mysql_field_name($res, $i).", ";
        $select_col_names .= $table.".".mysql_field_name($res, $i).", ";
      }

    }
    $clearSql[] = "UPDATE $table SET $old_col = '0'";
    $col_names = substr($col_names, 0, -2);
    $select_col_names = substr($select_col_names, 0, -2);

    $sql = "INSERT INTO $table (".$col_names.") SELECT ".$select_col_names." FROM $table ";

    if ($table == "tsm_reg_program_requirements" or $table == "tsm_reg_program_fee" or $table == "tsm_reg_program_fee_condition") {
      $sql .= ", tsm_reg_programs ";
    } elseif ($table == "tsm_reg_course_requirements" or $table == "tsm_reg_course_fee" or $table == "tsm_reg_course_fee_condition" or $table == "tsm_reg_course_program") {
      $sql .= ", tsm_reg_courses ";
    }


    if ($table == "tsm_reg_program_requirements" or $table == "tsm_reg_program_fee" or $table == "tsm_reg_program_fee_condition") {
      $sql .= " WHERE tsm_reg_programs.program_id = $table.program_id AND tsm_reg_programs.campus_id = '$from_campus'";
    } elseif ($table == "tsm_reg_course_requirements" or $table == "tsm_reg_course_fee" or $table == "tsm_reg_course_fee_condition" or $table == "tsm_reg_course_program") {
      $sql .= " WHERE tsm_reg_courses.course_id = $table.course_id AND tsm_reg_courses.campus_id = '$from_campus'";
    } else {
      $sql .= " WHERE campus_id = '".$from_campus."'";
    }
    if (isset($runSql)) {
      mysql_query($sql) or die(mysql_error());
    }
    echo $sql.";<br /><br />";
  }


  //COURSE FEE UPDATES
  //echo "update tsm_reg_course_fee<br />";
  $sql = "UPDATE tsm_reg_course_fee dest, (SELECT program_id, old_program_id, campus_id FROM tsm_reg_programs WHERE campus_id = '$to_campus') src
  SET dest.program_id = src.program_id WHERE src.old_program_id = dest.program_id AND dest.program_id IS NOT NULL AND dest.old_course_fee_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br />";
  $sql = "UPDATE tsm_reg_course_fee dest, (SELECT course_id, old_course_id, campus_id FROM tsm_reg_courses WHERE campus_id = '$to_campus') src
  SET dest.course_id = src.course_id WHERE src.old_course_id = dest.course_id AND dest.course_id IS NOT NULL AND dest.old_course_fee_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br />";
  $sql = "UPDATE tsm_reg_course_fee dest, (SELECT fee_id, old_fee_id, campus_id FROM tsm_reg_fees WHERE campus_id = '$to_campus') src
  SET dest.fee_id = src.fee_id WHERE src.old_fee_id = dest.fee_id AND dest.fee_id IS NOT NULL AND dest.old_course_fee_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br /><br />";

  //COURSE FEE CONDITION UPDATES
  //echo "update tsm_reg_course_fee_condition<br />";
  $sql = "UPDATE tsm_reg_course_fee_condition dest, (SELECT program_id, old_program_id, campus_id FROM tsm_reg_programs WHERE campus_id = '$to_campus') src
  SET dest.program_id = src.program_id WHERE src.old_program_id = dest.program_id AND dest.program_id IS NOT NULL
  AND dest.old_course_fee_condition_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br />";
  $sql = "UPDATE tsm_reg_course_fee_condition dest, (SELECT course_id, old_course_id, campus_id FROM tsm_reg_courses WHERE campus_id = '$to_campus') src
  SET dest.course_id = src.course_id WHERE src.old_course_id = dest.course_id AND dest.course_id IS NOT NULL
  AND dest.old_course_fee_condition_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br />";
  $sql = "UPDATE tsm_reg_course_fee_condition dest, (SELECT fee_id, old_fee_id, campus_id FROM tsm_reg_fees WHERE campus_id = '$to_campus') src
  SET dest.fee_id = src.fee_id WHERE src.old_fee_id = dest.fee_id AND dest.fee_id IS NOT NULL
  AND dest.old_course_fee_condition_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br />";
  $sql = "UPDATE tsm_reg_course_fee_condition dest, (SELECT fee_condition_id, old_fee_condition_id, campus_id FROM tsm_reg_fee_conditions WHERE campus_id = '$to_campus') src
  SET dest.fee_condition_id = src.fee_condition_id WHERE src.old_fee_condition_id = dest.fee_condition_id AND dest.fee_condition_id IS NOT NULL
  AND dest.old_course_fee_condition_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br /><br />";

  //COURSE PROGRAM UPDATES
  // echo "update tsm_reg_course_program<br />";
  $sql = "UPDATE tsm_reg_course_program dest, (SELECT program_id, old_program_id, campus_id FROM tsm_reg_programs WHERE campus_id = '$to_campus') src
  SET dest.program_id = src.program_id WHERE src.old_program_id = dest.program_id AND dest.program_id IS NOT NULL
  AND dest.old_course_program_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br />";
  $sql = "UPDATE tsm_reg_course_program dest, (SELECT course_id, old_course_id, campus_id FROM tsm_reg_courses WHERE campus_id = '$to_campus') src
  SET dest.course_id = src.course_id WHERE src.old_course_id = dest.course_id AND dest.course_id IS NOT NULL
  AND dest.old_course_program_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br /><br />";

  //COURSE REQUIREMENT UPDATES
  //echo "update tsm_reg_course_requirements<br />";
  $sql = "UPDATE tsm_reg_course_requirements dest, (SELECT program_id, old_program_id, campus_id FROM tsm_reg_programs WHERE campus_id = '$to_campus') src
  SET dest.program_id = src.program_id WHERE src.old_program_id = dest.program_id AND dest.program_id IS NOT NULL
  AND dest.old_course_requirement_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br />";
  $sql = "UPDATE tsm_reg_course_requirements dest, (SELECT course_id, old_course_id, campus_id FROM tsm_reg_courses WHERE campus_id = '$to_campus') src
  SET dest.course_id = src.course_id WHERE src.old_course_id = dest.course_id AND dest.course_id IS NOT NULL
  AND dest.old_course_requirement_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br />";
  $sql = "UPDATE tsm_reg_course_requirements dest, (SELECT requirement_id, old_requirement_id, campus_id FROM tsm_reg_requirements WHERE campus_id = '$to_campus') src
  SET dest.requirement_id = src.requirement_id WHERE src.old_requirement_id = dest.requirement_id AND dest.requirement_id IS NOT NULL
  AND dest.old_course_requirement_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br /><br />";

  //PROGRAM FEE UPDATES
  //echo "update tsm_reg_program_fee<br />";
  $sql = "UPDATE tsm_reg_program_fee dest, (SELECT program_id, old_program_id, campus_id FROM tsm_reg_programs WHERE campus_id = '$to_campus') src
  SET dest.program_id = src.program_id WHERE src.old_program_id = dest.program_id AND dest.program_id IS NOT NULL AND dest.old_program_fee_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br />";
  $sql = "UPDATE tsm_reg_program_fee dest, (SELECT fee_id, old_fee_id, campus_id FROM tsm_reg_fees WHERE campus_id = '$to_campus') src
  SET dest.fee_id = src.fee_id WHERE src.old_fee_id = dest.fee_id AND dest.fee_id IS NOT NULL AND dest.old_program_fee_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br /><br />";

  //PROGRAM FEE CONDITION UPDATES
  //echo "update tsm_reg_program_fee_condition<br />";
  $sql = "UPDATE tsm_reg_program_fee_condition dest, (SELECT program_id, old_program_id, campus_id FROM tsm_reg_programs WHERE campus_id = '$to_campus') src
  SET dest.program_id = src.program_id WHERE src.old_program_id = dest.program_id AND dest.program_id IS NOT NULL AND dest.old_program_fee_condition_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br />";
  $sql = "UPDATE tsm_reg_program_fee_condition dest, (SELECT fee_id, old_fee_id, campus_id FROM tsm_reg_fees WHERE campus_id = '$to_campus') src
  SET dest.fee_id = src.fee_id WHERE src.old_fee_id = dest.fee_id AND dest.fee_id IS NOT NULL AND dest.old_program_fee_condition_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br />";
  $sql = "UPDATE tsm_reg_program_fee_condition dest, (SELECT fee_condition_id, old_fee_condition_id, campus_id FROM tsm_reg_fee_conditions WHERE campus_id = '$to_campus') src
  SET dest.fee_condition_id = src.fee_condition_id WHERE src.old_fee_condition_id = dest.fee_condition_id AND dest.fee_condition_id IS NOT NULL AND dest.old_program_fee_condition_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br /><br />";

  //PROGRAM REQUIREMENT UPDATES
  //echo "update tsm_reg_program_requirements<br />";
  $sql = "UPDATE tsm_reg_program_requirements dest, (SELECT program_id, old_program_id, campus_id FROM tsm_reg_programs WHERE campus_id = '$to_campus') src
  SET dest.program_id = src.program_id WHERE src.old_program_id = dest.program_id AND dest.program_id IS NOT NULL
  AND dest.old_program_requirement_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br />";
  $sql = "UPDATE tsm_reg_program_requirements dest, (SELECT requirement_id, old_requirement_id, campus_id FROM tsm_reg_requirements WHERE campus_id = '$to_campus') src
  SET dest.requirement_id = src.requirement_id WHERE src.old_requirement_id = dest.requirement_id AND dest.requirement_id IS NOT NULL
  AND dest.old_program_requirement_id != 0;";
  if (isset($runSql)) {
    mysql_query($sql) or die(mysql_error());
  }
  echo $sql."<br /><br />";

  foreach ($clearSql as $sql) {
    if (isset($runSql)) {
      mysql_query($sql) or die(mysql_error());
    }
    echo $sql.";<br />";
  }

} else {
  echo "There was an error";
}

?>