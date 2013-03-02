<?php
require_once(__TSM_ROOT__."admin/views/registration/sidebar.view.php");
?>
<div class="contentWithSideBar">
    <h1><?php echo $pageTitle; ?> Family - <a
            href="index.php?com=registration&view=family&action=addEditFamily&family_id=<?php echo $familyInfo['family_id']; ?>"
            class="editButton" title="Edit Family"></a></h1>

    <div class="infoSection">
        <h2>Family Information - <a target="_blank"
                                    href="index.php?com=registration&view=family&action=viewFamily&family_id=<?php echo $familyInfo['family_id']; ?>&loginAs=1">Login</a>
        </h2>

        <div>
            <a href="index.php?com=registration&view=family&action=resetPassword&family_id=<?php echo $familyInfo['family_id']; ?>"
               class="fb">Reset Password</a>
          <?php if ($currentCampus->usesQuickbooks() && $familyInfo['quickbooks_customer_id'] == "") { ?>
            |
            <a href="index.php?com=registration&view=family&action=linkToQuickbooks&family_id=<?php echo $familyInfo['family_id']; ?>"
               class="fb">Link To Quickbooks</a>
          <?php } ?>
        </div>
        <div class="half">
            <span class="title">Father:</span> <?php echo $familyInfo['father_first']." ".$familyInfo['father_last']; ?>
            <br/>
            <span class="title">Mother:</span> <?php echo $familyInfo['mother_first']." ".$familyInfo['mother_last']; ?>
            <br/>
            <span class="title">Primary E-mail:</span> <?php echo $familyInfo['primary_email']; ?><br/>
            <span class="title">Seconary E-mail:</span> <?php echo $familyInfo['secondary_email']; ?>
        </div>
        <div class="half">
            <span class="title">Billing Address</span><br/>
          <?php echo $familyInfo['address']."<br />".$familyInfo['city'].", ".$familyInfo['state']." ".$familyInfo['zip']; ?>
            <br/><br/>
            <span class="title">Registered: </span><?php echo date('D, M d, Y', strtotime($familyInfo['school_year_info']['registration_time'])); ?>
        </div>

    </div>
    <div class="infoSection">
        <h2>Students</h2>
        <br/>
      <?php
      foreach ($students as $student) {
        ?>
          <div class="bigItem">
              <span class="title"><?php echo $student['first_name']." ".$student['last_name']; ?></span>
			<span class="buttons">
				<a href="index.php?com=registration&view=student&action=viewStudent&student_id=<?php echo $student['student_id']; ?>"
           class="reviewButton" title="Review This Student"></a>
				<a href="#" class="editButton" title="Edit This Student"></a>
			</span>

              <div class="itemDetails">
                  <h3>Basic Information</h3>

                  <div class="two-thirds">
                      <span class="label">Nickname:</span> <?php echo $student['nickname']; ?><br/>
                      <span class="label">Age:</span> <?php echo $student['age']; ?><br/>
                      <span class="label">Grade:</span> <?php echo $student['grade']; ?><br/>
                      <span class="label">E-mail Address:</span> <?php echo $student['email']; ?><br/>
                  </div>
                  <div class="one-third">
                      <span class="label">Status:</span> Unapproved<br/>
                  </div>
                  <hr class="divider"/>
                  <h3>Fee Summary</h3>

                  <div class="half">
                      <span class="label">Registration Fees:</span> $<?php echo $student['registration_total']; ?><br/>
                  </div>
                  <div class="half">
                      <span class="label">Yearly Tuition:</span> $<?php echo $student['tuition_total']; ?><br/>
                  </div>

              </div>
          </div>
        <?php
      }
      ?>
    </div>
    <div class="infoSection">
        <h2>Recent Invoices</h2>
        <table style="width: 100%;">
            <tr style="font-weight: bold;">
                <td>ID</td>
                <td>Description</td>
                <td>Date</td>
                <td>Total</td>
                <td>Amount Paid</td>
                <td>Amount Due</td>
            </tr>

          <?php
          if (isset($invoices)) {
            foreach ($invoices as $invoice) {
              echo "<tr><td>".$invoice['family_invoice_id']."</td><td>".$invoice['name']."</td><td>".date('m/d/Y', strtotime($invoice['invoice_time']))."</td><td>$".$invoice['amount']."</td><td>$".$invoice['amountPaid']."</td><td>$".$invoice['amountDue']."</td></tr>";
            }
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