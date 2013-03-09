<!DOCTYPE html>
<html>
<head>
    <title><?php echo $tsm->website->getTitle(); ?></title>
  <?php echo $tsm->getAdminHeaderHTML(); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.dropdown-toggle').dropdown();
        });
    </script>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top" id="topMenuWrapper">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand">Artios Registration</a>
          <?php
          if ($tsm->adminUser->isLoggedIn()) {
            $tsm->website->generateMenuHTML($tsm->website->getAdminTopMenu());
            ?>
              <a class="btn pull-right" href="index.php?logout=1">Logout</a>
            <?php
          }
          ?>
        </div>
    </div>
</div>
<div class="container" id="mainBodyWrapper" style="margin-top: 60px;">
    <div class="row">