<div class="span9">
    <h2>Link To Quickbooks</h2>

    <p>To link this family to a quickbooks customer, select the customer below and press "Link Now".</p>

    <form action="" method="post" id="linkToQuickbooks" class="form-horizontal">
      <?php
      if ($currentCampus->usesQuickbooks()) {
        ?>
          <fieldset>
              <legend>Quickbook Information</legend>
              <!--<div class="control-group">
                  <label class="control-label" for="createNewCustomer">Create New Customer: </label>

                  <div class="controls">
                      <input type="checkbox" id="createNewCustomer" name="createNewCustomer" value="1"/>
                  </div>
              </div>-->
              <div class="control-group" id="quickbooks_customer_id_group">
                  <label for="quickbooks_customer_id" class="control-label">Existing Customer: </label>

                  <div class="controls">
                      <select name="linkToQuickbooks" id="quickbooks_customer_id">
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
                  </div>
              </div>
              <div class="control-group">
                  <label for="invoiceSyncType" class="control-label">Sync Method: </label>

                  <div class="controls">
                      <select id="invoiceSyncType" name="invoiceSyncType">
                          <option value="1">Create Invoices In Quickbooks</option>
                      </select>
                  </div>
              </div>
          </fieldset>
          <input type="hidden" name="family_id" value="<?php echo $familyInfo['family_id']; ?>"/>
          <input type="submit" class="btn btn-primary pull-right" value="Link Now"/>
        <?php
      }
      ?>
    </form>
</div>
<script type="text/javascript">
    $("#createNewCustomer").change(function () {
        if ($(this).is(":checked")) {
            $("#quickbooks_customer_id").val("");
            $("#quickbooks_customer_id_group").hide();
        } else {
            $("#quickbooks_customer_id_group").show();
        }
    });
    $("#linkToQuickbooks").submit(function () {
        var submitNow = confirm("Are you sure you would like to link this family to quickbooks? This will create new invoices in quickbooks for all invoices created on the registration system.");
        if (submitNow) {
            var data = $("#linkToQuickbooks").serialize();
            $.post(window.location, data, function (data) {
                if (data == "1") {
                    alert("This family was successfully linked to Quickbooks.");
                    parent.window.location.reload();
                } else {
                    alert("There was a problem adding this family to Quickbooks.");
                }
            });
            return false;
        } else {
            return false;
        }


    });
</script>