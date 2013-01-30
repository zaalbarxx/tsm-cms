<div class="contentArea">
    <h1>Pay Online</h1>
<p style="text-align: center;">Please choose a payment option below.
    <br/><br/>
    <a target="_parent"
       href="https://sandbox.paypal.com/cgi-bin/webscr?notify_url=<?php echo $notify_url; ?>&amp;cmd=_xclick&amp;business=jlane_1225424090_biz@veritasproductions.net&amp;lc=US&amp;item_name=<?php echo $planInfo['name']; ?>&amp;amount=<?php echo $firstInvoice['amount']; ?>&amp;currency_code=USD&amp;button_subtype=services&amp;no_note=1&amp;no_shipping=1&amp;rm=2&amp;return=<?php echo $return_url; ?>&amp;cancel_return=<?php echo $cancel_url; ?>&amp;bn=PP%2dBuyNowBF%3abtn_buynow_LG%2egif%3aNonHosted&amp;custom=<?php echo $familyInfo['family_id']; ?>&invoice=<?php echo $firstInvoice['family_invoice_id']; ?>"><img
            src="templates/100/images/paypal_button.gif" style="display: inline-block;"/></a>
  <?php if (isset($familyInfo['quickbooks_customer_id']) && $currentCampus->usesQuickbooks()) { ?>
    <form style="text-align: center;" method="post" target="_payByIpnWindow"
          action="https://ipn.intuit.com/payNow/start" id="payByIpnForm">
        <input type="hidden" name="eId" value="5152baca5e802cda"/> <input type="hidden" name="uuId"
                                                                          value="8a89fc3b-5f4b-49be-809e-8fc3a1ff0f32"/>
        <input type="image" id="payByIpnImg" style="background-color:transparent;border:0 none;"
               src="https://ipn.intuit.com/images/payButton/btn_PayNow_BLU_LG.png"
               alt="Make payments for less with Intuit Payment Network."/></form>
  <?php } ?>
    </p>
</div>