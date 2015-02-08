<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- listings / products container 6 across w/o bgcolor w/ border on products and container -->
<section class="products-container-border">
	<div class="container">    
        <?php echo form_open('/test/sphinx', array('name' => 'search_form', 'method' => 'post')); ?>
  			<input type="text" name="q" id="q" />
  			<!-- <input type="hidden" name="product_type_id" value="2" /> -->
  			<input type="hidden" name="category_id" value="2" />
  			<input type="submit" value="GO" class="form-submit" />
		<?php echo form_close(); ?>
    </div>
    <?php if($results):?>
    <div class="container">
        <table class="table table-bordered table-condensed">
            <tr>
                <th>$listing->listing_id</th>
                <th>$listing->name</th>
                <th>$listing->description</th>
                <th>$listing->keywords</th>
        	</tr>
        	<?php foreach($results as $r): //if($r->product_id == 37) {var_dump($r->product); exit; } ?>
        	<tr>
            	<td><?php echo $r->listing_id;?></td>
            	<td><?php echo $r->name;?></td>
            	<td><?php echo $r->description;?></td>
             	<td><?php echo $r->keywords;?></td>
            </tr>		
        	<?php endforeach;?>
        </table> 
        <?php elseif(!empty($_POST)): ?> 
        <h1>Sorry No Matches For that Criteria.</h1>
        <?php endif;?>    
    </div> 
</section>
