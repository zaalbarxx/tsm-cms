<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title><?php echo $tsm->website->getTitle(); ?></title>
  <?php echo $tsm->getHeaderHTML(); ?>
</head>
<body>
<div id="headerWrapper"></div>
<div id="topMenuWrapper">

</div>
<div id="contentWrapper">
    <div id="navigationWrapper">
        <div id="navLogo"></div>
        <div id="topMenu">
            <ul id="primary-nav-menu" class="dd-menu">
                <li id="menu-item-87" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-87"><a
                        href="http://www.artiosacademies.com/about-artios/">OUR CONCEPT</a>
                    <ul class="sub-menu">
                        <li id="menu-item-191"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-191"><a
                                href="http://www.artiosacademies.com/about-artios/core-values/">Core Values</a></li>
                        <li id="menu-item-1076"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1076"><a
                                href="http://www.artiosacademies.com/profiles/">How Artios Can Assist Your Family</a>
                        </li>
                    </ul>
                </li>
                <li id="menu-item-966" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-966"><a
                        href="http://www.artiosacademies.com/the-concept/the-programs/">OUR PROGRAMS</a>
                    <ul class="sub-menu">
                        <li id="menu-item-967"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-967"><a
                                href="http://www.artiosacademies.com/the-concept/the-programs/the-academy-of-arts-and-history/">The
                            Academy of Arts and History</a></li>
                        <li id="menu-item-968"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-968"><a
                                href="http://www.artiosacademies.com/the-concept/the-programs/the-preparatory/">The
                            Preparatory</a></li>
                        <li id="menu-item-969"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-969"><a
                                href="http://www.artiosacademies.com/the-concept/the-programs/the-conservatory/">The
                            Conservatory</a></li>
                    </ul>
                </li>
                <li id="menu-item-253" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-253"><a
                        href="http://www.artiosacademies.com/the-curriculum/">OUR CURRICULUM</a></li>
                <li id="menu-item-179" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-179"><a
                        href="http://www.artiosacademies.com/our-locations/">OUR CAMPUSES</a>
                    <ul class="sub-menu">
                        <li id="menu-item-180"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-180"><a
                                href="http://www.artiosacademies.com/gwinnett/">GWINNETT, GA</a></li>
                        <li id="menu-item-532"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-532"><a
                                href="http://www.artiosacademies.com/johnscreek/">JOHNS CREEK, GA</a></li>
                        <li id="menu-item-1173"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1173"><a
                                href="http://www.artiosacademies.com/greenville-2/">GREENVILLE, SC</a></li>
                        <li id="menu-item-806"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-806"><a
                                href="http://www.artiosacademies.com/littleton/">LITTLETON, CO</a></li>
                        <li id="menu-item-819"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-819"><a
                                href="http://www.artiosacademies.com/orangetx/">ORANGE, TX</a></li>
                        <li id="menu-item-820"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-820"><a
                                href="http://www.artiosacademies.com/santabarbara/">SANTA BARBARA, CA</a></li>
                    </ul>
                </li>
            </ul>
          <?php
          if ($reg->family->isLoggedIn()) {

            //$tsm->website->generateMenuHTML(Array(1 => Array('title' => 'Home', 'url' => 'index.php', 'target' => '_self', 'children' => null)));
            ?>
              <a class="logoutButton" href="index.php?logout=1">Logout</a>
            <?php
          }
          ?>
        </div>

    </div>
    <div id="contentArea">