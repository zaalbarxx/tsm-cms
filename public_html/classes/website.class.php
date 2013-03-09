<?php
class Website {

  private $info;
  private $templateId;
  private $title;
  public $adminPortal;
  private $adminTopMenu;
  private $adminSideMenu;
  private $websiteId;


  public function __construct() {
    $tsm = TSM::getInstance();
    $this->db = $tsm->db;

    if (stristr($_SERVER['PHP_SELF'], "/admin/") == true) {
      $this->adminPortal = true;
    } else {
      $this->adminPortal = false;
    }

  }

  public function start() {
    //print_r(TSM::db);
    if (!isset($this->info)) {
      if (!isset($_SESSION['website_id'])) {
        $q = "SELECT * FROM tsm_websites WHERE primary_url LIKE '%".$_SERVER['SERVER_NAME']."%'";
      } else {
        $q = "SELECT * FROM tsm_websites WHERE website_id = '".$_SESSION['website_id']."'";
      }

      $r = $this->db->runQuery($q);
      if (mysql_num_rows($r) == 1) {
        while ($a = mysql_fetch_assoc($r)) {
          $this->templateId = $a['template_id'];
          $this->title = $a['title'];
          $this->info = $a;
        }
      } else {
        die("invalid website");
      }
    }

    if (isset($this->info['website_id'])) {
      $_SESSION['website_id'] = $this->info['website_id'];
    }

    return $this->info;
  }

  public function getTitle() {
    return $this->title;
  }

  public function setTitle($title) {
    $this->title = $title;

    return $this->title;
  }

  public function getWebsiteId() {
    if (isset($this->info['website_id'])) {
      $this->websiteId = $this->info['website_id'];
    }

    return $this->websiteId;
  }

  public function getTemplateId() {
    return $this->templateId;
  }

  public function getTemplateHeader() {
    if ($this->adminPortal) {
      return __TSM_ROOT__."admin/templates/admin/header.php";
    } else {
      return __TSM_ROOT__."/templates/".$this->getTemplateId()."/header.php";
    }
  }

  public function getTemplateFooter() {
    if ($this->adminPortal) {
      return __TSM_ROOT__."admin/templates/admin/footer.php";
    } else {
      return __TSM_ROOT__."/templates/".$this->getTemplateId()."/footer.php";
    }
  }

  public function getInfo() {
    return $this->info;
  }

  public function getAdminTopMenu($parentId = NULL) {
    if ($parentId != null) {
      $q = "SELECT * FROM tsm_admin_menu WHERE parent_id = ".$parentId;
    } else {
      $q = "SELECT * FROM tsm_admin_menu WHERE parent_id IS NULL";
    }

    $items = Array();
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) > 0) {
      while ($a = mysql_fetch_assoc($r)) {
        $menuArray[$a['menu_item_id']] = Array(
          "title" => $a['title'],
          "url" => $a['url'],
          "target" => $a['target'],
          "children" => $this->getAdminTopMenu($a['menu_item_id'])
        );
      }
    } else {
      $menuArray = NULL;
    }

    $this->adminTopMenu = $menuArray;

    return $this->adminTopMenu;
  }

  public function generateMenuHTML($menuArray, $isDropDown = false) {
    if ($isDropDown) {
      echo "<ul class='dropdown-menu'>";
    } else {
      echo "<ul class='nav'>";
    }

    foreach ($menuArray as $menuItem) {
      if (isset($menuItem['children'])) {
        echo "<li class='dropdown'><a class='dropdown-toggle' href='".$menuItem['url']."'>".$menuItem['title']."<b class='caret'></b></a>";
      } else {
        echo "<li><a href='".$menuItem['url']."'>".$menuItem['title']."</a>";
      }

      if (isset($menuItem['children'])) {
        $this->generateMenuHTML($menuItem['children'], true);
      }
    }
    echo "</ul>";
  }

}

?>