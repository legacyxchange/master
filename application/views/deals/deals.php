
<script type='text/javascript' src='/public/js/deals.js'></script>  

<div class="add_new_butt">
	<a href="#" class="big-link" data-reveal-id="myModal">add new</a>
</div>
<div class="war">
	<table width="100%" border="0" class="table_1">
		<tr>
			<th valign="middle" align="left" width="7.5%">
				<div class="deals-check">
					<p>
						<input class="checkbox1" name="" type="checkbox" value="" /><label>check</label>
					</p>
				</div>
			</th>
			<th valign="middle" align="left" width="38.5%">Title</th>
			<th valign="middle" align="left" width="22.5%">In Stock</th>
			<th valign="middle" align="left" width="17.5%">Price</th>
			<th valign="middle" align="right" width="14%">&nbsp;</th>
		</tr>
		<?php foreach($deals as $r):?>
		
		<tr>
			<td valign="middle" align="left">
				<div class="deals-check">
					<p>
						<input name="" type="checkbox" value="" /><label>check</label>
					</p>
				</div>
			</td>
			<td valign="middle" align="left"><img src="/deals/dealimg/50/<?php echo $userid;?>" /><span><?php echo $r->deal_name;?></span></td>
			<td valign="middle" align="left">6</td>
			<td valign="middle" align="left">$30.00</td>
			<td valign="middle" align="right" class="icon">
			<a href="#" onclick="return confirm('Are you sure you want to delete this?');"><img src="/public/images/delete.png" /> </a> 
			<a href="#" class="big-link edit_button" data-reveal-id="myModa2"><img src="/public/images/edit-admin.png" /> </a> 
			<?php if($r->featured < 1):?>
				<a href="#" class="fa fa-star pull-right featured" id="<?= $r->dealid;?>" style="color: black;"></a> 
			<?php else:?> 
				<a href="#" class="fa fa-star pull-right featured" id="<?= $r->dealid;?>" style="color: gold;"></a> 
			<?php endif;?>
			</td>
		</tr>
		<?php endforeach;?>
	</table>
</div>
