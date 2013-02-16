<div class="insideContent">
    <h2>Link To Quickbooks</h2>

    <p>To link this family to a quickbooks customer, select the customer below and press "Link Now".</p>

    <form action="" method="post" id="linkToQuickbooks">
      <?php
      if ($currentCampus->usesQuickbooks()) {
        ?>
          <fieldset>
              <legend>Quickbook Information</legend>
              <label for="quickbooks_customer_id">Customer: </label><select name="linkToQuickbooks"
                                                                            id="quickbooks_customer_id">
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
          </select><br/>
              <label for="invoiceSyncType">Sync Method: </label>
              <select id="invoiceSyncType" name="invoiceSyncType">
                  <option value="1">Create Invoices In Quickbooks</option>
              </select>
          </fieldset>
          <input type="hidden" name="family_id" value="<?php echo $familyInfo['family_id']; ?>"/>
          <input type="submit" style="float: right;" class="submitButton" value="Link Now"/>
        <?php
      }
      ?>
    </form>
</div>
<script type="text/javascript">
    $("#linkToQuickbooks").submit(function () {
        var submitNow = confirm("Are you sure you would like to link this family to quickbooks? This will create new invoices in quickbooks for all invoices created on the registration system.");
        if (submitNow) {
            return true;
        } else {
            return false;
        }


    });
</script>