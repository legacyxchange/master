<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="panel panel-default blog-panel">
  <div class="panel-heading">Categories</div>
  	<div class="panel-body">
<?php
	try
	{
		$cats = $this->blog->getCategories();
	}
	catch (Exception $e)
	{
		$this->functions->sendStackTrace($e);
	}
	
	if (empty($cats))
	{
		echo $this->alerts->info("No blogs have been assigned to any categories!");
	}
	else
	{
		echo <<< EOS
		<table class='table table-hover table-category'>
			<tbody>
EOS;

		foreach ($cats as $cat => $cnt)
		{
			try
			{
				$catName = $this->blog->getCategoryName($cat);
			}
			catch (Exception $e)
			{
				$this->functions->sendStackTrace($e);
				continue;
			}
		
			echo "<tr onclick=\"blog.viewCategoryBlogs({$cat}, this);\">" . PHP_EOL;
			
			echo "\t<td>{$catName}</td>" . PHP_EOL;
			echo "\t<td><span class='badge pull-right'>{$cnt}</span></td>" . PHP_EOL;
			
			echo "</tr>" . PHP_EOL;
		}

		echo "</tbody>" . PHP_EOL;
		echo "</table>" . PHP_EOL;
		
	}
	
?>
	</div> <!-- .panel-body -->
</div> <!-- /.panel -->
