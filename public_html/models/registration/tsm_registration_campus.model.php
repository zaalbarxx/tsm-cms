<?php

class TSM_REGISTRATION_CAMPUS extends TSM_REGISTRATION{

  private $campusId;
  private $info;
  private $programs;
  private $fees;
  private $feeConditions;
  private $requirements;
  private $courses;
  private $families;
  private $students;
  private $periods;
  private $teachers;

  public function __construct($campusId = null){
		$tsm = TSM::getInstance();
		$this->tsm = $tsm;
		$this->db = $tsm->db;
		if(isset($campusId)){
      $this->campusId = $campusId;
      $this->getInfo(); 
    }
  }
  
  public function getCampusId(){
    return $this->campusId;
  }
  
  public function getInfo(){
    $q = "SELECT * FROM tsm_reg_campuses WHERE campus_id = ".$this->campusId." ORDER BY name";
    $r = $this->db->runQuery($q);
    while($a = mysql_fetch_assoc($r)){
      $this->info = $a;
    }
    
    return $this->info;
  }
  
  public function saveCampus(){
  	if($this->db->updateRowFromPost("tsm_reg_campuses",$this->campusId)){
			return true;
		} else {
			//THERE WAS AN ERROR INSERTING THE ROW
			die("uhoh");
		} 
  }
  
  public function getName(){
  	if($this->info == null){
  		$this->getInfo();	
  	}
  	
  	return $this->info['name'];
  }
  
  public function usesQuickbooks(){
  	return $this->info['quickbooks_enabled'];
  }
  
  public function getCurrentSchoolYear(){
    if($this->info == null){
      $this->getInfo();
    }
    
    return $this->info['current_school_year'];  
  }
  
  public function familyExists($primaryEmail){
  	$q = "SELECT family_id FROM tsm_reg_families WHERE primary_email = '".$primaryEmail."' AND campus_id = '".$this->campusId."'";
		$r = $this->db->runQuery($q);
		if(mysql_num_rows($r) == 0){
			return false;
		} else {
			return true;
		}
  }
  
  public function studentExists($first_name,$birth_date){
  	$q = "SELECT student_id FROM tsm_reg_students WHERE first_name = '".$first_name."' AND birth_date = '".$birth_date."' AND campus_id = '".$this->campusId."'";
		$r = $this->db->runQuery($q);
		if(mysql_num_rows($r) == 0){
			return false;
		} else {
			return true;
		}
  }
  
  public function getPeriods(){
    $q = "SELECT * FROM tsm_reg_periods WHERE campus_id = ".$this->campusId." AND school_year = '".$this->getSelectedSchoolYear()."' ORDER BY day, start_time";
    $r = $this->db->runQuery($q);
    $this->periods = null;
    while($a = mysql_fetch_assoc($r)){
      $this->periods[$a['period_id']] = $a;
    }
    
    return $this->periods;
  }
  
  public function getTeachers(){
    $q = "SELECT * FROM tsm_reg_teachers t, tsm_reg_teachers_school_years tsy WHERE tsy.teacher_id = t.teacher_id AND t.campus_id = ".$this->campusId." AND tsy.school_year = '".$this->info['current_school_year']."' ORDER BY last_name, first_name";
    $r = $this->db->runQuery($q);
    $this->teachers = null;
    while($a = mysql_fetch_assoc($r)){
      $this->teachers[$a['teacher_id']] = $a;
    }
    
    return $this->teachers;
  }
  
  public function getPrograms(){
    $q = "SELECT * FROM tsm_reg_programs WHERE campus_id = ".$this->campusId." AND school_year = '".$this->getSelectedSchoolYear()."' ORDER BY name";
    $r = $this->db->runQuery($q);
    $this->programs = null;
    while($a = mysql_fetch_assoc($r)){
      $this->programs[$a['program_id']] = $a;
    }
    
    return $this->programs;
  }
  
  public function getCourses(){
    $q = "SELECT * FROM tsm_reg_courses WHERE campus_id = ".$this->campusId." AND school_year = '".$this->getSelectedSchoolYear()."' ORDER BY name";
    $r = $this->db->runQuery($q);
    $this->courses = null;
    while($a = mysql_fetch_assoc($r)){
      $this->courses[$a['course_id']] = $a;
    }
    
    return $this->courses;
  }
  
  public function getRequirements($searchq = null){
    $q = "SELECT * FROM tsm_reg_requirements WHERE campus_id = ".$this->campusId." AND school_year = '".$this->getSelectedSchoolYear()."'";
    if($searchq != null){
      $q .= "AND name LIKE '%$searchq%'";
    }
    $q .= " ORDER BY name";
    $r = $this->db->runQuery($q);
    $this->requirements = null;
    while($a = mysql_fetch_assoc($r)){
      $this->requirements[$a['requirement_id']] = $a;
    }
    
    return $this->requirements;
  }
  
  public function getRequirement($requirement_id){
    $q = "SELECT * FROM tsm_reg_requirements WHERE campus_id = ".$this->campusId." AND requirement_id = '".$requirement_id."'";
    $r = $this->db->runQuery($q);
    $requirement = null;
    $requirement = mysql_fetch_assoc($r);
    
    return $requirement;
  }
  
  public function deleteFee($feeId = null){
  	
  	//fees cannot yet be deleted.
    return false;
  }
  
  public function getPaymentPlans($fee_type_id = null){
  	$q = "SELECT * FROM tsm_reg_fee_payment_plans WHERE campus_id = ".$this->campusId." AND school_year = '".$this->getSelectedSchoolYear()."'";
  	if(isset($fee_type_id)){
  		$q .= " AND fee_type_id = '$fee_type_id'";
  	}
  	$r = $this->db->runQuery($q);
    $this->paymentPlans = null;
    while($a = mysql_fetch_assoc($r)){
      $this->paymentPlans[$a['payment_plan_id']] = $a;
    }
  	
  	return $this->paymentPlans;
  }
  
  public function getFees($searchq = null){
    $q = "SELECT * FROM tsm_reg_fees WHERE campus_id = ".$this->campusId." AND school_year = '".$this->getSelectedSchoolYear()."'";
    if($searchq != null){
      $q .= "AND name LIKE '%$searchq%'";
    }
    $q .= " ORDER BY name";
    $r = $this->db->runQuery($q);
    $this->fees = null;
    while($a = mysql_fetch_assoc($r)){
      $this->fees[$a['fee_id']] = $a;
    }
    
    return $this->fees;
  }
  
  public function getFeeConditions(){
    $q = "SELECT * FROM tsm_reg_fee_conditions WHERE campus_id = ".$this->campusId." AND school_year = '".$this->getSelectedSchoolYear()."'";
    $q .= " ORDER BY name";
    $r = $this->db->runQuery($q);
    $this->feeConditions = null;
    while($a = mysql_fetch_assoc($r)){
      $this->feeConditions[$a['fee_condition_id']] = $a;
    }
    
    return $this->feeConditions;
  }
  
  public function getFeeCondition($fee_condition_id){
    $q = "SELECT * FROM tsm_reg_fee_conditions WHERE campus_id = ".$this->campusId." AND fee_condition_id = '".$fee_condition_id."'";
    $r = $this->db->runQuery($q);
    $condition = null;
    $condition = mysql_fetch_assoc($r);
    
    return $condition;
  }

  public function createPeriod(){
    if(isset($_POST['day']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->insertRowFromPost("tsm_reg_periods")){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
  }
  
   public function savePeriod($periodId){
    if(isset($_POST['day']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->updateRowFromPost("tsm_reg_periods",$periodId)){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
  }
  
  public function createRequirement(){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->insertRowFromPost("tsm_reg_requirements")){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
  }
  
   public function saveRequirement($requirementId){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->updateRowFromPost("tsm_reg_requirements",$requirementId)){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
  }
  
  public function createPaymentPlan(){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->insertRowFromPost("tsm_reg_fee_payment_plans")){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
  }
  
   public function savePaymentPlan($paymentPlanId){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->updateRowFromPost("tsm_reg_fee_payment_plans",$paymentPlanId)){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
  }
  
  public function createFee(){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->insertRowFromPost("tsm_reg_fees")){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
  }
  
   public function saveFee($feeId){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->updateRowFromPost("tsm_reg_fees",$feeId)){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
  }
  
  public function createFeeCondition(){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->insertRowFromPost("tsm_reg_fee_conditions")){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
  }
  
   public function saveFeeCondition($feeConditionId){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->updateRowFromPost("tsm_reg_fee_conditions",$feeConditionId)){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die(print_r($_POST));
    }
  }
  
  public function createCourse(){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->insertRowFromPost("tsm_reg_courses")){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die("not all fields required.");
    }
  }  
  
   public function saveCourse($courseId){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->updateRowFromPost("tsm_reg_courses",$courseId)){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
        die("not all fields required.");
    }
  }

  public function createProgram(){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->insertRowFromPost("tsm_reg_programs")){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
      die("not all fields required.");
    }
  }

   public function saveProgram($programId){
    if(isset($_POST['name']) && isset($_POST["website_id"]) && isset($_POST['school_year'])){
      if($this->db->updateRowFromPost("tsm_reg_programs",$programId)){
        return true;
      } else {
        //THERE WAS AN ERROR INSERTING THE ROW
        die("uhoh");
      } 
    } else {
        die("not all fields required.");
    }
  }
  
  public function getFamilies(){
    $q = "SELECT * FROM tsm_reg_families f, tsm_reg_families_school_years fsy WHERE f.campus_id = ".$this->campusId." AND fsy.family_id = f.family_id AND fsy.school_year = '".$this->getSelectedSchoolYear()."' ORDER BY f.father_last, f.mother_last";
    $r = $this->db->runQuery($q);
    $this->families = null;
    while($a = mysql_fetch_assoc($r)){
      $this->families[$a['family_id']] = $a;
    }
    
    return $this->families;
  }	

  public function getStudents(){
    $q = "SELECT * FROM tsm_reg_students s, tsm_reg_students_school_years ssy WHERE s.campus_id = ".$this->campusId." AND ssy.student_id = s.student_id AND ssy.school_year = '".$this->getSelectedSchoolYear()."' ORDER BY s.last_name";
    $r = $this->db->runQuery($q);
    $this->students = null;
    while($a = mysql_fetch_assoc($r)){
      $this->students[$a['student_id']] = $a;
    }
    
    return $this->students;
  }	

}

?>