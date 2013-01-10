<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title><?php echo $tsm->website->getTitle(); ?></title>
  <?php echo $tsm->getHeaderHTML(); ?>
</head>
<body>
<div id="headerWrapper"></div>
<div id="topMenuWrapper">
    <div id="topMenu">
      <?php
      if ($reg->family->isLoggedIn()) {

        $tsm->website->generateMenuHTML(Array(1 => Array('title' => 'Home', 'url' => 'index.php', 'target' => '_self', 'children' => null)));
        ?>
          <a class="logoutButton" href="index.php?logout=1">Logout</a>
        <?php
      }
      ?>
    </div>
</div>
<div id="contentWrapper">
    <div id="contentArea">