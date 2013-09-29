<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>

<script>
invoice_id = <?php echo $invoice_id ?>;
$(document).ready(function(){
	$('#feesInfo').on('click','.delete',function(e){
		e.preventDefault();
		var fee_id = $(this).attr('data-id');
		var row = $(this).parent().parent();
		var c = confirm('Are you sure you want to delete this invoice?');
		if(c){
			$.get('index.php?mod=registration&ajax=deleteFeeFromInvoice&invoiceId='+invoice_id+'&feeId='+fee_id,function(data){
				var response = JSON.parse(data);
				if (response.success == true) {
       				$(row).remove();
       				$('tfoot td.total').html('$ '+response.total);
     			}
      			if (response.alertMessage != null) {
        			alert(response.alertMessage);
     		 	}
		});
		}

	});

});

</script>
<div class="span9">
	<ul class="nav nav-tabs">
    	<li class="active"><a href="#feesInfo" data-toggle="tab">Fees</a></li>
    	<li><a href="#invoice_dates" data-toggle="tab">Invoice dates</a></li>
	</ul>

	<div class="tab-content">
    	<div class="infoSection well clearfix tab-pane active" id="feesInfo">
			<h3>Invoice fees</h3>
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
				<?php if(count($fees_temp)>0){ ?>
				<tfoot>
					<tr>
						<td></td>
						<td></td>
						<td class='total'>$ <?php echo $fee_total ?></td>
						<td></td>
						<td></td>
					</tr>
				</tfoot>
				<?php } ?>
			</table>
			<button class='btn btn-primary' data-action='addUninvoicedFee'>Add uninvoiced fee</button>
		</div>

    	<div class="infoSection well tab-pane" id="invoice_dates">
			<h3>Invoice dates</h3>
			<div class="smallItem well well-small">
				<form method='POST' action="index.php?mod=registration&view=family&action=editInvoice&family_invoice_id=<?php echo $family_invoice_id; ?>&editTime=1>">
					<label for='invoice_date'>Invoice date:</label>
					<div id='datetimepicker' class='input-append date'>
						<input data-format='yyyy-MM-dd hh:mm:ss' type='text' name='invoice_date' value="<?php echo $invoice_info['invoice_date'];?>">
						<span class='add-on'>
							<i data-time-icon='icon-time' data-time-icon='icon-calendar'></i>
						</span>
					</div>

					<label for='due_date'>Due date:</label>
					<div id='datetimepicker2' class='input-append date'>
						<input data-format='yyyy-MM-dd' type='text' name='due_date' value="<?php echo $invoice_info['due_date'];?>">
						<span class='add-on'>
							<i data-time-icon='icon-time' data-time-icon='icon-calendar'></i>
						</span>
					</div>

					<br>

					<input type='submit' class='btn btn-primary' value='Edit'>
				</form>
    		</div>
		</div>
	</div>
</div>

<div id="modalAddUninvoicedFee" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
   <h3 id="myModalLabel">Add uninvoiced fee to this invoice.</h3>
  </div>
  <div class="modal-body">
	<table class='table table-bordered'>
		<thead>
			<tr>
				<td>ID</td>
				<td>Fee description</td>
				<td>Amount</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" data-toggle='modal' aria-hidden="true">Back</button>
  </div>
</div>
<script>
	$(document).ready(function(){
		$('button[data-action=addUninvoicedFee]').on('click',function(){
			$.ajax('index.php?mod=registration&ajax=getUninvoicedFees&family_id='+<?php echo $family_id?>).done(function(data){
				data = $.parseJSON(data);
				modalTable = $('#modalAddUninvoicedFee table tbody');
				modalTable.empty();
				for(i=0;i<data.data.length;i++){
					modalTable.append('<tr><td>'+data.data[i].id+'</td><td>'+data.data[i].description+'</td><td>'+data.data[i].amount+'</td><td><button data-id="'+data.data[i].id+'" class="btn btn-success confirm">Add</button></td></tr>');
				}
				$('#modalAddUninvoicedFee button.confirm').on('click',function(){
					$.ajax({
						url:'index.php?mod=registration&ajax=addUninvoicedFee&invoice_id=<?php echo $invoice_id?>&fee_id='+ $(this).attr('data-id')
					}).done(function(data){
						var data = $.parseJSON(data);
						if(data.success == true){
							$('#feesInfo tbody').append('<tr><td>'+data.data.invoice.id+'</td><td>'+data.data.invoice.description+'</td><td>$ '+data.data.invoice.amount+'</td><td style="text-align:center;"><a href="" class="btn btn-primary">Edit</a></td><td style="text-align:center;"><button data-id='+data.data.invoice.id+' class="btn btn-primary delete">Delete</button></td></tr>');
							$('#feesInfo td.total').html('$ '+data.data.total);
						}
						else{
							alert('Unexpected error. Try again');
						}
						$('#modalAddUninvoicedFee').modal('hide');
					});

				})
				$('#modalAddUninvoicedFee').modal('show');
			});
		});




			$('#datetimepicker').datetimepicker({
				language:'en',
				weekStart:1
			});
			$('#datetimepicker2').datetimepicker({
				language:'en',
				weekStart:1,
				pickTime:false
			})
	});
</script>