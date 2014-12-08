<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="modal fade" id='msg-modal'>
  <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title">Send a Message</h3>
      </div> <!-- modal-header -->
<?php

$attr = array
    (
        'id' => 'msgForm',
        'name' => 'msgForm'
    );

echo form_open('#', $attr);
?>
      <div class="modal-body">
		  <div id='msgAlert'></div>

		  <textarea class='form-control' rows='5' id='msg' name='msg'></textarea>
		  
  </form>
      </div> <!-- /.model-body -->
      
      <div class="modal-footer">
		  		<button type='button' class='btn btn-default' id='cancelMsgBtn' data-dismiss='modal'><i class='fa fa-times-circle'></i> Cancel</button>
                <button type="button" class="btn btn-primary" id='sendMsgBtn' onclick=""><i class='fa fa-send'></i> Send</button>
 
      </div> <!-- modal-footer -->

  
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->