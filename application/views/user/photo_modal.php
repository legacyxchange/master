<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="modal fade photo-modal" id='photo-modal'>
  <div class="modal-dialog">
    <div class="modal-content">
    
    <?php
    /*
        <div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		</div> <!-- modal-header -->
		*/
?>
      <div class="modal-body">
      
      	<input type='hidden' id='modalPhotoID' value=''>
      
		  <div class='row photo-content'>
		  	<div class='col-xs-6 col-sm-8 col-md-9 img-bg'>
		  		<img id='photo-img' class='img-responsive' src=''>
		  	</div>
		  	
		  	<div class='col-xs-6 col-sm-4 col-md-3 info-col'>
		  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  		<div id='photo-info-display'></div>
		  		
		  	</div> 
		  </div> <!-- /.row -->
      </div> <!-- /.model-body -->
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

