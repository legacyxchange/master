<div class="admin-menu-container container ">
	<?php echo $admin_menu;?>
</div>
<div  style="border-bottom:2px solid #0a6e8e;border-top:2px solid #0a6e8e;background:#f4f4f4;margin-top: 20px;padding-top: 16px;">
    <h2 style="color:#016889;">MY ACCOUNT</h2>
</div>

<!--container start-->
<div class="container">
    <div>
        <div>NAME: <?php echo $user->firstName;?> <?php echo $user->lastName;?></div>
        <div>USERNAME: <?php echo $user->username;?></div>
        <?php if($user->addressLine1):?>
        <div>ADDRESS: <?php echo $user->addressLine1;?> <?php echo $user->addressLine2;?>, <?php echo $user->state;?> <?php echo $user->postalCode;?></div>
        <?php endif;?>
        <?php if($user->phone):?>
        <?php //$this->functions->?>
        <div>PHONE: <?php //echo $this->functions->getPhoneForDisplay($user->phone);?></div>
        <?php endif;?>
        <?php if($user->email):?>
        <div>EMAIL: <?php echo $user->email;?></div>
        <?php endif;?>
    </div>
        
    <?php if (empty($products)):?>
    <div class="war">
        <?php echo $this->alerts->info("You currently have no products"); ?>
    </div>
    <?php else:?>
    
    <div class='content'>
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

<?php var_dump($user,$products,$listings); ?>