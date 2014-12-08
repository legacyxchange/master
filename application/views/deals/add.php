<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class='container page-content'>

    <?php if($this->session->flashdata('SUCCESS')): ?>
    <div class='row'>
        <h3 class="alert alert-success"><?php echo $this->session->flashdata('SUCCESS'); ?></h3>
    </div>
    <?php elseif($this->session->flashdata('FAILURE')): ?>
    <div class='row'>
        <h3 class="alert alert-danger"><?php echo $this->session->flashdata('FAILURE'); ?></h3>
    </div>
    <?php endif; ?>
    
    <div class='col-md-8 blog-content-container' id='blogContentCol'>
        
    <div role="form">
    <?php echo form_open_multipart('/admin/deals/add/'.$location_id);?>
    <?php echo form_hidden('userid', $userid);?>
    <?php echo form_hidden('location_id', $location_id);?>
    
    <div class="form-group">
	<?php echo form_input(array('name' => 'deal_name', 'placeholder' => 'Deal Title'));?>
	</div>
    <div class="form-group">
	<?php echo form_textarea(array('name' => 'deal_description', 'placeholder' => 'Deal Description'));?>
	</div>
	<div class="form-group">
	<?php echo form_input(array('name' => 'retail_price', 'placeholder' => 'Retail Price'));?>
	</div>
	<div class="form-group">
	<?php echo form_input(array('name' => 'discount_price', 'placeholder' => 'Discount Price'));?>
	</div>
    <div class="form-group">
	<strong>Start Date:</strong> <?php echo form_input(array('name' => 'start_date', 'type' => 'date', 'min' => date('Y-m-d')));?>
	</div>
	<div class="form-group">
	<?php $date = date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));?>
	<strong>End Date:</strong> <?php echo form_input(array('name' => 'end_date', 'type' => 'date', 'min' => "$date"));?>
	</div>
	<div class="form-group">
	    <strong>Repeat:</strong> <select name="repeat">
	        <option value="weekly">Weekly</option>
	        <option value="monthly">Monthly</option>
	        <option value="yearly">Yearly</option>
	    </select>
	</div>
	<div class="form-group">
	<strong>Expiration Date:</strong> <?php echo form_input(array('name' => 'expiration_date', 'type' => 'date', 'min' => date('Y-m-d')));?>
	</div>
	<div class="form-group">
	    <input type="file" name="userfile" size="20" />
	</div>
	<?php echo form_submit('submit', 'Add');?>
	<?php echo form_close();?>