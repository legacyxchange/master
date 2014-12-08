<!--container start-->
<div class="container main-content">
<?php if($this->session->flashdata('SUCCESS')): ?>
    <div class='row'>
        <h3 class="alert alert-success"><?php echo $this->session->flashdata('SUCCESS'); ?></h3>
    </div>
<?php elseif($this->session->flashdata('FAILURE')): ?>
    <div class='row'>
        <h3 class="alert alert-danger"><?php echo $this->session->flashdata('FAILURE'); ?></h3>
    </div>
<?php elseif($this->session->flashdata('NOTICE')): ?>
    <div class='row'>
        <h3 class="alert alert-notice"><?php echo $this->session->flashdata('NOTICE'); ?></h3>
    </div>
<?php endif; ?> 
<?php echo $admin_menu;?>
    <div class="war">
        <h2>My Dashboard</h2>                                                               
    </div>
    
    <?php if (empty($products)):?>
    <div class="war">
        <?php echo $this->alerts->info("You currently have no products"); ?>
    </div>
    <?php else: ?>
    
    <div class='war'>
        <h4>You currently have <?php echo count($products);?> Products Entered in the system. <a class="btn btn-default" href="/admin/products">Edit or Add Products Here.</a></h4>
        
	    <?php foreach ($products as $product): ?>	        
            <div><?php echo $product->name; ?></div>  
	    <?php endforeach; ?>
    <?php endif; ?>          
    </div>
    
    
    <?php if (empty($listings)):?>
    <div class="war">
        <?php echo $this->alerts->info("You currently have no listings"); ?>
        </div>
    <?php else: ?>
    
    <div class='war'>
        <h4>You currently have <?php echo count($listings);?> Listings Entered in the system. <a class="btn btn-default" href="/admin/listings">Edit or Add Listings Here.</a></h4>
        
	    <?php foreach ($listings as $listing): ?>	        
            <div><?php echo $listing->listing_name; ?></div>  
	    <?php endforeach; ?>
    <?php endif; ?>          
    </div>
</div>
<!--container end-->