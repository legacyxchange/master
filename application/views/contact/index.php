<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="bluish">  
	<div class="title">
		Contact Us
	</div>	
</section>
<section class="greyish">
    <div class="container bordered whitish rounded">
        <?php echo form_open('/contact/send', array('method' => 'post')); ?>
            <label for="full_name">Full Name</label><br />
            <?php $fullname = !empty($this->session->userdata['firstName']) && !empty($this->session->userdata['lastName']) ? $this->session->userdata['firstName'].' '.$this->session->userdata['lastName'] : null; ?>
            <input type="text" placeholder="Full Name" name="full_name" value="<?php echo $fullname; ?>" /><br />
            <label for="email">Email</label><br />
            <input type="text" placeholder="Email" name="email" value="<?php echo $this->session->userdata['email'];?>" /><br />
            <label for="message">Message</label><br />
            <textarea name="message" cols="40" rows="5"></textarea><br />
            <input type="submit" value="Submit" />
        <?php echo form_close(); ?>                                 
    </div> 
</section>