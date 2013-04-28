<?php
require_once($tsm->website->getTemplateHeader());
?>
  <div id="contentWrapper">
    <div class="home-our-mission home-section">
      <h2 class="strong" contenteditable="true">ROWW Mission</h2>
      <div class="inside" >
        <p class="large" contenteditable="true">ROWW is a network of professionals with first responder skill-sets who augment local expertise when natural disasters strike in order to accelerate relief efforts.</p>
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
        <div class="third" contenteditable="true">
          <div style="height: 300px;"><a href="relief_efforts/philippines_typhoon/"><img border="0" height="300px" style="padding: 4px; box-shadow: 0 0 1px rgba(0, 0, 0, 0.5);" src="files/2/images/ROWW-3Main-Philippines.jpg" /></a></div><a href="relief_efforts/philippines_typhoon/"><h3>PHILIPPINES TYPHOON</h3></a>
          <p style="height: 150px;">The massive flooding claimed the lives of over 1,200 men, women and children. Thousands of people with their entire lives swept away by the raging waters left to rebuild what was remaining of their past lives.</p>
          <a href="relief_efforts/philippines_typhoon/" class="d-button red">Read More</a></div>
        <div class="third" contenteditable="true">
          <div style="height: 300px;"><a href="relief_efforts/alabama_tornado/"><img style="padding: 4px; box-shadow: 0 0 1px rgba(0, 0, 0, 0.5);" src="files/2/images/ROWW-3Main-Alabama.jpg" /></a></div>
          <a href="relief_efforts/alabama_tornado/"><h3>ALABAMA TORNADO</h3></a>
          <p style="height: 150px;">Although Alabama is not new to tornado activity, this time, it was different.</p>
          <a href="relief_efforts/alabama_tornado/" class="d-button red">Read More</a>
        </div>
        <div class="third" contenteditable="true">
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