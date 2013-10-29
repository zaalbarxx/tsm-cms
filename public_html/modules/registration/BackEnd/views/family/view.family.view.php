<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
    <h1><?php echo $pageTitle; ?> Family - <a
            href="index.php?mod=registration&view=family&action=addEditFamily&family_id=<?php echo $familyInfo['family_id']; ?>"
            class="editButton" title="Edit Family"></a></h1>

    <ul class="nav nav-tabs">
      <li class="active"><a href="#familyInfo" data-toggle="tab">Home</a></li>
      <li><a href="#students" data-toggle="tab">Students</a></li>
      <li><a href="#paymentPlans" data-toggle="tab">Payment Plans</a></li>
      <li><a href="#invoices" data-toggle="tab">Invoices</a></li>
	    <?php if(isset($looseFees)){ ?>
      <li><a href="#unassignedFees" data-toggle="tab">Unassigned Fees</a></li>
      <li><a href="#fees" data-toggle="tab">Fees</a></li>
			<?php } ?>
      <?php if(isset($feesNeedingReview)){
      ?><li><a href="#feesToReview" data-toggle="tab">Fees in Review</a></li><?php
      } ?>
      <li><a href="#studentLog" data-toggle="tab">Student Log</a></li>
    </ul>

    <div class="tab-content">
    <div class="infoSection well clearfix tab-pane active" id="familyInfo">
        <h3>Family Information</h3>

				<div class="half">
					<strong>Father:</strong> <?php echo $familyInfo['father_first']." ".$familyInfo['father_last']; ?>
					<br/>
					<strong>Father's Cell:</strong> <?php echo $familyInfo['father_cell']; ?>
					<br/>
					<strong>Mother:</strong> <?php echo $familyInfo['mother_first']." ".$familyInfo['mother_last']; ?>
					<br/>
					<strong>Mother's Cell:</strong> <?php echo $familyInfo['mother_cell']; ?>
					<br/>
					<strong>Primary E-mail:</strong> <?php echo $familyInfo['primary_email']; ?><br/>
					<strong>Seconary E-mail:</strong> <?php echo $familyInfo['secondary_email']; ?>
				</div>
        <div class="half">
	        <strong>Primary Phone:</strong> <?php echo $familyInfo['primary_phone']; ?><br/>
	        <strong>Seconary Phone:</strong> <?php echo $familyInfo['secondary_secondary']; ?>
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
                <a class='btn btn-danger deactivateFamily' href='index.php?mod=registration&view=family&action=addEditFamily&family_id=<?php echo $familyInfo['family_id'];?>&deactivateFamily=1'>Deactivate</a>
            </div>
        </div>
    </div>
    <div class="infoSection well clearfix tab-pane" id="students">
        <h2>Students - <a href="index.php?mod=registration&view=student&action=addEditStudent&family_id=<?php echo $familyInfo['family_id']; ?>" class="btn btn-primary fb">Add Student</a></h2>
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
    <div class="infoSection well tab-pane" id="paymentPlans">
      <h2>Payment Plans</h2>
      <table style="width: 100%;" class="table table-striped table-bordered" data-id='payment-plans'>
        <tr style="font-weight: bold;">
          <td>ID</td>
          <td>Description</td>
          <!--<td>Fee Types</td>-->
          <td>Total</td>
          <td>Amt Paid</td>
          <td>Amt Invoiced</td>
          <td>Amt Due</td>
          <td>Status</td>
          <td></td>
          <td></td>
        </tr>
        <?php
        if(isset($paymentPlans)){
          foreach($paymentPlans as $paymentPlan){
            echo "<tr data-id=".$paymentPlan['family_payment_plan_id'].">
            <td>".$paymentPlan['family_payment_plan_id']."</td>
            <td class='payment-plan-name'>".$paymentPlan['name']."</td>
            <!--<td>".$paymentPlan['fee_type_names']."</td>-->
            <td data-id='total'>$".$paymentPlan['totalAmount']."</td>
            <td>$".$paymentPlan['amountPaid']."</td>
            <td>$".$paymentPlan['amountInvoiced']."</td>
            <td data-id='due'>$".$paymentPlan['amountDue']."</td>
            <td>".$paymentPlan['status'];
            if($paymentPlan['status'] == "Pending Approval"){
              echo " - <a class='btn btn-success btn-mini fb' href='index.php?mod=registration&view=family&action=approvePaymentPlan&familyPaymentPlanId=".$paymentPlan['family_payment_plan_id']."'>Approve</a>";
            } else if ($paymentPlan['moreFeesAvailible'] && $paymentPlan['canAddFees']){
              echo " - <a class='btn btn-success btn-mini fb' href='index.php?mod=registration&view=family&action=addFeesToPaymentPlan&familyPaymentPlanId=".$paymentPlan['family_payment_plan_id']."'>Add Fees</a>";
              //echo " | <a class='btn btn-success btn-mini fb' href='index.php?mod=registration&view=family&action=invoiceFeesToPaymentPlan&familyPaymentPlanId=".$paymentPlan['family_payment_plan_id']."'>Invoice All</a>";
            }
            echo "</td>";
            echo "<td data-family-payment-id='".$paymentPlan['family_payment_plan_id']."' data-id='".$paymentPlan['payment_plan_id']."'><a href='#modalChangePayment' data-action='changePaymentPlan' class='btn btn-primary'>Change plan</a></td>";
            echo "<td data-family-payment-id='".$paymentPlan['family_payment_plan_id']."' data-id='".$paymentPlan['payment_plan_id']."'><a href='#modalManageCredit' data-action='manageCredit' class='btn btn-primary'>Manage credit</a></td>";
            echo "</tr>";
          }
        }

        ?>
      </table>

    </div>
    <div class="infoSection well tab-pane" id="invoices">
        <h2>Recent Invoices</h2>
        <table style="width: 100%;" class="table table-striped table-bordered ">
            <tr style="font-weight: bold;">
                <td>Invoice</td>
                <td>Description</td>
                <td>Date</td>
                <td>Sent</td>
                <td>Total</td>
                <td>Amount Paid</td>
                <td>Amount Due</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>

          <?php
          if (isset($invoices)) {
            foreach ($invoices as $invoice) {
              echo "<tr><td>".$invoice['doc_number']."</td><td>".$invoice['invoice_description']."</td><td>".date('m/d/Y', strtotime($invoice['invoice_time']))."</td><td>".$invoice['timesSent']."</td><td>$".$invoice['amount']."</td><td>$".$invoice['amountPaid']."</td><td>$".$invoice['amountDue']."</td>";
              
              echo "<td><a href='index.php?mod=registration&view=invoice&action=viewPDF&family_invoice_id=".$invoice['family_invoice_id']."' class='btn btn-primary'>View</a></td>";

              echo "<td><a href='index.php?mod=registration&view=family&action=editInvoice&family_invoice_id=".$invoice['family_invoice_id']."' class='btn btn-primary'>Edit</a></td>";
             
              if($invoice['displayed'] == 1){
                echo "<td><a href='index.php?mod=registration&view=family&action=emailInvoice&family_invoice_id=".$invoice['family_invoice_id']."' class='btn btn-primary fb'>Email</a></td>";
              } else {
                echo "<td></td>";
              }
              echo "<td><a data-id='".$invoice['family_invoice_id']."' class='btn btn-primary delete-invoice' href='#'>Delete</a></td>";
              echo "</tr>";
            }
          } else {
            echo "<tr class='warning'><td colspan=7>There are no recent invoices for this family.</td></tr>";
          }
          ?>
        </table>
    </div>
  <?php if (isset($looseFees)) { ?>
  <div class="infoSection well tab-pane" id="unassignedFees">
    <h2>Unassigned Fees</h2>
    <p>This family has fees that have not been invoiced and are not assigned to a payment plan. They are listed below.</p>
    <div class="btn-group center">
      <!--<a class="btn" href="">Assign to Payment Plan</a>-->
      <a class="btn fb" href="index.php?mod=registration&view=family&action=invoiceFees&family_id=<?php echo $family_id; ?>">Invoice Now</a>
    </div>
    <br /><br />
    <table style="width: 100%;" class="table table-striped table-bordered ">
      <tr style="font-weight: bold;">
        <td>ID</td>
        <td>Description</td>
        <td>Amount</td>
      </tr>
    <?php
      foreach ($looseFees as $fee) {
        echo "<tr><td>".$fee['family_fee_id']."</td><td>".$fee['name']."</td><td>$".$fee['amount']."</td></tr>";
      }
    ?>
    </table>
  </div>
  <?php } ?>

  <?php if(isset($feesNeedingReview)){ ?>
    <div class="infoSection well tab-pane" id="feesToReview">
      <h2>Fees to Review</h2>
      <p>The following fees need attention.</p>
      <form id="handleFeesForm" class="form-horizontal" method="post" action="index.php?mod=registration&ajax=handleFees&family_id=<?php echo $family_id; ?>">
        <table class="table table-striped">
          <caption>Please specify what you would like to do with the fees below.</caption>
          <tr>
            <th>Fee</th>
            <th>Amount</th>
            <th>Invoiced</th>
            <th>On Payment Plan</th>
            <th></th>
          </tr>
          <?php
            foreach ($feesNeedingReview as $fee) {

              ?>
              <tr><td>
                <?php echo $fee['name']; ?>
              </td>
              <td>$<?php echo $fee['amount']; ?></td>
              <td><?php if($fee['invoiced'] == 1){ echo "Yes"; } else { echo "No"; }; ?></td>
              <td><?php if($fee['onPaymentPlan'] == 1){ echo "Yes"; } else { echo "No"; }; ?></td>
              <td>
                <select name="handleFees[<?php echo $fee['family_fee_id']; ?>][handleMethod]">
                  <option value="1">Remove from invoices and payment plan.</option>
                  <option value="2">Non-refundable.</option>
                </select>

              </td>
            <?php
            } ?>
            </tr>
        </table>
        <span class="right">
          <input class="btn btn-primary" type="submit" value="Mark as Reviewed" />
        </span>
        <br />
      </form>
      <script type="text/javascript">
        $("#handleFeesForm").submit( function(){
          var data = $(this).serialize();
          $.post($(this).attr('action'),data,function(data){
            if(data == 1){
              alert("The fees were successfully reviewed");
              window.location.reload();
            } else {
              alert("There was a problem");
            }
          });
          return false;
        });
      </script>
    </div>
  <?php } ?>

    <div class="infoSection well tab-pane" id="fees">
      <h2>Fees</h2>
      <table style="width: 100%;" class="table table-striped table-bordered" data-id='payment-plans'>
        <tr style="font-weight: bold;">
          <td>ID</td>
          <td>Description</td>
          <td>Amount</td>
          <td></td>
          <td></td>
        </tr>
        <tbody>
        <?php foreach($fees as $fee){
          echo '<tr>';

          echo '<td>'.$fee['family_fee_id'].'</td><td>'.$fee['name'].'</td><td>'.$fee['amount'].'</td>';

          echo '<td style="text-align:center;"><a href="#"><button class="btn btn-primary">Edit</button></a></td><td style="text-align:center;"><a href="#"><button class="btn btn-danger">Delete</button></a></td>';

          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
    </div>
    <div class="infoSection well tab-pane" id="studentLog">
      <h2>Student Logs</h2>
      <?php if(isset($students)){
      foreach($students as $student){

        if(isset($student['student_log'])){
          echo "<h3>".$student['first_name']." ".$student['last_name']."</h3>";
          echo "<table  class=\"table table-striped\"><tr><th>Message</th><th>Time Logged</th></tr>";
          foreach($student['student_log'] as $log){
            echo "<tr><td>";
            if($log['add_remove'] == 0){
              $message = "Unenrolled from ";
            } else {
              $message = "Enrolled in ";
            }
            $program = $currentCampus->getProgramById($log['program_id']);
            if($log['course_id'] != ""){
              $course = $currentCampus->getCourseById($log['course_id']);
              $message .= $program['name'].": ".$course['name'];
            } else {
              $message .= $program['name'];
            }
            echo $message."</td><td>";
            echo $log['time_logged']."</td></tr>";
          }
          echo "</table>";
        }

      }

} ?>
    </div>
    </div>

<div id="modalManageCredit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
   <h3 id="myModalLabel">Manage credits for payment plan</h3>
  </div>
  <div class="modal-body">
          <table class="table table-striped">
          <thead>
            <tr>
              <th>Credit id</th>
              <th>Title</th>
              <th>Amount</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class='btn btn-success' data-target='#modalAddCredit'>Add credit</button>
  </div>
</div>

<div id="modalAddCredit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
   <h3 id="myModalLabel">Add credit for payment plan</h3>
  </div>
  <div class="modal-body">
    <form action="" class="form-horizontal" data-action='AddCredit'>
      <fieldset>
        <div class="control-group">
          <label for="" class="control-label">Title:</label><input type="text" name='title'>
      </div>
        <div class="control-group">
          <label for="" class="control-label">Amount:</label><input type="text" name='amount'>
      </div>
      </fieldset>
      
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" data-toggle='modal' data-target='#modalManageCredit' aria-hidden="true">Back</button>
    <button data-action='addCredit' class='btn btn-success'>Save credit</button>
  </div>
</div>


<div id="modalChangePayment" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
<h3 id="myModalLabel">Change payment plan</h3>
</div>
<div class="modal-body text-center">
  <span>Changing a payment plan will delete all invoices for the current plan and the invoices for the chosen plan will be re-created. You will need to re-assign any payments that have already been made for this plan to the new invoices.</span>
  <div class='error' style='color:red;'></div>
<select>
  <?php 
  foreach($currentCampus->getPaymentPlans() as $plan){
    echo "<option data-id='".$plan['payment_plan_id']."'>".$plan['name']."</option>";
  }
  ?>
</select>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button data-action='savePaymentPlan' class="btn btn-primary">Save changes</button>
</div>
</div>

</div>
<script type="text/javascript">





    $(".bigItem .title").click(function () {
        $(this).parent().children(".itemDetails").slideToggle();
    });
    $(document).ready(function(){
      var paymentPlanId=null;
      var familyPaymentPlanId=null;
      var familyId = <?php echo $familyInfo['family_id'];?>
      //---------------------------------------------------------------------
      //Block for managing credits
      //handler for clicking Add credit
      $('#modalManageCredit button[data-target=#modalAddCredit]').on('click',function(){
        $('#modalManageCredit').modal('toggle');
        $('#modalAddCredit form[data-action=AddCredit]')[0].reset();
        $('#modalAddCredit').modal();
      });
      //--------------------------------------------------------------------
      //handler for saving credit
      //--------------------------------------------------------------------
      $('#modalAddCredit button[data-action=addCredit]').on('click',function(event){
        console.log('hi');
        event.preventDefault();
        var data = $('#modalAddCredit form[data-action=AddCredit]').serializeArray();
        var title;
        var amount;
        var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
        console.log(data);
        for(i=0;i<data.length;i++){
          if(data[i].name =='title'){
            title = data[i].value;
          }
          else{
            amount = data[i].value;
          }
        }
        if(!floatRegex.test(amount)){
          alert('Please,enter correct ammount.');
        }
        else{
          $.ajax({
            url:'index.php?mod=registration&ajax=addCreditToPaymentPlan',
            type:'POST',
            data:{paymentPlanId:paymentPlanId,familyId:familyId,title:title,amount:amount}
          }).done(function(data){
              data = $.parseJSON(data);
              $('#modalAddCredit').modal('toggle');
              $('table[data-id=payment-plans] tr[data-id='+paymentPlanId+'] td[data-id=total]').html('$'+data.total);
              $('table[data-id=payment-plans] tr[data-id='+paymentPlanId+'] td[data-id=due]').html('$'+data.due);
            if(data.success != true){
              alert('There was a problem with adding a credit. Try again.');
            }
          });
        }
      })
      //---------------------------------
      //Handler for showing credit modal
      $('a[data-action=manageCredit]').on('click',function(){
        $('#modalManageCredit table tbody').empty();
        paymentPlanId = $(this).parent().attr('data-family-payment-id');
                $.ajax({
          url:'index.php?mod=registration&ajax=getCreditsForPaymentPlan',
          type:'POST',
          data:{paymentPlanId:paymentPlanId}
        }).done(function(data){
          data = $.parseJSON(data);
          if(data.success == true){
            var a = $('#modalManageCredit div.modal-body table');
            for(i=0;i<data.data.length;i++){
              a.children('tbody').append('<tr data-id="'+data.data[i].id+'"><td>'+data.data[i].id+'</td><td>'+data.data[i].name+'</td><td>$'+data.data[i].amount+'</td><td><button class="btn btn-danger" data-id="'+data.data[i].id+'">Delete</button></tr>');
              //on clicking remove button
              $('#modalManageCredit button[data-id='+data.data[i].id+']').on('click',function(){
                id = $(this).attr('data-id');
                $.ajax({
                  url:'index.php?mod=registration&ajax=removeCreditFromPaymentPlan',
                  type:'POST',
                  data:{creditId:id,paymentPlanId:paymentPlanId}
                }).done(function(data){
                  data = $.parseJSON(data);
                  if(data.success == true){
                    $('#modalManageCredit tr[data-id='+id+']').remove();
                    $('table[data-id=payment-plans] tr[data-id='+paymentPlanId+'] td[data-id=total]').html('$'+data.total);
                    $('table[data-id=payment-plans] tr[data-id='+paymentPlanId+'] td[data-id=due]').html('$'+data.due);
                  }
                  else{
                    alert('Could not delete credit. Try again.');
                  }
                })
              });
            }
          }
          else{
            alert('Could not receive a list of credits for this payment plan. Try again.');
            return;
          }
          $('#modalManageCredit').modal('toggle');
        });
        
      })

      //--------------------------------------------------------------------------------
      //on button click save some data and show modal
      $('a[data-action=changePaymentPlan]').on('click',function(){
        paymentPlanId = $(this).parent().attr('data-id');
        familyPaymentPlanId = $(this).parent().attr('data-family-payment-id');
        $('#modalChangePayment option').removeAttr('selected');
        $('#modalChangePayment option[data-id='+paymentPlanId+']').attr('selected',true);
        $('#modalChangePayment').modal('show');
      });

      //on save button from modal change if plan is different than current one then change payment plan and visually change it
      $('button[data-action=savePaymentPlan]').on('click',function(){
        selected_id = $('#modalChangePayment select').find(":selected").attr('data-id');
        if(selected_id!=paymentPlanId){
          $.get('index.php?mod=registration&ajax=changePaymentPlan&familyPaymentPlanId='+familyPaymentPlanId+'&paymentPlanId='+selected_id).done(function(data){
            var d = $.parseJSON(data);
            if(d.success){
              //change attributes in cells after getting JSON
              $('td[data-family-payment-id='+familyPaymentPlanId+']').attr('data-id',d.paymentPlanId);
              $('td[data-family-payment-id='+familyPaymentPlanId+']').parent().children('.payment-plan-name').html(d.paymentPlanName);
            }
            $('#modalChangePayment').modal('hide');
            alert(d.alertMessage);
          });
        }
        else{
          $('#modalChangePayment div.error').html('Selected payment plan is same as currently set.');
        }
      });



      $('.delete-invoice').on('click',function(){
        var confirmed = confirm('Are you sure you want to delete this invoice ?');
        if(confirmed){
          var id = $(this).attr('data-id');
          var row = $(this).parent().parent();
          $.get('index.php?mod=registration&ajax=deleteInvoice&invoiceId='+id).done(function(data){
            var response = $.parseJSON(data);
            if(response.success==true){
              alert(response.alertMessage);
              row.remove();
            }
            else{
              alert('Error was encountered when trying to delete invoice.');
            }
          }); 
        }
      });
      $('.deactivateFamily').on('click',function(){
        var confirm = window.confirm('"Are you sure you want to deactivate this family? This will unenroll the students from all courses and programs. Before continuing, you should review the families invoices and delete any that should not remain in Quickbooks.');
        if(confirm){
          return true;
        }
        else{
          return false;
        }
      });
    });
</script>