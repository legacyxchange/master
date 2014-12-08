<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<div class='userTabContent shadow'>
	<div class='row blog-title'>

	
		<div class='col-md-9'>
				<h2><?=$info->title?></h2>
		</div>
		
		<div class='col-md-3'>
			<button type='button' class='btn btn-info pull-right' onclick="user.viewBlogPreviews();"><i class='fa fa-chevron-left'></i></button>
		</div>
	</div> <!-- /.row -->
	
<?php
echo "<img src='{$this->config->item('bmsUrl')}public/uploads/blog/{$info->featuredImg}' class='img-responsive img-thumbnail'>" . PHP_EOL;
?>
	<?=$info->body?>

</div>

<h4><?=count($comments)?> Comment<?=(count($comments) == 1) ? null : 's'?></h4>

<?php
if (empty($comments))
{
	echo $this->alerts->info("This article has no comments!");
}
else
{
    foreach ($comments as $r)
    {
    	$commentDate = null;
    	
        try
        {
            $username = (empty($r->userid)) ? $r->name : $this->functions->getUserName($r->userid);
            
            $userid = ($this->session->userdata('logged_in') == true) ? $this->session->userdata('userid') : $eventInfo->userid;
            
            $commentDate = $this->functions->convertTimezone($userid, $r->datestamp, "F d Y g:i A");
        }
        catch(Exception $e)
        {
            $this->functions->sendStackTrace($e);
            continue;
        }
        
        $r->comment = nl2br($r->comment);
        
    	echo <<< EOS
			<div class="panel panel-default profile-blog-panel shadow">
				<div class="panel-heading">
					<h3 class="panel-title">{$username}</h3>
					
					<span class='pull-right blog-comment'>{$commentDate}</span>
					
					<div class='clearfix'></div>
				</div> <!-- /.panel-heading -->
				<div class="panel-body">

					<div class='excerpt-container' onclick="user.viewblog({$r->id});">
						
						
						{$r->comment}
						<div class='clearfix'></div>
					</div> <!-- /.excerpt-container -->
				</div> <!-- /.-panel-body -->
			</div> <!-- /.panel -->
    	
EOS;
    }
    
}

?>

<div class='userTabContent shadow'>
	<h3>Write a Comment</h3>
	
	        <div id='reviewAlert'></div>

        <!-- <form role='form' class='reviewForm'> -->

<?php
    
    $attr = array
        (
            'id' => 'commentForm'
        );

    echo form_open('#', $attr);

	$disabled = ($this->session->userdata('logged_in') == true) ? "disabled='disabled'" : null;
?>

        <input type='hidden' name='rating' id='rating' value='0'>

        <input type='hidden' name='id' id='id' value='<?=$id?>'>

        <div class='row user-write-comment'>
            <div class='col-md-6'>
                    <div class="form-group">
                    <label for='reviewName'>NAME*:</label>
                    <input type='text' class='form-control' id='reviewName' name='reviewName' <?=$disabled?> value="<?=($this->session->userdata('logged_in') == true) ? "{$this->session->userdata('firstName')} {$this->session->userdata('lastName')}" : null?>">
                </div> <!-- .form-group -->
            </div>

            <div class='col-md-6'>

                <div class="form-group">
                    <label for='reviewEmail'>E-MAIL*:</label>
                    <input type='text' class='form-control' id='reviewEmail' name='reviewEmail' <?=$disabled?> value="<?=($this->session->userdata('logged_in') == true) ? $this->session->userdata('email') : null?>">
                </div> <!-- .form-group -->

            </div>
        </div> <!-- row -->
        
            <div class="form-group">
                <label  for='reviewDesc'>DESCRIPTION:</label>
                <textarea class='form-control' name='reviewDesc' id='reviewDesc' rows='5'></textarea>
            </div> <!-- .form-group -->

            <div class='row'>
                <div class='col-md-12 review-row'>
                    <a id='write_review'></a>
                    
                    <button type='button' class='btn btn-default pull-right inverse' id='reviewBtn'>POST COMMENT</button>
                </div>
            </div>
       
</form>
	
</div> <!-- /.userTabContent -->