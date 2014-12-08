<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class='container page-content'>
    
        <div class='col-md-8 blog-content-container' id='blogContentCol'>
        
        	<div class='row'>
        		
        	
        	</div> <!-- .row -->
        

<?php foreach ($deals as $r): ?>
    <div role="form">
    <?php echo form_open_multipart('/deals/edit/'.$r->dealid.'/'.$location_id); ?>
    
    <div class="form-group">
	<?php echo form_hidden('dealid', $r->dealid);?>
	<?php echo form_hidden('id', $r->location_id);?>
	</div>
    
    <div class="form-group">
	<?php echo form_input('deal_name', $r->deal_name);?>
	</div>
    <div class="form-group">
	<?php echo form_textarea('deal_description', $r->deal_description);?>
	</div>
	<div class="form-group">
	$<?php echo form_input(array('name' => 'retail_price', 'placeholder' => 'Retail Price', 'value' => number_format($r->retail_price,2)));?>
	</div>
	<div class="form-group">
	$<?php echo form_input(array('name' => 'discount_price', 'placeholder' => 'Discount Price', 'value' => number_format($r->discount_price,2)));?>
	</div>
    <div class="form-group">
	<strong>Start Date: </strong><?php echo form_input(array('name' => 'start_date', 'value' => $r->start_date, 'type' => 'date', 'min' => date('Y-m-d')));?>
	</div>
	<div class="form-group">
	<?php $date = date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));?>
	<strong>End Date: </strong><?php echo form_input(array('name' => 'end_date', 'value' => $r->end_date, 'type' => 'date', 'min' => "$date"));?>
	</div>
	<div class="form-group">
	    <strong>Repeat:</strong> <select name="repeat">
	        <option <?php echo $r->repeat == 'weekly' ? 'selected' : null;?> value="weekly">Weekly</option>
	        <option <?php echo $r->repeat == 'monthly' ? 'selected' : null;?> value="monthly">Monthly</option>
	        <option <?php echo $r->repeat == 'yearly' ? 'selected' : null;?> value="yearly">Yearly</option>
	    </select>
	</div>
	<div class="form-group">
	<strong>Expiration Date: </strong><?php echo form_input(array('name' => 'expiration_date', 'value' => $r->expiration_date, 'type' => 'date', 'min' => date('Y-m-d')));?>
	</div>
	<div class="form-group">
	    <input type="file" name="userfile" size="20" /> 
	    <?php if(isset($r->deal_image)):?>
	        Current Image: <img src="<?=base_url();?>deals/dealimg/100/<?=$userid;?>/<?=$r->deal_image;?>" />
	    <?php endif;?>
	</div>
	<?php echo form_submit('submit', 'Edit');?>
	</form>
<?php endforeach; ?>

</div></div></div>