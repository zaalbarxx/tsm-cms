<?php
require_once(__TSM_ROOT__."modules/registration/FrontEnd/views/sidebar.view.php");
?>
<div class="contentArea">

  <h1 style="text-align: center;">Recent payments</h1>

  <p style="text-align: center;">Below you can see recent payments.</p>


  <div class="infoSection">
    <table style="width: 100%; " cellspacing=0 cellpadding=5>
      <tr style="font-weight: bold;background: #ddd;">
        <td>Reference number</td>
        <td>Payment description</td>
        <td>Payment date</td>
        <td>Quickbooks payment id</td>
        <td>Payment type</td>
        <td>Amount</td>
      </tr>

      <?php
        $i = 0;
        foreach ($recentPayments as $payment) {

          if($i & 1){
            $rowStyle = "background: #ddd;";
          } else {
            $rowStyle = "";
          }
          echo "<tr style='height: 45px; $rowStyle'><td>".$payment['reference_number']."</td><td>".$payment['payment_description']."</td><td>".date('m/d/Y', strtotime($payment['payment_time']))."</td>";
          echo "</td><td>".$payment['quickbooks_payment_id']."</td><td>".$payment['payment_type']."</td><td>$".number_format($payment['amount'],2)."</td></tr>";
          $i++;
        }
      ?>
    </table>
  </div>

</div>