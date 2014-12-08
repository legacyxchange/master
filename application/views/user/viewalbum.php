<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<div class='row photo-actions'>
	<div class='col-xs-6 col-sm-8 col-md-8'>
		<h2 class='pull-left'><i class='fa fa-picture-o'></i> Photos - <?=$info->name?></h2>
		
	</div> 
	<div class='col-xs-6 col-sm-4 col-md-4'>
	
		<button type='button' class='btn btn-default pull-right'><i class='fa fa-cog'></i></button>
		
		<button type='button' class='btn btn-info pull-right' style="margin-right:10px;" onclick="user.viewAllAlbums();"><i class='fa fa-chevron-left'></i> All Albums</button>



	</div>
</div>

<?php
if (empty($photos))
{
	echo $this->alerts->alert("This album has no photo's.");
}
else
{
	echo "<div id='album-photo-container'>";
	foreach ($photos as $r)
	{
		echo "<a href=\"javascript:user.viewPhoto({$r->id}, {$userid}, '{$r->fileName}', true);\"><img class='' src='{$this->config->item('bmsUrl')}user/albumphoto/{$userid}/{$r->fileName}/250'></a>" . PHP_EOL;
	}
	echo "</div> <!-- /#album-photo-container -->" . PHP_EOL;
}
?>