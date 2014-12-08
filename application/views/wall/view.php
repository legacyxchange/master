<?php if(!defined('BASEPATH')) die('Direct access not allowed'); 

require_once './application/third_party/timeago/timeago.inc.php';


if (empty($posts))
{
	echo $this->alerts->info("No Activity");
}
else
{
	//echo "<form id='wall-form'>" . PHP_EOL;
	
	echo form_open('#', array('id' => 'wall-form', 'method' => 'post'));
	
	echo "<input type='hidden' name='userid' value='{$userid}'>" . PHP_EOL;
	echo "<input type='hidden' id='refreshing' value='0'>". PHP_EOL;
	

	$this->load->view('wall/loadposts', array('posts' => $posts));

	echo "</form>" . PHP_EOL;
	
	
	echo "<div id='wall-loader'><div id='spin-container'></div></div>";
	
	echo "<button type='button' class='btn btn-link viewMoreBtn' id='viewMoreBtn'>View More <i class='fa fa-chevron-down'></i></button>";
}
?>