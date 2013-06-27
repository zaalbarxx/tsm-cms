<?php
require_once(__TSM_ROOT__."modules/registration/FrontEnd/views/sidebar.view.php");
?>
<div class="contentArea">

<h1 style="text-align: center;">Registration Summary</h1>

<p style="text-align: center;">Below is a summary of your family registration. You can view which students you have enrolled by clicking "My Students" on the left.</p>

<div class="infoSection">
  <h2>Family Information</h2>

  <div class="half">
            <span class="title"
                  style="width: 150px;">Father:</span> <?php echo $familyInfo['father_first']." ".$familyInfo['father_last']; ?>
    <br/>
    <span class="title" style="width: 150px;">Father Cell:</span> <?php echo $familyInfo['father_cell']; ?>
    <br/><br/>
            <span class="title"
                  style="width: 150px;">Mother:</span> <?php echo $familyInfo['mother_first']." ".$familyInfo['mother_last']; ?>
    <br/>
    <span class="title" style="width: 150px;">Mother Cell:</span> <?php echo $familyInfo['mother_cell']; ?>

  </div>
  <div class="half">
    <span class="title" style="width: 150px;">Primary E-mail:</span> <?php echo $familyInfo['primary_email']; ?>
    <br/>
            <span class="title"
                  style="width: 150px;">Seconary E-mail:</span> <?php echo $familyInfo['secondary_email']; ?>
    <br/><br/>
    <span class="title" style="width: 150px;">Billing Address</span><br/>
            <span style="display: block; margin-left: 30px;">
            <?php echo $familyInfo['address']."<br />".$familyInfo['city'].", ".$familyInfo['state']." ".$familyInfo['zip']; ?>
            </span>
  </div>

</div>
<!--
<h2 style="text-align: center;">Registered Students</h2>
<?php foreach ($students as $studentInfo) { ?>
  <div class="infoSection">

    <h2 class="title"><?php echo $studentInfo['last_name'].", ".$studentInfo['first_name']; ?> - <span
        class="showDetails" style="font-size: 14px; text-decoration: underline;">show details</span>

      <div class="summary">
        <div class="icons">
          <?php
          if (isset($studentInfo['programs'])) {
            foreach ($studentInfo['programs'] as $program) {
              echo "<img src='".$program['icon_url']."' />";
            }
          }
          ?>

        </div>
        <div class="feeTotals" style="font-weight: normal; text-align: right;">
          Registration Total: $<?php echo $studentInfo['registrationTotal']; ?><br/>Tuition Total:
          $<?php echo $studentInfo['tuitionTotal']; ?>
        </div>
      </div>
    </h2>

    <div class="itemDetails" style="display: none">

      <div class="two-thirds">
        <span class="label">Nickname:</span> <?php if ($studentInfo['nickname'] == "") {
          echo "N/A";
        } else {
          echo $studentInfo['nickname'];
        } ?><br/>
        <span class="label">Age:</span> <?php echo $studentInfo['age']; ?><br/>
        <span class="label">Grade:</span> <?php echo $reg->getGradeDisplay($studentInfo['grade']); ?><br/>
        <span class="label">E-mail Address:</span> <?php if ($studentInfo['nickname'] == "") {
          echo "N/A";
        } else {
          echo $studentInfo['email'];
        } ?>
      </div>

      <br style="width: 100%; clear: both;"/>
      <br style="width: 100%; clear: both;"/>
      <a href="" class="showDetails right small_button">Hide Details</a>

      <h3 style="text-align: center;"><?php echo $studentInfo['first_name']; ?>'s Enrollment Summary</h3>
      <br/>
      <?php
      if (isset($studentInfo['programs'])) {
        foreach ($studentInfo['programs'] as $program) {
          ?>
          <div class="bigItem">
                <span class="title"><img src="<?php echo $program['icon_url']; ?>"
                                         style="width: 40px; margin-top: -25px; margin-bottom: -15px; margin-right: 20px; margin-left: -30px;"/><?php echo $program['name']; ?>
                  <span class="tuition"
                        style="float:right; width: 200px; display: none;">Program Tuition: $<?php echo $program['tuition_total']; ?></span></span>

            <div class="itemDetails" style="display: block;">
              <?php if ($program['has_courses']) { ?>
                <br/>
                <table class="dataTable">
                  <tr class="header">
                    <td>Course Name</td>
                    <td>Period</td>
                    <td>Teacher</td>
                    <td>Tuition</td>
                    <td>Registration</td>
                  </tr>
                  <?php
                  $i = 1;
                  if ($program['courses']) {
                    foreach ($program['courses'] as $course) {
                      echo "<tr><td>".$i.". ".$course['name']."</td><td>".$tsm->intToDay($course['day']).". ".date("g:ia", strtotime($course['start_time']))." - ".date("g:ia", strtotime($course['end_time']))."</td><td>".$course['teacher_name']."</td><td align=center>$".$course['tuition_amount']."</td><td align=center>$".$course['registration_amount']."</td></tr>";
                      $i++;
                    }
                  } else {
                    echo "<tr><td colspan=5 align=center>This student is not in any courses for ".$program['name'].".</td></tr>";
                  }
                  ?>
                </table>
                <br/>
                <hr class="divider"/>
              <?php } ?>
              <h3>Program Fee Summary</h3>

              <div class="half">
                <span class="label">Registration Fees:</span> $<?php echo $program['registration_total']; ?>
                <br/>
              </div>
              <div class="half">
                <span class="label">Program Tuition:</span> $<?php echo $program['tuition_total']; ?><br/>
                <span class="label">Yearly Tuition:</span> $<?php echo $program['tuition_total']; ?><br/>
              </div>

            </div>
          </div>
        <?php
        }
      }
      ?>
      <br style="width: 100%; clear: both;"/>

      <h3 style="text-align: center;"><?php echo $studentInfo['first_name']; ?>'s Billing Summary</h3>

      <div style="width: 325px; margin-left: auto; margin-right: auto;">
        <span class="label" style="width: 200px;">Registration Total:</span>
        $<?php echo $studentInfo['registrationTotal']; ?><br/>
        <span class="label" style="width: 200px;">Tuition Total:</span>
        $<?php echo $studentInfo['tuitionTotal']; ?>
        <br/>
        <span class="label" style="width: 200px;">Student Total:</span>
        $<?php echo $studentInfo['studentTotal']; ?>
      </div>
    </div>
  </div>
<?php } ?>
<br/>-->

<div class="infoSection">
  <h2>Recent Invoices</h2>
  <table style="width: 100%; " cellspacing=0 cellpadding=5>
    <tr style="font-weight: bold;background: #ddd;">
      <td>Invoice</td>
      <td>Description</td>
      <td>Date</td>
      <td>Total</td>
      <td>Amount Paid</td>
      <td>Amount Due</td>
      <td align=center>Options</td>
    </tr>

    <?php
    if (isset($familyInvoices)) {
      $i = 0;
      foreach ($familyInvoices as $invoice) {

        if($i & 1){
          $rowStyle = "background: #ddd;";
        } else {
          $rowStyle = "";
        }
        echo "<tr style='height: 45px; $rowStyle'><td>".$invoice['doc_number']."</td><td>".$invoice['invoice_description']."</td><td>".date('m/d/Y', strtotime($invoice['invoice_time']))."</td><td>$".number_format($invoice['amount'],2)."</td><td>$".number_format($invoice['amountPaid'],2);
        echo "</td><td>$".number_format($invoice['amountDue'],2)."</td><td><a href='index.php?mod=registration&view=invoice&action=viewPDF&family_invoice_id=".$invoice['family_invoice_id']."' class=\"small_button\" target=\"blank\">View Invoice</a>";
        if ($invoice['amountPaid'] == 0 && $campusInfo['paypal_email'] != "") {
          echo " - <a href='index.php?view=invoice&action=payOnline&family_invoice_id=".$invoice['family_invoice_id']."' class='payOnline fb small_button'>Pay Now</a>";
        }
        echo "</td></tr>";
        $i++;
      }
    }
    ?>
  </table>
</div>
<div class="infoSection">
  <h2 class="title">
    Family Billing Summary
  </h2>

  <div class="itemDetails">
    <div class="center">
      <?php
      foreach ($feeTypes as $feeType) {
        $total = $reg->addFees($family->getFees($feeType['fee_type_id']));
        if ($total > 0) {
          ?>
          <span><b>Total <?php echo $feeType['name']; ?>:</b> $<?php echo $total; ?></span><br/>
        <?php
        }
      }
      ?>
    </div>
  </div>
</div>

<br style="width: 100%; clear: both;"/>
</div>
<script type="text/javascript">
  $(".bigItem .title,.infoSection .title").click(function () {
    $(this).parent().children(".itemDetails").slideToggle();
    $(this).children(".summary").toggle(500);
    if ($(this).children(".showDetails").html() == "show details") {
      $(this).children(".showDetails").html("hide details");
    } else {
      $(this).children(".showDetails").html("show details");
    }
  });

  $(".itemDetails .showDetails").click(function () {
    if ($(this).html() == "Show Details") {
      $(this).parent().children(".bigItem").children(".itemDetails").show(500);
      $(this).html("Hide Details");
      $(".tuition").toggle(500);
    } else {
      $(this).parent().children(".bigItem").children(".itemDetails").hide(500);
      $(this).html("Show Details");
      $(".tuition").toggle(500);
    }


    return false;
  });
</script>
<style>
  .infoSection .title {
    width: 93%;
  }
</style>