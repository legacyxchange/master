<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
    
    <div class="container">         
        <div class="content-container">
            <h2><?php echo $title; ?></h2> 
            <table cellpadding="6" cellspacing="1" style="width:100%" border="0">

<tr>
  <th>QTY</th>
  <th>Item Description</th>
  <th style="text-align:right">Item Price</th>
  <th style="text-align:right">Sub-Total</th>
</tr>

<?php $i = 1; ?>

<?php foreach ($this->cart->contents() as $items): ?>

	<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>

	<tr>
	  <td><?php echo form_input(array('name' => $i.'[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></td>
	  <td>
		<?php echo $items['name']; ?>

			<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>

				<p>
					<?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>

						<strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />

					<?php endforeach; ?>
				</p>

			<?php endif; ?>

	  </td>
	  <td style="text-align:right"><?php echo $this->cart->format_number($items['price']); ?></td>
	  <td style="text-align:right">$<?php echo $this->cart->format_number($items['subtotal']); ?></td>
	</tr>

<?php $i++; ?>

<?php endforeach; ?>

<tr>
  <td colspan="2">&nbsp;</td>
  <td class="right"><strong>Total</strong></td>
  <td class="right">$<?php echo $this->cart->format_number($this->cart->total()); ?></td>
</tr>

</table>

<p><?php echo form_submit('', 'Update your Cart'); ?></p> 
<div class="col-lg-12" style="margin:0 auto;background:#fff;border:1px solid #ccc;border-radius:5px;padding:20px;">
	<div class="col-lg-4 col-lg-offset-2">
						<div class="reg-title">
							<h4>Payment Info.</h4>	
							<h5>As Stated on Credit Card</h5>						
						</div>
						<?php echo form_open('#', array('name' => 'paymentform', 'id' => 'paymentform'))?>
        				
        				<input type="hidden" name="address_type_id" value="<?php //echo $address_types[0]->billing; ?>" />   
        				<div class="form-group">
							<label for="fname">First Name</label> <input type='text'
								class='form-control' name='firstName' id='firstName' value="<?php echo $user[0]->firstName;?>"
								placeholder='FIRST NAME' onchange="global.checkFirstName();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						
						<div class="form-group">
							<label for="lname">Last Name</label> <input type='text'
								class='form-control' name='lastName' id='lastName' value="<?php echo $user[0]->lastName;?>"
								placeholder='LAST NAME' onchange="global.checkLastName();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						
						<div class="form-group">
							<label for="lname">Street</label> 
							<input type='text' class='form-control' name='addressLine1' id='addressLine1' value="<?php echo $user[0]->addressLine1;?>" placeholder='Street' onchange="global.checkAddress1();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						
						<div class="form-group">
							<label for="lname">Address 2 (Suite, Apt. #, etc...)</label> 
							<input type='text' class='form-control' name='addressLine2' id='addressLine2' value="<?php echo $user[0]->addressLine2;?>" placeholder='Address 2' onchange="global.checkAddress2();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						
						<div class="form-group">
							<label for="lname">Zipcode</label> 
							<input type='text' class='form-control' name='postalcode' id='postalcode' value="<?php echo $user[0]->postalcode;?>" placeholder='Zipcode' onchange="global.postal_code();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						
						<div class="form-group">
							<label for="lname">Phone</label> 
							<input type='text' class='form-control' name='phone' id='phone' value="<?php echo $user[0]->phone;?>" placeholder='Zipcode' onchange="global.postal_code();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						
						<div class="form-group">
							<label for="lname">Credit Card Number</label> 
							<input type='text' class='form-control' name='credit_card_number' id='credit_card_number' value="" placeholder='Credit Card Number' onchange="global.checkCreditCardNumber();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
						
						<div class="row">
						    <div style="font-weight:bold;font-size:14px;color:#333;">Expiration Date</div>
            				<div class="col-xs-7">
              					<select class="form-control col-sm-2" name="expiry-month" id="expiry-month">
                					<option>Month</option>
                					<option value="01">Jan (01)</option>
               						<option value="02">Feb (02)</option>
                					<option value="03">Mar (03)</option>
                					<option value="04">Apr (04)</option>
                					<option value="05">May (05)</option>
                					<option value="06">June (06)</option>
                					<option value="07">July (07)</option>
                					<option value="08">Aug (08)</option>
                					<option value="09">Sep (09)</option>
                					<option value="10">Oct (10)</option>
                					<option value="11">Nov (11)</option>
                					<option value="12">Dec (12)</option>
              					</select>
            				</div>
            				<div class="col-xs-5">
              					<select class="form-control" name="expiry-year">
                					<option value="13">2013</option>
                					<option value="14">2014</option>
                					<option value="15">2015</option>
                					<option value="16">2016</option>
                					<option value="17">2017</option>
                					<option value="18">2018</option>
                					<option value="19">2019</option>
                					<option value="20">2020</option>
                					<option value="21">2021</option>
                					<option value="22">2022</option>
                					<option value="23">2023</option>
              					</select>
            				</div>
          				</div>
						<br />
						<div class="form-group">
							<label for="lname">Security Code (back of card)</label> 
							<input type='text' class='form-control' name='security_code' id='security_code' value="" placeholder='Security Code' onchange="global.checkCreditCardNumber();" />
							<div class="alert alert-danger" style="display: none;"></div>
						</div>
																	  
        				<?php echo form_close();?>
        				<div class="form-action">
							<button type="button" class="btn btn-primary btn-sm"
								id='submitPaymentBtn'>Continue</button>
						</div>
	</div>

	<div class="shipping_estimate_container col-lg-5 pull-left" style="text-align: center;">	
								<div>
									<strong>Payments Accepted Through:</strong><br>
									<img src="/public/images/credit_cards.gif">
								</div>
							
								<strong>Shipping and Estimated Delivery:</strong><br>
								<div class="shipping_estimate" style="margin:0 auto;height:150px;border:1px solid #ccc;">
							
								</div>							
	</div>
</div>			
        </div>             
     </div>