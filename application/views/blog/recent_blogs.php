<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="panel panel-default blog-panel">
  <div class="panel-heading">Recent Blogs</div>
  	<div class="panel-body">
<?php
	try
	{
		$recent = $this->blog->getBlogs(5);
	}
	catch (Exception $e)
	{
		$this->functions->sendstackTrace($e);
	}
	
	if (empty($recent))
	{
		echo $this->alerts->info("No recent blogs available!");
	}
	else
	{
		foreach ($recent as $r)
		{
			$excerpt = $date = null;
			
			try
			{
				$excerpt = $this->blog->getBlogCol($r->id, 'excerpt');
				$publishDate = $this->blog->getBlogCol($r->id, 'publishDate');
				
				$excerpt = (strlen($excerpt) > 150) ? substr($excerpt, 0, 147) . '...' : $excerpt;
								
				if (!empty($excerpt)) $excerpt = "<p>{$excerpt}</p>" . PHP_EOL;
				
				$date = $this->functions->convertTimezone($this->session->userdata('userid'), $publishDate, "m/d/Y");
			}
			catch (Exception $e)
			{
				$this->functions->sendstackTrace($e);
			}
					
			echo <<< EOS
	<div class='row recent-blog' onclick="blog.view($r->id);">
		<div class='col-md-12'>
			<span class='pull-right text-muted'>{$date}</span>
		
			<h4>{$r->title}</h4>
			{$excerpt}
		</div> <!-- /.col-md-12 -->
  	</div>		
EOS;
		}	
	}
	
?>
	</div> <!-- .panel-body -->
</div> <!-- /.panel -->
