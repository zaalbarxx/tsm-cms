<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<script src="../includes/3rdparty/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/3rdparty/ckeditor/adapters/jquery.js"></script>
<div class="span9">
    <h1><?php echo $pageTitle; ?></h2>
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
          <?php
          /*
          if ($currentCampus->usesQuickbooks()) { ?>
            <fieldset>
                <legend>Quickbook Information</legend>
                <label for="quickbooks_customer_id">Customer: </label><select name="quickbooks_customer_id">
                <option value="">Select a Customer</option>
              <?php
              foreach ($quickbooksCustomers as $customer) {
                $id = $customer->getId();
                if ($id == $familyInfo['quickbooks_customer_id']) {
                  $selected = " selected=selected";
                } else {
                  $selected = "";
                }
                $address = $customer->getAddress();
                echo "<option value='".$id."' $selected>".$customer->getName()." - ".$address->getLine2()."</option>";
                //echo $item->getId()."--".$item->getName()."--$".$price."<br />";
              }
              ?>
            </select>
            </fieldset>
          <?php }
          */
          ?>
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
            <br/>
            <input type="hidden" name="campus_id" value="<?php echo $currentCampus->getCampusId(); ?>"/>
            <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>"/>
            <input type="hidden" name="school_year" value="<?php echo $currentCampus->getCurrentSchoolYear(); ?>"/>
            <input type="hidden" name="<?php echo $submitField; ?>" value="1"/>
            <input type="submit" class="btn btn-primary" style="float: right;" value="Save Family"/>
            <br/><br/><br/>
        </form>
</div>