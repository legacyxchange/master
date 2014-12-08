<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$onclick = (empty($url)) ? "events.removeVideoUpload(this);" : "events.removeVieoUploaded(this, {$id});";

?>
	<div class='videoUploadContainer'>
		<div class='input-group eventInputMargin'>
			<input type='text' class='form-control' name='videoUrl[]' id='videlUrl' value="<?=$url?>" placeholder='http://youtu.be/CHZ_Jk5d3W4'>
			<span class='input-group-btn'>
				<button type='button' class='btn btn-danger' onclick="<?=$onclick?>"><i class='fa fa-trash-o'></i></button>
			</span>
		</div>
	</div> <!-- /.videoUploadContainer -->
