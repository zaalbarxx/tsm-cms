<?php
require_once($tsm->website->getTemplateHeader());
?>
  <div id="sliderWrapper">
    <div id="sliderContent">
      <div class="slide two-year-anniversary" id="slide-1">
        <div class="inside">
          <div class="framed video-box">
            <div class="placeHolder">

              <img src="files/2/home_rotation/slide-1/2-year-placeholder.jpg" />
              <div class="playButton" id="playSlide1" style=""></div>
            </div>
            <iframe id="rowwVideo" style="display: none;" onload="floaded()" width="551" height="305" src="http://www.youtube.com/embed/ZiGCqsq9aCE?wmode=opaque" frameborder="0" allowfullscreen></iframe>
          </div>
          <script type="text/javascript">
            $("#playSlide1").click( function(){
              stopRotation = true;
              $(this).parent().hide();
              $("#rowwVideo").show();
              player.playVideo();
            });
          </script>
          <div class="rightContainer">
            <h1>Reach Out WorldWide</h1>
            <p style="margin-bottom: 40px;">ROWW is a network of professionals with first responder skill-sets who augment local expertise when natural disasters strike in order to accelerate relief efforts.</p>
            <p><a href="donate.php" class="d-button red">Donate Now</a></p>
          </div>
          <br class="clear" />
        </div>
      </div>
      <div class="slide" id="slide-3" style="display: none;">
        <div class="inside">
          <div class="rightContainer" style="float: right; padding-top: 125px; position: relative; right: -80px;">
            <p><a href="press/stihl_reaches_out/" class="stihl-read-more"></a></p>
          </div>
          <br class="clear" />
        </div>
      </div>
      <div class="slide" id="slide-5" style="display: none;">
        <div class="inside">
          <div class="rightContainer" style="float: right; padding-top: 125px; position: relative; right: -80px;">
            <p style="margin-bottom: 40px; color: #000">Want to get involved? Click below to see the different ways you can contribute.</p>
            <p><a href="get_involved.php" class="d-button red">Read More</a></p>
          </div>
          <br class="clear" />
        </div>

      </div>
    </div>
    <div id="sliderThumbs">

      <div class="inside">
        <span id="thumbs-pointer" style="left: 280.5px;"></span>
        <ul style="text-align: center;">
          <li>
            <a href="#" rel="1" class="sliderThumb"><img src="files/2/home_rotation/slide-1/2-year-thumb.jpg" />Reach Out WorldWide</a>
          </li>
          <li>
            <a href="#" rel="3" class="sliderThumb"><img src="files/2/images/stihl_thumb.jpg" />STIHL</a>
          </li>
          <li>
            <a href="#" rel="5" class="sliderThumb"><img src="files/2/home_rotation/slide-5/get_involved_thumb.jpg" />Get Involved</a>
          </li>
        </ul>
      </div>
    </div>
    <script type="text/javascript">
      var stopRotation = false;

      var player;
      function floaded(){
        player = new YT.Player('rowwVideo', {
          videoId: 'ZiGCqsq9aCE',
          events:
          {
            'onStateChange': function (event)
            {
              if (event.data == YT.PlayerState.PLAYING){
                stopRotation = true;
                currentThumb = $(".sliderThumb").children().eq(0);
                $(".slide").hide();
                $("#slide-1").show();
                var thumbPositionLeft = $(currentThumb).position().left, // get current li position
                  thumbWidth = $(currentThumb).outerWidth(), // get current li width
                  pointerWidth = $("#thumbs-pointer").outerWidth(),
                  left = thumbPositionLeft + (thumbWidth/2) - (pointerWidth/2); // get current li width
                $("#thumbs-pointer").animate({ 'left': left });
              }
            }
          }

        });
      }

      $(".sliderThumb").click( function(){
        currentThumb = $(this);
        $(".slide").fadeOut();
        $("#slide-" + $(this).attr("rel")).fadeIn();
        var thumbPositionLeft = $(currentThumb).position().left, // get current li position
          thumbWidth = $(currentThumb).outerWidth(), // get current li width
          pointerWidth = $("#thumbs-pointer").outerWidth(),
          left = thumbPositionLeft + (thumbWidth/2) - (pointerWidth/2); // get current li width
        $("#thumbs-pointer").animate({ 'left': left });

        stopRotation = true;
        return false;
      });
      $(document).ready(function() {
        var itemInterval = 5000;
        var fadeTime = 500;
        var numberOfItems = $('#sliderContent').children().length;
        var currentThumb = $(".sliderThumb").children().eq(0);
        var currentItem = 0;
        var infiniteLoop = setInterval(function(){
          if(stopRotation == false){
            $('#sliderContent').children().eq(currentItem).fadeOut();
            if(currentItem == numberOfItems-1){
              currentItem = 0;
            }else{
              currentItem++;
            }
            currentThumb = $(".sliderThumb").children().eq(currentItem);
            var thumbPositionLeft = $(currentThumb).position().left, // get current li position
              thumbWidth = $(currentThumb).outerWidth(), // get current li width
              pointerWidth = $("#thumbs-pointer").outerWidth(),
              left = thumbPositionLeft + (thumbWidth/2) - (pointerWidth/2); // get current li width
            $("#thumbs-pointer").animate({ 'left': left });
            $('#sliderContent').children().eq(currentItem).fadeIn();
          }
        }, itemInterval);

      });
    </script>
  </div>
  <div id="contentWrapper">
    <div class="home-our-mission home-section">
      <h2 class="strong">ROWW Mission</h2>
      <div class="inside">
        <p class="large">ROWW is a network of professionals with first responder skill-sets who augment local expertise when natural disasters strike in order to accelerate relief efforts.</p>
        <p class="large " style="font-family: sans-serif;">Get relief effort updates by subscribing to our newsletter:</p>
        <div class="signup">
          <form method="POST" class="styled-form flex" novalidate="">
            <fieldset>
              <div class="label-placeholder first-name required">
                <input id="firstName" class="text" name="firstName" type="text" value="" autocomplete="off">
                <label for="firstName">first name</label>
              </div>
              <div class="label-placeholder last-name required">
                <input id="lastName" class="text" name="lastName" type="text" value="" autocomplete="off">
                <label for="lastName">last name</label>
              </div>
              <div class="label-placeholder email required">
                <input id="email" class="text" name="email" type="email" value="" autocomplete="off">
                <label for="email">your email</label>
              </div>
            </fieldset>
            <input type="submit" class="d-button red" value="submit" autocomplete="off">
          </form>

          <div id="success" class="success" style="display: none;">
            <span class="check"></span>Thank you for supporting ROWW!
          </div>
        </div>
        <script type="text/javascript">
          $(document).ready( function(){
            $("form").submit( function(){
              $.ajax({
                type: 'POST',
                url: 'submit_email_signup.php',
                data: $("form").serialize(),
                success: function(data){
                  if(data == "1"){
                    $("#success").show();
                    $(".styled-form").hide();
                    $(".success").fadeOut(3000);
                  } else {
                    alert(data);
                  }
                }
              });

              return false;
            });
            $("#firstName,#lastName,#email").focus( function(){
              $(this).parent().children("label").hide();
            }).blur( function(){
                if($(this).val() == ""){
                  $(this).parent().children("label").show();
                }
              });
          });
        </script>
      </div>
    </div>
    <div class="home-section thirds">
      <div class="inside">
        <div class="third">
          <div style="height: 300px;"><a href="relief_efforts/philippines_typhoon/"><img border="0" height="300px" style="padding: 4px; box-shadow: 0 0 1px rgba(0, 0, 0, 0.5);" src="files/2/images/ROWW-3Main-Philippines.jpg" /></a></div><a href="relief_efforts/philippines_typhoon/"><h3>PHILIPPINES TYPHOON</h3></a>
          <p style="height: 150px;">The massive flooding claimed the lives of over 1,200 men, women and children. Thousands of people with their entire lives swept away by the raging waters left to rebuild what was remaining of their past lives.</p>
          <a href="relief_efforts/philippines_typhoon/" class="d-button red">Read More</a></div>
        <div class="third">
          <div style="height: 300px;"><a href="relief_efforts/alabama_tornado/"><img style="padding: 4px; box-shadow: 0 0 1px rgba(0, 0, 0, 0.5);" src="files/2/images/ROWW-3Main-Alabama.jpg" /></a></div>
          <a href="relief_efforts/alabama_tornado/"><h3>ALABAMA TORNADO</h3></a>
          <p style="height: 150px;">Although Alabama is not new to tornado activity, this time, it was different.</p>
          <a href="relief_efforts/alabama_tornado/" class="d-button red">Read More</a>
        </div>
        <div class="third">
          <div style="height: 300px;"><a href="relief_efforts/indonesia_tsunami/"><img style="padding: 4px; box-shadow: 0 0 1px rgba(0, 0, 0, 0.5);" border="0" height="300px" src="files/2/images/ROWW-3Main-Indo.jpg" /></a></div>
          <a href="relief_efforts/indonesia_tsunami/"><h3>INDONESIA TSUNAMI</h3></a>
          <p style="height: 150px;">The devastation from the 7.7 earthquake
            and the hundreds of aftershocks was bad enough,
            but in late October 2010, a terrifying tsunami
            swept through the Mentawai Islands.</p>
          <a href="relief_efforts/indonesia_tsunami/" class="d-button red" >Read More</a></div>
        <br style="width: 100%; clear: both;" />
      </div>
    </div>
    <br /><br /><br /><br />
  </div>
<?php
require_once($tsm->website->getTemplateFooter());
?>