<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="modal fade" id='album-modal'>
  <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title">Create New Album</h3>
      </div> <!-- modal-header -->
<?php

$attr = array
    (
        'id' => 'albumForm',
        'name' => 'albumForm'
    );

echo form_open('#', $attr);
?>
      <div class="modal-body">
		  <div id='albumAlert'></div>

		  <p class='lead'>Enter the name of the new album you wish to create.</p>
		  
		  <input type='text' class='form-control' name='albumName' id='albumName' placeholder="Album Name">
		  
  </form>
      </div> <!-- /.model-body -->
      
      <div class="modal-footer">
		  		<button type='button' class='btn btn-default' id='cancelAblumBtn' data-dismiss='modal'><i class='fa fa-times-circle'></i> Cancel</button>
                <button type="button" class="btn btn-primary" id='saveAlbumBtn' onclick=""><i class='fa fa-save'></i> Save</button>
 
      </div> <!-- modal-footer -->

  
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->