<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <script src = "http://www.youtube.com/player_api"></script>
  <!--[if lt IE 9]>
  <script>
    document.createElement('header');
    document.createElement('nav');
    document.createElement('section');
    document.createElement('article');
    document.createElement('aside');
    document.createElement('footer');
  </script>
  <![endif]-->
  <title><?php echo $tsm->website->getTitle(); ?></title>
  <?php echo $tsm->getHeaderHTML(); ?>
</head>
<body>
<div id="mainWrapper">
<div id="navWrapper">
  <a id="navLogo" href="" ></a>
  <div id="topNav">
    <?php //$tsm->website->generateMenuHTML($tsm->website->getAdminTopMenu()); ?>
    <div id="socialButtons">
      <a href="https://www.facebook.com/reachoutworldwide" target="_blank" rel="nofollow" class="facebook"></a>
      <a href="https://twitter.com/ReachOutWW" target="_blank" rel="nofollow" class="twitter"></a>
      <a href="http://pinterest.com/reachoutww/" target="_blank" rel="nofollow" class="pinterest"></a>
      <a href="http://www.youtube.com/user/reachoutworldwide" target="_blank" rel="nofollow" class="youtube"></a>
      <a href="http://reachoutworldwide.wordpress.com/" target="_blank" rel="nofollow" class="wordpress"></a>
    </div>
    <ul>
      <li>
        <a href="<?php echo __WEBROOT__; ?>donate.php">Donate</a>
        <ul style="width: 268px;">
          <div class="arrow"></div>
          <li><a style="width: 233px;" href="<?php echo __WEBROOT__; ?>donate.php">Donate Money</a></li>
          <li><a style="width: 233px;" href="<?php echo __WEBROOT__; ?>mission_fish.php">Donate Items for Auction</a></li>
          <li><a style="width: 233px;" href="mailto:items@roww.org">Donate Items Direct</a></li>
        </ul>
      </li>
      <li>
        <a href="<?php echo __WEBROOT__; ?>relief_efforts/">Relief Efforts</a>
        <ul style="left: 120px;">
          <div class="arrow" style="left: 0px;"></div>
          <li><a href="<?php echo __WEBROOT__; ?>relief_efforts/philippines_typhoon/">Philippines Typhoon</a></li>
          <li><a href="<?php echo __WEBROOT__; ?>relief_efforts/alabama_tornado/">Alabama Tornado</a></li>
          <li><a href="<?php echo __WEBROOT__; ?>relief_efforts/indonesia_tsunami/">Indonesia Tsunami</a></li>
          <li><a href="<?php echo __WEBROOT__; ?>relief_efforts/chile_earthquake/">Chile Earthquake</a></li>
          <li><a href="<?php echo __WEBROOT__; ?>relief_efforts/haiti_earthquake/">Haiti Earthquake</a></li>
        </ul>
      </li>
      <li>
        <a href="">Media</a>
        <ul>
          <div class="arrow"></div>
          <li>
            <a href="<?php echo __WEBROOT__; ?>press.php">Press</a>
          </li>
          <li>
            <a href="<?php echo __WEBROOT__; ?>photos.php">Photos</a>
          </li>
          <li>
            <a href="<?php echo __WEBROOT__; ?>videos.php">Videos</a>
          </li>
        </ul>
      </li>

      <li>
        <a href="<?php echo __WEBROOT__; ?>about_us.php">About Us</a>
        <ul>
          <div class="arrow" style="left: 10px;"></div>

          <li>
            <a href="<?php echo __WEBROOT__; ?>about_us.php">About</a>
          </li>
          <li>
            <a href="<?php echo __WEBROOT__; ?>contact_us.php">Contact</a>
          </li>
        </ul>
      </li>
      <li>
        <a href="<?php echo __WEBROOT__; ?>get_involved.php">Get Involved</a>
        <ul>
          <div class="arrow" style="left: 30px;"></div>

          <li>
            <a href="<?php echo __WEBROOT__; ?>/files/volunteer_information_sheet.pdf" target="_blank">Volunteer</a>
          </li>
          <li>
            <a href="<?php echo __WEBROOT__; ?>partners.php">Partners</a>
            <ul>
              <li><a href="<?php echo __WEBROOT__; ?>partners.php">Current Partners</a></li>
              <li><a href="<?php echo __WEBROOT__; ?>become_a_partner.php">Become a Partner</a></li>
            </ul>
          </li>
          <li>
            <a href="http://roww.3dcartstores.com/" target="_blank" rel="nofollow">Merchandise</a>
          </li>
          <li>
            <a href="http://www.crowdrise.com/reachoutworldwideinc" target="_blank" rel="nofollow">Crowdrise</a>
          </li>
        </ul>
      </li>
      <!--<li>
            <a href="<?php echo __WEBROOT__; ?>contact_us.php">Contact</a>
        </li>-->
      <!--<li>
    			<a href="<?php echo __WEBROOT__; ?>partners.php">Partners</a>
    			<ul>
    			<div class="arrow" style="left: 10px;"></div>
    				<li><a href="<?php echo __WEBROOT__; ?>partners.php">Current Partners</a></li>
    				<li><a href="<?php echo __WEBROOT__; ?>contact_us.php">Become a Partner</a></li>
    			</ul>
    		</li>-->
    </ul>
  </div>
</div>
<div id="contentWrapper">

