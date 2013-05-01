<?php
require_once($tsm->website->getTemplateHeader());
?>
  <div id="contentWrapper">
    <div class="home-our-mission home-section">
      <h2 class="strong" <?php $tsm->currentTemplate->makeOptionEditable(1); ?>><?php $tsm->currentTemplate->displayOptionValue(1); ?></h2>
      <div class="inside" >
        <p class="large" <?php $tsm->currentTemplate->makeOptionEditable(2); ?>><?php $tsm->currentTemplate->displayOptionValue(2); ?></p>
        <p class="large " style="font-family: sans-serif;" <?php $tsm->currentTemplate->makeOptionEditable(6); ?>><?php $tsm->currentTemplate->displayOptionValue(6); ?></p>
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
        <div class="third" <?php $tsm->currentTemplate->makeOptionEditable(3); ?>>
          <?php $tsm->currentTemplate->displayOptionValue(3); ?>
        </div>
        <div class="third" <?php $tsm->currentTemplate->makeOptionEditable(4); ?>>
          <?php $tsm->currentTemplate->displayOptionValue(4); ?>
        </div>
        <div class="third" <?php $tsm->currentTemplate->makeOptionEditable(5); ?>>
          <?php $tsm->currentTemplate->displayOptionValue(5); ?>
        </div>
        <br style="width: 100%; clear: both; " />
    </div>
    <br /><br /><br /><br />
  </div>
<?php
require_once($tsm->website->getTemplateFooter());
?>