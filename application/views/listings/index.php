<?php if($listings):?>
<?php foreach($listings as $listing):?>
    <?php echo $listing->product->name; ?><br />
<?php endforeach;?>
<?php endif;?>

<pre>
<?php 
var_dump($listing);
?>
</pre>