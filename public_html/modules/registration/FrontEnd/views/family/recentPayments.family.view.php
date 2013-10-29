<?php
require_once(__TSM_ROOT__."modules/registration/FrontEnd/views/sidebar.view.php");
?>
<div class="contentArea">

  <h1 style="text-align: center;">Recent Payments</h1>

  <p style="text-align: center;">A list of recent payments to your account are listed below.</p>


  <div class="infoSection">
    <table style="width: 100%; " cellspacing=0 cellpadding=5>
      <tr style="font-weight: bold;background: #ddd;">
        <td>Payment type</td>
        <td>Reference number</td>
        <td>Payment date</td>
        <td>Amount</td>
        <td>Applied To</td>
      </tr>

      <?php
        $i = 0;
        foreach ($recentPayments as $payment) {

          if($i & 1){
            $rowStyle = "background: #ddd;";
          } else {
            $rowStyle = "";
          }
          if(isset($payment['invoices'])){
          echo "<tr style='height: 45px; $rowStyle'><td>".$payment['payment_type']."</td><td>".$payment['reference_number']."</td><td>".date('m/d/Y', strtotime($payment['payment_time']))."</td>";
          echo "</td><td>$".number_format($payment['amount'],2)."</td><td>";
          $invoices ="";
          foreach($payment['invoices'] as $invoice){
            $invoices .= $invoice['doc_number'].", ";
          }
          echo substr($invoices,0,-2);

          echo "</td></tr>";
          }
          $i++;
        }
      ?>
    </table>
  </div>

</div>