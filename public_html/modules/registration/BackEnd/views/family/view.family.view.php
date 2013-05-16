<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
    <h1><?php echo $pageTitle; ?> Family - <a
            href="index.php?mod=registration&view=family&action=addEditFamily&family_id=<?php echo $familyInfo['family_id']; ?>"
            class="editButton" title="Edit Family"></a></h1>

    <div class="infoSection well clearfix">
        <h3>Family Information</h3>

        <div class="half">
            <strong>Father:</strong> <?php echo $familyInfo['father_first']." ".$familyInfo['father_last']; ?>
            <br/>
            <strong>Mother:</strong> <?php echo $familyInfo['mother_first']." ".$familyInfo['mother_last']; ?>
            <br/>
            <strong>Primary E-mail:</strong> <?php echo $familyInfo['primary_email']; ?><br/>
            <strong>Seconary E-mail:</strong> <?php echo $familyInfo['secondary_email']; ?>
        </div>
        <div class="half">
            <address>
                <span class="title">Billing Address</span><br/>
              <?php echo $familyInfo['address']."<br />".$familyInfo['city'].", ".$familyInfo['state']." ".$familyInfo['zip']; ?>
            </address>
            <strong>Registered: </strong><?php echo date('D, M d, Y', strtotime($familyInfo['school_year_info']['registration_time'])); ?>
        </div>
        <div class="center">
            <div class="btn-group clearfix" style="top: 10px;">
                <a href="index.php?mod=registration&view=family&action=resetPassword&family_id=<?php echo $familyInfo['family_id']; ?>"
                   class="btn fb">Reset
                    Password</a><?php if ($currentCampus->usesQuickbooks() && $familyInfo['quickbooks_customer_id'] == "") { ?>
                <a href="index.php?mod=registration&view=family&action=linkToQuickbooks&family_id=<?php echo $familyInfo['family_id']; ?>"
                   class="btn fb">Link To Quickbooks</a>

              <?php } ?>
                <a class="btn" target="_blank"
                   href="index.php?mod=registration&view=family&action=viewFamily&family_id=<?php echo $familyInfo['family_id']; ?>&loginAs=1">Login
                    As</a>
            </div>
        </div>
    </div>
    <div class="infoSection well clearfix">
        <h2>Students</h2>
        <br/>
      <?php
      foreach ($students as $student) {
        ?>
          <div class="bigItem well">
              <span class="title"><?php echo $student['first_name']." ".$student['last_name']; ?></span>
			<span class="buttons">
				<a href="index.php?mod=registration&view=student&action=viewStudent&student_id=<?php echo $student['student_id']; ?>"
           class="reviewButton" title="Review This Student"></a>
				<a href="#" class="editButton" title="Edit This Student"></a>
			</span>

              <div class="itemDetails">
                  <h3>Basic Information</h3>

                  <div class="two-thirds">
                      <strong>Nickname:</strong> <?php echo $student['nickname']; ?><br/>
                      <strong>Age:</strong> <?php echo $student['age']; ?><br/>
                      <strong>Grade:</strong> <?php echo $student['grade']; ?><br/>
                      <strong>E-mail Address:</strong> <?php echo $student['email']; ?><br/>
                  </div>
                  <div class="one-third">
                      <strong>Status:</strong> Unapproved<br/>
                  </div>
                  <hr class="divider"/>
                  <h3>Fee Summary</h3>

                  <div class="half">
                      <strong>Registration Fees:</strong> $<?php echo $student['registration_total']; ?><br/>
                  </div>
                  <div class="half">
                      <strong>Yearly Tuition:</strong> $<?php echo $student['tuition_total']; ?><br/>
                  </div>

              </div>
          </div>
        <?php
      }
      ?>
    </div>
    <div class="infoSection well">
      <h2>Payment Plans</h2>
      <table style="width: 100%;" class="table table-striped table-bordered ">
        <tr style="font-weight: bold;">
          <td>ID</td>
          <td>Description</td>
          <!--<td>Fee Types</td>-->
          <td>Total</td>
          <td>Amt Paid</td>
          <td>Amt Invoiced</td>
          <td>Amt Due</td>
          <td>Status</td>
        </tr>
        <?php
        if(isset($paymentPlans)){
          foreach($paymentPlans as $paymentPlan){
            echo "<tr><td>".$paymentPlan['family_payment_plan_id']."</td>
            <td>".$paymentPlan['name']."</td>
            <!--<td>".$paymentPlan['fee_type_names']."</td>-->
            <td>$".$paymentPlan['totalAmount']."</td>
            <td>$".$paymentPlan['amountPaid']."</td>
            <td>$".$paymentPlan['amountInvoiced']."</td>
            <td>$".$paymentPlan['amountDue']."</td>
            <td>".$paymentPlan['status'];
            if($paymentPlan['status'] == "Pending Approval"){
              echo " - <a class='btn btn-success btn-mini fb' href='index.php?mod=registration&view=family&action=approvePaymentPlan&familyPaymentPlanId=".$paymentPlan['family_payment_plan_id']."'>Approve</a>";
            } else if ($paymentPlan['moreFeesAvailible']){
              echo " - <a class='btn btn-success btn-mini fb' href='index.php?mod=registration&view=family&action=addFeesToPaymentPlan&familyPaymentPlanId=".$paymentPlan['family_payment_plan_id']."'>Add Fees</a> | <a class='btn btn-success btn-mini fb' href='index.php?mod=registration&view=family&action=invoiceFeesToPaymentPlan&familyPaymentPlanId=".$paymentPlan['family_payment_plan_id']."'>Invoice All</a>";
            }
            echo "</td></tr>";
          }
        }

        ?>
      </table>

    </div>
    <div class="infoSection well">
        <h2>Recent Invoices</h2>
        <table style="width: 100%;" class="table table-striped table-bordered ">
            <tr style="font-weight: bold;">
                <td>ID</td>
                <td>Description</td>
                <td>Date</td>
                <td>Total</td>
                <td>Amount Paid</td>
                <td>Amount Due</td>
                <td></td>
            </tr>

          <?php
          if (isset($invoices)) {
            foreach ($invoices as $invoice) {
              echo "<tr><td>".$invoice['family_invoice_id']."</td><td>".$invoice['invoice_description']."</td><td>".date('m/d/Y', strtotime($invoice['invoice_time']))."</td><td>$".$invoice['amount']."</td><td>$".$invoice['amountPaid']."</td><td>$".$invoice['amountDue']."</td><td><a href='index.php?mod=registration&view=invoice&action=viewPDF&family_invoice_id=".$invoice['family_invoice_id']."' class='btn btn-primary'>View</a></td></tr>";
            }
          } else {
            echo "<tr class='warning'><td colspan=7>There are no recent invoices for this family.</td></tr>";
          }
          ?>
        </table>
    </div>

</div>
<script type="text/javascript">
    $(".bigItem .title").click(function () {
        $(this).parent().children(".itemDetails").slideToggle();
    });
</script>