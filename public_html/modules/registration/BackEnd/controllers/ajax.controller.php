<?php
$currentCampus = new TSM_REGISTRATION_CAMPUS($reg->getCurrentCampusId());
switch ($ajax) {
  case "formSubmission":
    switch ($formAction) {
      case "saveFee":
        if ($currentCampus->saveFee($fee_id)) {
          $response = true;
          $redirect = "index.php?mod=registration&view=fees";
        } else {
          $response = false;
        }
        break;
      case "createFee":
        if ($currentCampus->createFee()) {
          $response = true;
          $redirect = "index.php?mod=registration&view=fees";
        } else {
          $response = false;
        }
        break;
      case "savePaymentPlan":
        if ($currentCampus->savePaymentPlan($payment_plan_id)) {
          $response = true;
          $redirect = "index.php?mod=registration&view=fees&action=paymentPlans";
        } else {
          $response = false;
        }
        break;
      case "createPaymentPlan":
        if ($currentCampus->createPaymentPlan()) {
          $response = true;
          $redirect = "index.php?mod=registration&view=fees&action=paymentPlans";
        } else {
          $response = false;
        }
        break;
    }
    if (isset($fb)) {
      echo $response;
    } else {
      echo $redirect;
    }
    break;
  case "deleteProgram":
    $program = new TSM_REGISTRATION_PROGRAM($programId);
    if ($program->delete()) {
      echo "1";
    } else {
      echo "0";
    }
    break;
  case "deleteCourse":
    $course = new TSM_REGISTRATION_COURSE($courseId);
    if ($course->delete()) {
      echo "1";
    } else {
      echo "0";
    }
    break;
  case "deleteFeeFromProgram":
    if (isset($program_id) && isset($fee_id)) {
      $program = new TSM_REGISTRATION_PROGRAM($program_id);
      $success = $program->deleteFee($fee_id);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The fee was successfully deleted from this program. However, if any students have already been approved, this fee will still apply to their account.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The fee could not be removed.";
      }

      echo json_encode($response);
    }
    break;
  case "deleteFeeFromCourse":
    if (isset($course_id) && isset($course_fee_id)) {
      $course = new TSM_REGISTRATION_COURSE($course_id);
      $success = $course->deleteFee($course_fee_id);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The fee was successfully deleted from this course. However, if any students have already been approved, this fee will still apply to their account.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The fee could not be removed.";
      }

      echo json_encode($response);
    }
    break;
  case "deleteFeeConditionFromProgram":
    if (isset($program_id) && isset($program_fee_condition_id)) {
      $program = new TSM_REGISTRATION_PROGRAM($program_id);
      $success = $program->deleteFeeCondition($program_fee_condition_id);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The condition was successfully removed from the fee.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The condition could not be removed.";
      }

      echo json_encode($response);
    }
    break;
  case "deleteFeeConditionFromCourse":
    if (isset($course_id) && isset($course_fee_condition_id)) {
      $course = new TSM_REGISTRATION_COURSE($course_id);
      $success = $course->deleteFeeCondition($course_fee_condition_id);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The condition was successfully removed from the fee.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The condition could not be removed.";
      }

      echo json_encode($response);
    }
    break;
  case "deletePeriodFromCourse":
    if (isset($course_id) && isset($course_period_id)) {
      $course = new TSM_REGISTRATION_COURSE($course_id);
      $success = $course->deletePeriod($course_period_id);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The period was successfully removed from the course.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The period could not be removed.";
      }

      echo json_encode($response);
    }
    break;
  case "deleteFee":
    if ($currentCampus->deleteFee($fee_id)) {
      echo true;
    } else {
      echo false;
    }
    break;
  case "removeCourseFromProgram":
    $program = new TSM_REGISTRATION_PROGRAM($program_id);
    $success = $program->removeCourse($course_id);

    $response = Array("success" => false, "alertMessage" => null);

    if ($success == true) {
      $response["success"] = true;
      $response["alertMessage"] = "The course was successfully removed from the program.";
    } else {
      $response["success"] = false;
      $response["alertMessage"] = "The course could not be removed.";
    }

    echo json_encode($response);

    break;
  case "deleteRequirementFromProgram":
    $program = new TSM_REGISTRATION_PROGRAM($program_id);
    $success = $program->removeRequirement($requirement_id);

    $response = Array("success" => false, "alertMessage" => null);

    if ($success == true) {
      $response["success"] = true;
      $response["alertMessage"] = "The requirement was successfully removed from the program.";
    } else {
      $response["success"] = false;
      $response["alertMessage"] = "The requirement could not be removed.";
    }

    echo json_encode($response);
    break;
  case "deleteRequirementFromCourse":
    $course = new TSM_REGISTRATION_COURSE($course_id);
    $success = $course->removeRequirement($course_requirement_id);

    $response = Array("success" => false, "alertMessage" => null);

    if ($success == true) {
      $response["success"] = true;
      $response["alertMessage"] = "The requirement was successfully removed from the course.";
    } else {
      $response["success"] = false;
      $response["alertMessage"] = "The requirement could not be removed.";
    }

    echo json_encode($response);
    break;
  case "unenrollStudentFromCourse":
    if (isset($course_id) && isset($student_id) && isset($program_id)) {
      $student = new TSM_REGISTRATION_STUDENT($student_id);
      $success = $student->unenrollFromCourse($course_id, $program_id);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The student has been successfully unenrolled from this course.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "There was an error unenrolling the student from this course.";
      }

      echo json_encode($response);
    }
    break;
  case "unenrollStudentFromProgram":
    if (isset($student_id) && isset($program_id)) {
      $student = new TSM_REGISTRATION_STUDENT($student_id);

      $success = $student->unenrollFromProgram($program_id);
      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The student has been successfully unenrolled from this program.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The student could not be unenrolled from this program. Please make sure they are not enrolled in any courses.";
      }

      echo json_encode($response);
    }
    break;
  case "changePeriodInCourse":
    if (isset($course_period_id) && isset($new_period_id) && isset($new_teacher_id)) {
      $course = new TSM_REGISTRATION_COURSE($course_id);
      if ($course->changePeriod($course_period_id, $new_period_id, $new_teacher_id)) {
        die("1");
      } else {
        die("2");
      }
    }
    break;
  case "changeStudentPeriodForCourse":
    if (isset($course_period_id) && isset($student_id) && isset($program_id) && isset($course_id) && isset($new_course_period_id)) {
      $student = new TSM_REGISTRATION_STUDENT($student_id);
      if ($student->changePeriodForCourse($course_id, $program_id, $course_period_id, $new_course_period_id)) {
        die("1");
      } else {
        die("2");
      }
    }
    break;
  case "approveFamilyPaymentPlan":
    if (isset($family_payment_plan_id)) {
      $familyPaymentPlan = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($family_payment_plan_id);
      $feesAdded = $familyPaymentPlan->addFees($feesToAdd);

      if($feesAdded){
        $success = $familyPaymentPlan->approve();
      } else {
        $success = false;
      }

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The payment plan was successfully approved.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The payment plan could not be approved.";
      }

      echo json_encode($response);
    }
    break;
  case "addFeesToFamilyPaymentPlan":
    if (isset($family_payment_plan_id) && isset($feesToAdd)) {
      $familyPaymentPlan = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($family_payment_plan_id);
      $success = $familyPaymentPlan->addFees($feesToAdd);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The payment plan was successfully approved.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The payment plan could not be approved.";
      }

      echo json_encode($response);
    }
    break;
  case "invoiceFeesToFamilyPaymentPlan":
    if (isset($family_payment_plan_id) && isset($feesToAdd)) {
      $familyPaymentPlan = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($family_payment_plan_id);
      $success = $familyPaymentPlan->invoiceSpecificFees($feesToAdd,$invoice_description);
      if($success){
        $familyPaymentPlan->addFees($feesToAdd);
      }


      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The payment plan was successfully approved.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The payment plan could not be approved.";
      }

      echo json_encode($response);
    }
    break;
  case "invoiceFees":
    if (isset($family_id) && isset($feesToAdd) && isset($invoice_description) && $invoice_description != "" && isset($due_date)) {
      $family = new TSM_REGISTRATION_FAMILY($family_id);
      foreach($feesToAdd as $family_fee_id){
        $familyFee = new TSM_REGISTRATION_FAMILY_FEE($family_fee_id);
        $familyFeeInfo = $familyFee->getInfo();

        $invoiceFees[] = $familyFeeInfo;
      }


      $success = $family->createInvoiceFromFees($invoiceFees,$invoice_description,"NULL",$due_date);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The payment plan was successfully approved.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The payment plan could not be approved.";
      }

      echo json_encode($response);
    }
    break;
  case "sendInvoiceEmail":
    if (isset($family_invoice_id) && isset($send_to) && isset($email_subject) && isset($email_contents)) {
      $invoice = new TSM_REGISTRATION_INVOICE($family_invoice_id);
      $email_contents = html_entity_decode($email_contents);
      $success = $invoice->emailInvoice($send_to,$email_contents,$email_subject);

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The invoice was successfully sent.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The invoice could not be sent.";
      }

      echo json_encode($response);
    }
    break;
  case "sendInvoices":
    if (isset($invoicesToSend) && isset($email_subject) && isset($email_contents)) {
      set_time_limit(0);
      ini_set('memory_limit', '256M');
      $email_contents = html_entity_decode($email_contents);
      $failed = false;
      foreach($invoicesToSend as $family_invoice_id){
        $invoice = new TSM_REGISTRATION_INVOICE($family_invoice_id);
        $invoiceInfo = $invoice->getInfo();
        $family = new TSM_REGISTRATION_FAMILY($invoiceInfo['family_id']);
        $familyInfo = $family->getInfo();

        $sent = $invoice->emailInvoice($familyInfo['primary_email'],$email_contents,$email_subject);
        //$sent = $invoice->emailInvoice("jlane@veritasproductions.net",$email_contents,$email_subject);
        if($sent == 0){
          $failed = 1;
        }
      }

      if($failed == 1){
        $success = false;
      } else {
        $success = true;
      }

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The invoice was successfully sent.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The invoice could not be sent.";
      }

      echo json_encode($response);
    }
    break;
  case "handleFees":

    if(isset($handleFees) && isset($family_id)){
      $family = new TSM_REGISTRATION_FAMILY($family_id);
      $family->handleFees($handleFees);
    }

    die("1");
    break;
  case "getHandleFeesView":
    if(isset($student_id) && isset($feesToHandle) && (isset($program_id) || isset($course_id))){
      $feesToHandle = explode(",",$feesToHandle);
      foreach($feesToHandle as $family_fee_id){
        $familyFee = new TSM_REGISTRATION_FAMILY_FEE($family_fee_id);

        $fees[$family_fee_id] = $familyFee->getInfo();
        $fees[$family_fee_id]["invoiced"] = $familyFee->isInvoiced();
        $fees[$family_fee_id]["onPaymentPlan"] = $familyFee->isOnPaymentPlan();
      }

      if(isset($course_id)){
        $actionUrl = "index.php?mod=registration&ajax=unenrollStudentFromCourse&student_id=".$student_id."&program_id=".$program_id."&course_id=".$course_id;
      } else {
        $actionUrl = "index.php?mod=registration&ajax=unenrollStudentFromProgram&student_id=".$student_id."&program_id=".$program_id;
      }
    ?>
    <div id="feesToHandle" class="modal hide fade" tabindex="-1" style="width: 800px; margin-left: -430px;" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 id="myModalLabel">Fee Adjustments</h3>
      </div>
      <div class="modal-body">
        <form id="handleFeesForm" class="form-horizontal" method="post" action="<?php echo $actionUrl; ?>">

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
            if (isset($fees)) {
              foreach ($fees as $fee) {

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
            <?php } ?>
          </table>

        <br /><br >
        <span class="right">
          <a href="" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">Cancel</a>
          <input class="btn btn-primary" type="submit" value="Remove From Program" />
        </span>
        </form>
      </div>
    </div>
      <script type="text/javascript">
        $("#handleFeesForm").submit( function(){
          var conf = confirm("Are you sure you want to remove the student from this program or course?");
          if(conf){
            var data = $(this).serialize();
            $.post($(this).attr("action"),data,function(data){
              var response = JSON.parse(data);
              if(response.success == true){
                alert(response.alertMessage);
                window.location.reload();
              } else {
                alert(response.alertMessage);
              }
            });
          }
          return false;
        });
      </script>
    <?php
    }
    break;
  case "bulkAssignFeeToStudents":
    if (isset($fee_id) && isset($assignTo)) {
      foreach($assignTo as $student_id){
        $student = new TSM_REGISTRATION_STUDENT($student_id);
        $student->assignFee($fee_id);
      }

      $success = true;

      $response = Array("success" => false, "alertMessage" => null);

      if ($success == true) {
        $response["success"] = true;
        $response["alertMessage"] = "The fee was successfully assigned to the selected students.";
      } else {
        $response["success"] = false;
        $response["alertMessage"] = "The fee could not be assigned.";
      }

      echo json_encode($response);
    }
    break;
  case "bulkFeeInvoice":
    if (isset($invoiceFamily) && $invoice_description != "" && $due_date != "") {
      foreach($invoiceFamily as $familyToInvoice=>$fees){
        $family = new TSM_REGISTRATION_FAMILY($familyToInvoice);
        $invoice_id = $family->createInvoice(null,$invoice_description,$due_date);
        $invoice = new TSM_REGISTRATION_INVOICE($invoice_id);
        foreach($fees as $family_fee_id){
          $familyFee = new TSM_REGISTRATION_FAMILY_FEE($family_fee_id);
          $familyFeeInfo = $familyFee->getInfo();
          $params = Array("family_fee_id"=>$family_fee_id,"description"=>$familyFeeInfo['name'],"amount"=>$familyFeeInfo['amount']);
          $invoice->addFee($params);
        }
        $invoice->updateTotal();
      }
      $success = true;
    } else {

    }


    $response = Array("success" => false, "alertMessage" => null);

    if ($success == true) {
      $response["success"] = true;
      $response["alertMessage"] = "The fee was successfully assigned to the selected students.";
    } else {
      $response["success"] = false;
      $response["alertMessage"] = "The fee could not be assigned.";
    }

    echo json_encode($response);
    break;
  case "markInvoicesAsSent":
    if(isset($familyInvoices)){
      foreach($familyInvoices as $family_invoice_id){
        $familyInvoice = new TSM_REGISTRATION_INVOICE($family_invoice_id);
        $familyInvoice->markAsSent();
      }
      $success = true;
    } else {
      $success = false;
    }

    $response = Array("success" => false, "alertMessage" => null);

    if ($success == true) {
      $response["success"] = true;
      $response["alertMessage"] = "The invoices were successfully marked as sent.";
    } else {
      $response["success"] = false;
      $response["alertMessage"] = "The invoices could not be marked as sent.";
    }

    echo json_encode($response);
    break;
    case "deleteFeeFromInvoice":
    if(isset($invoiceId) && isset($feeId)){
      $invoice = new TSM_REGISTRATION_INVOICE($invoiceId);
      $invoice->deleteFee($feeId);
      $invoice->updateTotal();
      $total = $invoice->addFees($invoice->getFees());
      $response['total'] = $total;
      $response["success"] = true;
      $response["alertMessage"] = "The invoice fee was successfully deleted.";
    }else{
      $response["success"] = false;
      $response["alertMessage"] = "The invoice fee could not be deleted";
    }
    echo json_encode($response);
    break;

    case "deleteInvoice":
    if(isset($invoiceId)){
      $invoice = new TSM_REGISTRATION_INVOICE($invoiceId);
      if($invoice->deleteInvoice() == true){
        $response['success'] = true;
        $response['alertMessage'] = 'Invoice has been successfully deleted.';
      }
      else{
        $response['success'] = false;
        $response['alertMessage'] = 'Error was encountered when deleting an invoice.';
      }

    }
    else{
      $response["success"] = false;
      $response['alertMessage'] = 'Invoice id was not provided.';
    }
    echo json_encode($response);
    break;
    case 'changePaymentPlan':
      if(isset($familyPaymentPlanId) && isset($paymentPlanId)){
        $paymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($familyPaymentPlanId);
        $paymentPlanObject->changeToPaymentPlan($paymentPlanId);
        
        $paymentPlanObject = null;
        $paymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($familyPaymentPlanId);
        $info = $paymentPlanObject->getInfo();
        
        $response['success'] = true;
        $response['paymentPlanName'] = $info['name'];
        $response['paymentPlanId'] = $info['payment_plan_id'];
        $response['alertMessage'] = 'Payment plan has been changed.';
      }
      else{
        $response['success'] = false;
        $response['alertMessage'] = 'Error encountered when trying to change plan.';
      }
      echo json_encode($response);
    break;
  case 'getCreditsForPaymentPlan':
    if(isset($paymentPlanId)){
      $paymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($paymentPlanId);
      $fees = $paymentPlanObject->getCredits();
      $response['success'] = true;
      $response['data'] = ($fees!=null) ? $fees : array();
    }
    else{
      $response['success'] = false;
    }
    echo json_encode($response);
  break;
  case 'addCreditToPaymentPlan':
    if(isset($paymentPlanId) && isset($title) && isset($amount) && isset($familyId)){
      $paymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($paymentPlanId);
      if($id = $paymentPlanObject->addNewCredit($familyId,$title,$amount)){
        $total = $paymentPlanObject->getTotal();
        $due = $paymentPlanObject->getAmountDue();
        $response['success'] = true;
        $response['id'] = $id;
        $response['total'] = $total;
        $response['due'] = number_format($due,2);
      }
      else{
        $response['success'] = false;
      }
    }
    else{
      $response['success'] = false;
    }
    echo json_encode($response);
  break;

  case 'removeCreditFromPaymentPlan':
    if(isset($creditId) && isset($paymentPlanId)){
      $paymentPlanObject = new TSM_REGISTRATION_FAMILY_PAYMENT_PLAN($paymentPlanId);
      if($paymentPlanObject->deleteCredit($creditId) == true){
        $total = $paymentPlanObject->getTotal();
        $due = $paymentPlanObject->getAmountDue();
        $response['success'] = true;
        $response['total'] = $total;
        $response['due'] = number_format($due,2);
      }
      else{
        $response['success'] = false;
      }
    }
    else{
      $response['success'] = false;
    }
    echo json_encode($response);
  break;
  case 'getUninvoicedFees':
    if(isset($family_id)){
      $family = new TSM_REGISTRATION_FAMILY($family_id);
      $fees = $family->getFees();
      if(!count($fees)>0){
        $fees = array();
      }
      $results = array();
      foreach($fees as $fee){
        $f = new TSM_REGISTRATION_FAMILY_FEE($fee['family_fee_id']);
        if(!$f->isInvoiced()){
          $f = $f->getInfo();
          $results[] = array(
              'id' => $f['family_fee_id'],
              'description' => $f['name'],
              'amount' => $f['amount']
            );
        }
      }
      $response['success'] = true;
      $response['data'] = $results;
    }
    else{
      $response['success'] = false;
    }
    echo json_encode($response);
    break;
    case 'addUninvoicedFee':
    if(isset($fee_id) && isset($invoice_id)){
      $invoice = new TSM_REGISTRATION_INVOICE($invoice_id);
      if($inv = $invoice->addUninvoicedFee($fee_id)){
        $response['success'] = true;
        $response['data']['invoice'] = $inv;
        $response['data']['total'] = $invoice->getTotal();        
      }
      else{
        $response['success'] = false;
      }
    }
    else{
      $response['success'] = false;
    }
    echo json_encode($response);
    break;
}
die();
?>