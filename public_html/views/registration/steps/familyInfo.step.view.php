<div class="contentArea">
    <h1><?php echo $pageTitle; ?></h2>
        <p style="text-align: center; margin: 30px;"><?php echo $headerMessage; ?></p>

        <form method="post" action="">
            <fieldset>
                <legend>Father Information</legend>
                <label for="father_first">First Name: </label><input type="text" name="father_first"
                                                                     value="<?php echo $familyInfo['father_first']; ?>"/><br/>
                <label for="father_last">Last Name: </label><input type="text" name="father_last"
                                                                   value="<?php echo $familyInfo['father_last']; ?>"/><br/>
                <label for="father_cell">Cell Phone: </label><input type="text" name="father_cell"
                                                                    value="<?php echo $familyInfo['father_cell']; ?>"/><br/>
            </fieldset>
            <fieldset>
                <legend>Mother Information</legend>
                <label for="mother_first">First Name: </label><input type="text" name="mother_first"
                                                                     value="<?php echo $familyInfo['mother_first']; ?>"/><br/>
                <label for="mother_last">Last Name: </label><input type="text" name="mother_last"
                                                                   value="<?php echo $familyInfo['mother_last']; ?>"/><br/>
                <label for="mother_cell">Cell Phone: </label><input type="text" name="mother_cell"
                                                                    value="<?php echo $familyInfo['mother_cell']; ?>"/><br/>
            </fieldset>
            <fieldset>
                <legend>E-mail Information</legend>
                <label for="primary_email">Primary E-mail: </label><input type="text" name="primary_email"
                                                                          value="<?php echo $familyInfo['primary_email']; ?>"/><br/>
                <label for="secondary_email">Secondary E-mail: </label><input type="text" name="secondary_email"
                                                                              value="<?php echo $familyInfo['secondary_email']; ?>"/><br/>
            </fieldset>
            <fieldset>
                <legend>General Information</legend>
                <label for="primary_phone">Primary Phone: </label><input type="text" name="primary_phone"
                                                                         value="<?php echo $familyInfo['primary_phone']; ?>"/><br/>
                <label for="secondary_phone">Secondary Phone: </label><input type="text" name="secondary_phone"
                                                                             value="<?php echo $familyInfo['secondary_phone']; ?>"/><br/>

                <label for="address">Address: </label><input type="text" name="address"
                                                             value="<?php echo $familyInfo['address']; ?>"/><br/>
                <label for="city">City: </label><input type="text" name="city"
                                                       value="<?php echo $familyInfo['city']; ?>"/><br/>
                <label for="state">State: </label><input type="text" name="state"
                                                         value="<?php echo $familyInfo['state']; ?>"/><br/>
                <label for="zip">Zip Code: </label><input type="text" name="zip"
                                                          value="<?php echo $familyInfo['zip']; ?>"/><br/>
            </fieldset>
          <?php if (!isset($hidePasswordFields)) { ?>
            <fieldset>
                <legend>Password</legend>
                <label for="password">Password: </label><input type="password" name="password"
                                                               value="<?php echo $password; ?>"/><br/>
                <label for="confirm_password">Confirm Password: </label><input type="password" name="confirm_password"
                                                                               value="<?php echo $confirm_password; ?>"/><br/>
            </fieldset>
          <?php } ?>
            <br/>
            <input type="hidden" name="campus_id" value="<?php echo $currentCampus->getCampusId(); ?>"/>
            <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>"/>
            <input type="hidden" name="school_year" value="<?php echo $currentCampus->getCurrentSchoolYear(); ?>"/>
            <input type="hidden" name="<?php echo $submitField; ?>" value="1"/>
            <input type="hidden" name="registerNow" value="1"/>
            <input type="submit" class="submitButton" style="float: right;" value="Next Step"/>
            <br/><br/><br/>
        </form>
</div>