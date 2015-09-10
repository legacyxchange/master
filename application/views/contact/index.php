<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
.bordered { border:1px solid #ccc; padding:10px;margin:0 auto; }
.rounded { border-radius: 10px; margin:20px;}
.greyish { background:#f4f4f4; padding:20px;margin:0 auto;}
.bluish { background:#e9f3f7; padding:0px;margin:0 auto;}
.title {text-align: center;
    font-size: 20px;
    color:#ccc;}
</style>
<section class="bluish">  
	<div class="title">
		Contact Us
	</div>	
</section>
<section class="greyish">
    <div class="container bordered whitish rounded" style="margin: 20px auto;">
        <?php echo form_open('/contact/send', array('method' => 'post')); ?>
            <?php if($_REQUEST['messages']):?>
            	<input type="hidden" name="messages" value="1" />
            <?php endif;?>
            <label for="full_name">Full Name</label><br />
            <?php $fullname = !empty($this->session->userdata['firstName']) && !empty($this->session->userdata['lastName']) ? $this->session->userdata['firstName'].' '.$this->session->userdata['lastName'] : null; ?>
            <input type="text" placeholder="Full Name" name="full_name" value="<?php echo $fullname; ?>" /><br />
            <label for="email">Email</label><br />
            <input type="text" placeholder="Email" name="email" value="<?php echo $this->session->userdata['email'];?>" /><br />
            <label for="message">Message</label><br />
            <textarea name="message" cols="40" rows="5"></textarea><br />
            <input type="submit" value="Submit" style="padding-left:10px;padding-right:10px;"/>
        <?php echo form_close(); ?>                                 
    </div> 
</section>