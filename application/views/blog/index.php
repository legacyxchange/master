<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class='container page-content'>

<?php
/*
	<div class='row'>
		<div class='col-md-12 blog-header'>
			<h1>Karate Blog<?php if (!empty($category)) echo " - {$catName}"; ?></h1>
		</div> <!-- col-md-12 -->
	
	</div> <!-- .row -->

	<h5 class='blog'>Whats Hot!</h5>
*/
?>

    <div class='row'>
    
        <div class='col-md-8 blog-content-container' id='blogContentCol'>
        
        	<div class='row'>
        		<div class='col-md-12 blogTitle'>
        			<h1>Karate Blog<?php if (!empty($category)) echo " - {$catName}"; ?></h1>
        		</div> <!-- col-md-12 -->
        	
        	</div> <!-- .row -->
        

<?php
if (empty($blogs))
{
	echo $this->alerts->info("There are no available blogs!");
}
else
{
	foreach ($blogs as $r)
	{
	
		$description = $featuredImg = null;
		
		$shareUrl = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}/blog/view/{$r->id}";
		
		try
		{
			$excerpt = $this->blog->getBlogCol($r->id, 'excerpt');
			$featuredImg = $this->blog->getBlogCol($r->id, 'featuredImg');
			
			$description = "<p>" . nl2br($excerpt) . "</p>" . PHP_EOL;
			
			// gets category name
			$categoryDislay = (empty($r->category)) ? 'Uncategorized' : $this->blog->getCategoryName($r->category);
		}
		catch (Exception $e)
		{
			$this->functions->sendStackTrace($e);
		}
	
		echo <<< EOS
	<div class='row blog-row'>
		<div class='blog-featuredImg' onclick="blog.view($r->id);" style="background:url('{$this->config->item('bmsUrl')}public/uploads/blog/{$featuredImg}');"></div>
	
		<div class='article-content' onclick="blog.view($r->id);">
			<p class='category'>{$categoryDislay}</p>
			
			<h3>{$r->title}</h3>

			{$description}

<table class='socialMediaTbl'>
	<tr>
		<td><div class="fb-share-button" data-href="{$shareUrl}" data-type="button_count"></div></td>
		
		<td>
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="{$shareUrl}" data-via="wgallios">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		</td>

		<td>
		<script src="//platform.linkedin.com/in.js" type="text/javascript">
  lang: en_US
</script>
<script type="IN/Share" data-url="{$shareUrl}"></script>
	
		</td>
		
		<td>
			<!-- Place this tag where you want the share button to render. -->
			<div class="g-plus" data-action="share" data-href="{$shareUrl}"></div>
			
			<!-- Place this tag after the last share tag. -->
			<script type="text/javascript">
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/platform.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
		</td>
		
	
    </tr>
</table>




		
		
        </div> <!-- .row /.article-content -->
	
	
    </div> <!-- .row -->
EOS;
	}
}
?>
        
        </div> <!-- col-md-8 -->
        
        <div class='col-md-4'>
	        <div id='blogSideContainer'>
				<?php $this->load->view('blog/categories'); ?>
				<?php $this->load->view('blog/recent_blogs'); ?>
	        </div> <!-- #blogSideContainer -->
        </div> <!-- col-md-4 -->
    </div>
</div>