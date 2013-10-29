<?php
date_default_timezone_set("America/Denver");

function getRootPath() {
  $file = __FILE__;
  $file = str_replace("\\", "/", $file);
  $break = Explode('/', $file);
  $fileName = $break[count($break) - 1];
  $file = str_replace($fileName, "", $file);

  return $file;
}

function getAdminPath() {
  $file = __FILE__;
  $file = str_replace("\\", "/", $file);
  $break = Explode('/', $file);
  $fileName = $break[count($break) - 1];
  $file = str_replace($fileName, "", $file);
  $file = $file."admin/";

  return $file;
}

define("__TSM_ROOT__", getRootPath());
define("__TSM_ADMIN_ROOT__", getAdminPath());

//define("__TSM_ROOT__", "/Users/jeremymlane/Development/Veritas/Veritas/tsm-cms/project_root/public_html/");
//define("__TSM_ADMIN_ROOT__", "/Users/jeremymlane/Development/Veritas/Veritas/tsm-cms/project_root/public_html/admin/");
?>