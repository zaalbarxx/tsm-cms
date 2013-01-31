<?php
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
?>