<?php if(isset($com)){ ?>
    </div>
  </div>
<?php } ?>
<div class="footerTop">
  <div style="text-align: center;width: 12%; padding: 0; margin: 10px 2% 10px 0; float: left;">
    <div class="socialButtons" style="margin-top: 50px;">
      <b style="display: block; margin-bottom: 20px;">Follow Us</b>
      <a href="https://www.facebook.com/reachoutworldwide" target="_blank" rel="nofollow" class="facebook"></a><br />
      <a href="https://twitter.com/ReachOutWW" target="_blank" rel="nofollow" class="twitter"></a><br />
      <a href="http://pinterest.com/reachoutww/" target="_blank" rel="nofollow" class="pinterest"></a><br />
      <a href="http://www.youtube.com/user/reachoutworldwide" target="_blank" rel="nofollow" class="youtube"></a><br />
      <a href="http://reachoutworldwide.wordpress.com/" target="_blank" rel="nofollow" class="wordpress"></a>
    </div>
  </div>

  <div style="width: 48%; padding: 0; margin: 10px 2% 10px 0; float: left;">
    <div class="third">
      <ul class="footerList">
        <li><a href="/relief_efforts">Relief Efforts</a>
          <ul>
            <li><a href="/relief_efforts/philippines_typhoon/">Philippines Typhoon</a></li>
            <li><a href="/relief_efforts/alabama_tornado/">Albama Tornado</a></li>
            <li><a href="/relief_efforts/indonesia_tsunami/">Indonesia Tsunami</a></li>
            <li><a href="/relief_efforts/chile_earthquake/">Chile Earthquake</a></li>
            <li><a href="/relief_efforts/haiti_earthquake/">Haiti Earthquake</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <div class="third">
      <ul class="footerList">
        <li><a href="/get_involved.php">Get Involved</a>
          <ul>
            <li>
              <a href="http://www.roww.org/files/volunteer_information_sheet.pdf" target="_blank" rel="nofollow">Volunteer</a>
            </li>
            <li>
              <a href="/mission_fish.php">Mission Fish</a>
            </li>
            <li>
              <a href="http://www.crowdrise.com/reachoutworldwideinc" target="_blank" rel="nofollow">Crowdrise</a>
            </li>
            <li>
              <a href="http://roww.3dcartstores.com/" target="_blank" rel="nofollow">Merchandise</a>
            </li>

          </ul>
        </li>

      </ul>
    </div>
    <div class="third">
      <ul class="footerList">
        <li><a href="/partners.php">Partners</a>
          <ul>
            <li><a href="/partners.php">Current Partners</a></li>
            <li><a href="/become_a_partner.php">Become a Partner</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>

  <div class="third">
    <div contenteditable="true">
    <img src="/files/2/images/Roww-Logo.png" />
    </div>
    <p style="text-align: center; padding-right: 30px;margin-top: -20px; font-weight: normal;"><br />
      <a href="mailto:info@roww.org">Email Us</a><br /><br />

      Reach Out WorldWide Foundation<br />
      700 S. Flower St. #201<br />
      Burbank, CA 91502
      <br /><br />
      Phone: (747) 333-8977
    </p>
  </div>
  <style>
    .footerTop{
      height: 300px;
    }
  </style>
</div>
<div class="footerBottom">
  Copyright &copy; 2012 Reach Out WorldWide. All rights reserved.
</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23055947-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();


  $(document).ready( function(){
    $("#donateNow").css({bottom : $(window).height() / 2 });
  });
</script>
<script type="text/javascript">
  $.fn.preload = function() {
    this.each(function(){
      $('<img/>')[0].src = this;
    });
  }

  //preload the social media hover buttons.
  $(['../roww/template//files/2/images/facebook_icon.png','../roww/template//files/2/images/facebook_icon_hover.png','../roww/template//files/2/images/twitter_icon.png','../roww/template//files/2/images/twitter_icon_hover.png','../roww/template//files/2/images/pinterest_icon.png','../roww/template//files/2/images/pinterest_icon_hover.png','../roww/template//files/2/images/youtube_icon.png','../roww/template//files/2/images/youtube_icon_hover.png','home_rotation/slide-3/read_more_hover.jpg']).preload();
</script>
<style>
  #donateNow{
    position: fixed;
    right: 0px;
    bottom: 40px;
  }
  #donateNow .big_button{
    -webkit-border-top-left-radius: 10px;
    -webkit-border-bottom-left-radius: 10px;
    -moz-border-radius-topleft: 10px;
    -moz-border-radius-bottomleft: 10px;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;

    -webkit-border-top-right-radius: 0px;
    -webkit-border-bottom-right-radius: 0px;
    -moz-border-radius-topright: 0px;
    -moz-border-radius-bottomright: 0px;
    border-top-right-radius: 0px;
    border-bottom-right-radius: 0px;
    padding: 24px 0px;
    padding-right: 20px;
    padding-left: 20px;
    width: 75px;
    text-align: center;
    line-height:1.4em;
    background: #039f10;
    background: -moz-linear-gradient(top, #039f10 1%, #006308 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(1%,#039f10), color-stop(100%,#006308));
    background: -webkit-linear-gradient(top, #039f10 1%,#006308 100%);
    background: -o-linear-gradient(top, #039f10 1%,#006308 100%);
    background: -ms-linear-gradient(top, #039f10 1%,#006308 100%);
    background: linear-gradient(top, #039f10 1%,#006308 100%);
  }
  #donateNow .big_button:hover{
    background: #01740b;
    background: -moz-linear-gradient(top, #01740b 1%, #015908 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(1%,#01740b), color-stop(100%,#015908));
    background: -webkit-linear-gradient(top, #01740b 1%,#015908 100%);
    background: -o-linear-gradient(top, #01740b 1%,#015908 100%);
    background: -ms-linear-gradient(top, #01740b 1%,#015908 100%);
    background: linear-gradient(top, #01740b 1%,#015908 100%);
  }
</style>
<div id="donateNow" <?php if($_SERVER["REQUEST_URI"] == "/donate.php"){ echo "style=\"display: none;\""; } ?>>
  <a href="/donate.php" class="big_button">Donate<br />Now</a>
</div>