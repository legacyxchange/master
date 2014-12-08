<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<!-- videopreviewModal -->


<div class="modal fade" id='videoPreviewModal'>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="video-title"></h3>
      </div> <!-- modal-header -->

     	 <div class="modal-body">

		  <div id='videoAlert'></div>
		  	<iframe src="" align='center' class='youtubeIframe'></iframe>

		  </div> <!-- .modal-body -->

      <div class="modal-footer">
      		<?php if ($showDelete) : ?>
	  			<button class='btn btn-danger pull-left' id='deleteVideoBtn'><i class='fa fa-trash-o'></i></button>
		  	<?php endif; ?>
		  	
		  <button class='btn btn-default' id='closeVideoModalBtn'>Close</button>
      </div> <!-- modal-footer -->

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
