<h1>Create Campus</h1>
<?php
if ($campuses == NULL) {
  echo "<div class='errorMessage'>You do not yet have any campuses created. You must create one before continuing.</div>";
}
?>
<br/>
<form method="post" style="width: 320px; margin-left: auto; margin-right: auto" action="">
    <fieldset>
        <label for="name">Campus Name: </label><input type="text" name="name"/>
        <!--    <label for="payment_address_attn">Address Attn: </label><input type="text" name="address_attn" />
            <label for="payment_address">Address: </label><input type="text" name="address" />
            <label for="payment_address2">Address 2: </label><input type="text" name="address2" />
            <label for="payment_city">City Name: </label><input type="text" name="city" />
            <label for="payment_state">State Name: </label><input type="text" name="state" />
            <label for="payment_zip">Zip Code: </label><input type="text" name="zip" /> -->
    </fieldset>
    <input type="hidden" name="website_id" value="<?php echo $tsm->website->getWebsiteId(); ?>"/>
    <input type="hidden" name="createCampus" value="1"/>
    <input type="submit" class="btn btn-primary" style="margin-top: 20px;" value="Save Campus"/>
</form>