<?php
class Website{

	private static $info;
	private static $templateId;
	private static $title;
	public static $adminPortal;
	private static $adminTopMenu;
	private static $adminSideMenu;


	public function __construct(){
		$tsm = TSM::getInstance();
		$this->db = $tsm->db;
		
	  if(stristr($_SERVER['PHP_SELF'],"/admin/") == true){
      $this->adminPortal = true;
    } else {
      $this->adminPortal = false;
    }
		
	}

	public function start(){
		//print_r(TSM::db);
		if(!isset($this->info)){
			if(!isset($_SESSION['website_id'])){
				$q = "SELECT * FROM tsm_websites WHERE primary_url LIKE '%".$_SERVER['SERVER_NAME']."%'";
			} else {
				$q = "SELECT * FROM tsm_websites WHERE website_id = '".$_SESSION['website_id']."'";
			}

			$r = $this->db->runQuery($q);
			if(mysql_num_rows($r) == 1){
				while($a = mysql_fetch_assoc($r)){
					$this->templateId = $a['template_id'];
					$this->title = $a['title'];
					$this->info = $a;
				}
			} else {
				die("invalid website");
			}
		}

		if(isset($this->info['website_id'])){
			$_SESSION['website_id'] = $this->info['website_id'];
		}

		return $this->info;
	}

	public function getTitle(){
		return $this->title;
	}
	
	public function setTitle($title){
	  $this->title = $title;
	  
		return $this->title;
	}

	public function getTemplateId(){
		return $this->templateId;
	}
	
	public function getTemplateHeader(){
	  if($this->adminPortal){
      return __TSM_ROOT__."admin/templates/admin/header.php";
    } else {
      return __TSM_ROOT__."/templates/".$this->getTemplateId()."/header.php";
    }
  }
  
	public function getTemplateFooter(){
	  if($this->adminPortal){
      return __TSM_ROOT__."admin/templates/admin/footer.php";
    } else {
      return __TSM_ROOT__."/templates/".$this->getTemplateId()."/footer.php";
    }
  }

	public function getInfo(){
		return $this->info;
	}
	
	public function getAdminTopMenu(){
	  $array = Array(
              0 => Array(
                "title"=>'Home', 
                "url"=>'index.php', 
                  ),
              1 => Array(
                "title"=>'Manage', 
                "url"=>'#', 
                "children"=>Array(
                    0=>Array(
                      "title"=>'Registration', 
                      "url"=>'index.php?com=registration'
                      ),
                    1=>Array(
                      "title"=>'Something Else',
                      "url"=>'hi.php'
                      )
                    )
                  ),
              2 => Array(
                "title"=>'Manage', 
                "url"=>'#', 
                "children"=>Array(
                    0=>Array(
                      "title"=>'Registration', 
                      "url"=>'index.php?com=registration'
                      ),
                    1=>Array(
                      "title"=>'Something Else',
                      "url"=>'hi.php'
                      )
                    )
                  ),  
                );
	  $this->adminTopMenu = $array;
	  
	  return $this->adminTopMenu;
  }
  
  public function generateMenuHTML($menuArray){
    echo "<ul>";
    foreach($menuArray as $menuItem){
      echo "<li><a href='".$menuItem['url']."'>".$menuItem['title']."</a>";
      if(isset($menuItem['children'])){
        $this->generateMenuHTML($menuItem['children']);
      }
    }
    echo "</ul>";
  }

}

?>