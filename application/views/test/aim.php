<section>
	<div class="container">
	    <div class="heading" ><?php echo $title;?></div>
	</div>
	<div class="container">
	    <table class="table table-condensed table-hover">
	        <tr>
	            <th></th>
	        	<th>Response Code:</th>
	        	<th>Response Sub Code:</th>
	        	<th>Response Reason Code:</th>
	        	<th>Response Reason Text:</th>
	        	<th>Transaction Id:</th>
	        </tr>
	        <tr>
	            <td><b>Response:</b> </td>
	            <td><?php echo $response->response_code;?></td>
	            <td><?php echo $response->response_subcode;?></td>
	            <td><?php echo $response->response_reason_code;?></td>
	            <td><?php echo $response->response_reason_text;?></td>
	            <td><?php echo $response->transaction_id;?></td>
	        </tr>
	        <tr>
	            <td><b>Object Call:</b> </td>
	            <td>$response->response_code;</td>
	            <td>$response->response_subcode;</td>
	            <td>$response->response_reason_code;</td>
	            <td>$response->response_reason_text;</td>
	            <td>$response->transaction_id;</td>
	        </tr>
	    </table>
	</div>
</section>