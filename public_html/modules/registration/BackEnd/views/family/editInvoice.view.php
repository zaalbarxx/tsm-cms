<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
<script>
invoice_id = <?php echo $invoice_id ?>;
$(document).ready(function(){
	$('button.delete').on('click',function(e){
		var fee_id = $(this).attr('data-id');
		var row = $(this).parent().parent();
		e.preventDefault();
		$.get('index.php?mod=registration&ajax=deleteFeeFromInvoice&invoiceId='+invoice_id+'&feeId='+fee_id,function(data){
			var response = JSON.parse(data);
			if (response.success == true) {
       			$(row).remove();
     		}
      		if (response.alertMessage != null) {
        		alert(response.alertMessage);
     		 }
		});
	});

});

</script>
<div class="span9">
	<table style="width: 100%;" class="table table-striped table-bordered ">
		<thead>
			<tr>
				<td>Ref. no.</td>
				<td>Description</td>
				<td>Ammount</td>
				<td></td>
				<td></td>
			</tr>
		</thead>
		<tbody>

			<?php	
				foreach($fees as $fee){
					echo 
					"<tr>
						<td>".$fee['ref_no']."</td>
						<td>".$fee['description']."</td>
						<td>$ ".$fee['ammount']."</td>
						<td style='text-align:center;'><a href='' class='btn btn-primary'>Edit</a></td>
						<td style='text-align:center;'><button data-id='".$fee['ref_no']."' class='btn btn-primary delete'>Delete</button></td>
					</tr>";
				}

			?>
		</tbody>
		<tfoot>
			<tr>
				<td></td>
				<td></td>
				<td>$ <?php echo $fee_total ?></td>
				<td></td>
				<td></td>
			</tr>
		</tfoot>

	</table>

	</table>
</div>