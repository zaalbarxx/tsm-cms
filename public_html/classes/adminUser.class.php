<?php

class AdminUser {

  private $isLoggedIn;

  public function __construct() {
    global $logout;

    $tsm = TSM::getInstance();
    $this->tsm = $tsm;
    $this->db = $tsm->db;

    if ($logout == 1) {
      session_destroy();
      header("Location: index.php");
    }
  }

  public function isLoggedIn() {
    if (isset($_SESSION['adminUser']['id'])) {
      $this->isLoggedIn = true;
    } else {
      $this->isLoggedIn = false;
    }

    return $this->isLoggedIn;
  }

  public function login($username, $password) {
    $q = "SELECT * FROM tsm_admin_users WHERE username = '$username' AND website_id = '".$_SESSION['website_id']."'";
    $r = $this->db->runQuery($q);
    if (mysql_num_rows($r) > 0) {
      $a = mysql_fetch_assoc($r);
      if (TSM::getInstance()->checkPassword($a['password'], $password)) {
        $_SESSION['adminUser']['id'] = $a['user_id'];
        $defaultModule = $this->tsm->website->getDefaultAdminModuleId();
        if($defaultModule == 0){
          header("location: index.php?mod=welcome");
        } else {
          $moduleInfo = $this->tsm->getModuleById($defaultModule);
          header("location: index.php?mod=".$moduleInfo['module_name']);
        }
        $success = 1;
      } else {
        $success = 0;
      }
    } else {
      $success = 0;
    }

    return $success;
  }

}

?>