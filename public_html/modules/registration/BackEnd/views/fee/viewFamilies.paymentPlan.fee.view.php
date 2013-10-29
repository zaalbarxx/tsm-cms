<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<div class="span9">
	<h2><?php echo $paymentPlanInfo['name']; ?> Families</h2>
	<?php
	if(isset($familyPaymentPlans)){
		foreach($familyPaymentPlans as $paymentPlan){
			$family = $families[$paymentPlan['family_id']];
			?>
			<div class="smallItem well well-small">
				<a href="index.php?mod=registration&view=family&action=viewFamily&family_id=<?php echo $family['family_id']; ?>"
				   class="title"><?php echo $family['family_name']; ?> Family <?php echo $family['status']; ?></a>
				<?php
				if($paymentPlan['status'] == "Pending Approval"){
				echo "<a class='btn btn-success btn-mini fb' href='index.php?mod=registration&view=family&action=approvePaymentPlan&familyPaymentPlanId=".$paymentPlan['family_payment_plan_id']."'>Approve</a>";
				} else if ($paymentPlan['moreFeesAvailible'] && $paymentPlan['canAddFees']){
				echo "<a class='btn btn-success btn-mini fb' href='index.php?mod=registration&view=family&action=addFeesToPaymentPlan&familyPaymentPlanId=".$paymentPlan['family_payment_plan_id']."'>Add Fees</a>";
				//echo " | <a class='btn btn-success btn-mini fb' href='index.php?mod=registration&view=family&action=invoiceFeesToPaymentPlan&familyPaymentPlanId=".$paymentPlan['family_payment_plan_id']."'>Invoice All</a>";
				}
				?>
				<span class="buttons">
					<a
						href="index.php?mod=registration&view=family&action=viewFamily&family_id=<?php echo $family['family_id']; ?>"
						class="reviewButton" title="Review This Family"></a>
	            </span>
			</div>
		<?php
		}
	}
	?>
</div>