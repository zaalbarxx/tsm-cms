<?php
require_once(__TSM_ROOT__."modules/registration/BackEnd/views/sidebar.view.php");
?>
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
						<td style='text-align:center;'><a href='' class='btn btn-primary'>Delete</a></td>
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