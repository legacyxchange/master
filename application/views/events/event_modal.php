<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<div class='modal-dialog'>
        <div class='modal-content'>

    <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h3><?=$info->name?></h3>
    </div> <!-- .modal-header -->

    <input type='hidden' name='lat' id='lat' value='<?=$lat?>'>
    <input type='hidden' name='lng' id='lng' value='<?=$lng?>'>

    <div class='modal-body'>
    
    
<!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="active"><a href="#infoTab" data-toggle="tab"><i class='fa fa-exclamation-circle'></i> Event Info</a></li>
  <li><a href="#mapTab" data-toggle="tab"><i class='fa fa-globe'></i> Map</a></li>

</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="infoTab">
        <dl class='dl-horizontal' id='eventModalDetails'>
            <dt>Name</dt>
            <dd><?=$info->name?></dd>

            <dt>Location</dt>
            <dd><?=$location?>&nbsp;</dd>

			<?php if (!empty($from)) : ?>
	            <dt>From</dt>
	            <dd><?=$from?></dd>
			<?php endif; ?>

			<?php if (!empty($to)) : ?>
	            <dt>To</dt>
	            <dd><?=$to?></dd>
            <?php endif; ?>

			<?php if (!empty($time)) : ?>
	            <dt>Time</dt>
	            <dd><?=$time?></dd>
            <?php endif; ?>

            <dt>Created By</dt>
            <dd><?=$createdBy?></dd>

			<?php if ($info->repeat == 1) : ?>
				<dt>Repeats</dt>  
				<dd><?=$repeatSummary?></dd>
			<?php endif; ?>

            <dt>Description</dt>
            <dd><?=$info->description?>&nbsp;</dd>

        </dl>	 
  </div> <!-- /#infoTab -->
  	
 
  <div class="tab-pane" id="mapTab">
    <div class='eventMap' id='eventMap'></div>	  
  </div> <!-- /#mapTab -->

</div>
    
    


    </div> <!-- .modal-body //-->

    <div class='modal-footer'>
<?php
if ($this->session->userdata('logged_in') == true)
{
	if ((int) $info->userid == (int) $this->session->userdata('userid'))
	{
		echo "<a href='/events/edit/{$eventLocation}/{$month}/{$year}/{$id}' class='btn btn-info'><i class='fa fa-pencil'></i></a>";
	}
}
?>
       

        <button class='btn btn-default' data-dismiss='modal' aria-hidden='true' id='cancelBtn'>Close</button>
    </div> <!-- .modal-footer //-->

        </div> <!-- .modal-content -->
    </div> <!-- .modal-dialog -->
</div> <!-- .modal -->