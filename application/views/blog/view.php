<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class='container page-content'>

<div class='row'>
	<div class='col-xs-12 col-sm-12 col-md-8 blog-view-container' id='blogContentCol'>
		<span class='pull-right'><?=$date?></span>
	<h1><?=$info->title?></h1>

<?php
echo "<img src='{$this->config->item('bmsUrl')}public/uploads/blog/{$info->featuredImg}' class='img-responsive img-thumbnail'>" . PHP_EOL;
?>

	<?=$info->body?>

	<div class='row'>
		<div class='col-md-12'>
			<div class='hide-reviews'>
			<span class='pull-right'><a href='javascript:void(0);' class='hideCommentLink' onclick="blog.hideComments(this);"><i class='fa fa-caret-up'></i> Hide Comments</a></span>
			</div>
		</div>
	</div> <!-- .row -->

	
	<div id='reviews-container'>
			<h4 class='blogView'><?=count($comments)?> Comment<?=(count($comments) == 1) ? null : 's'?></h4>
<?php
if (empty($comments))
{
	echo $this->alerts->info("This article has no comments!");
}
else
{
    foreach ($comments as $r)
    {

        // gets users avatar
        // $avatar = get_avatar('comment_author_email');
        // $rating = 0;

        try
        {
            $username = (empty($r->userid)) ? $r->name : $this->functions->getUserName($r->userid);
        }
        catch(Exception $e)
        {
            $this->functions->sendStackTrace($e);
            continue;
        }
        
        $r->comment = nl2br($r->comment);

        //$bodyRating['avg'] = $r->rating;
        //$bodyRating['largeStar'] = true;
        //$ratingHtml = $this->load->view('dojos/listavgrating', $bodyRating, true);


		

        echo <<< EOS

    <div class='row'>
        <div class='col-md-12'>
            <div class='well comment-well'>
            
                <span class='comment-author'>{$username}</span><br><br>

                {$r->comment}

                <div class='clearfix'></div>

            </div>
        </div>


    </div> <!-- row -->
EOS;
    }
}
?>
			<h4 class='blogView'>Write A Comment</h4>
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

        <div class='row'>
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

<?php
/*
            <div class="form-group">
                <label for='ratings'>RATING:</label>

                    <div id='reviewStars' class='reviewStars'>
                        <i class='fa fa-star' id='rating_star_1' value='1'></i>
                        <i class='fa fa-star' id='rating_star_2' value='2'></i>
                        <i class='fa fa-star' id='rating_star_3' value='3'></i>
                        <i class='fa fa-star' id='rating_star_4' value='4'></i>
                        <i class='fa fa-star' id='rating_star_5' value='5'></i>
                    </div>
            </div> <!-- .form-group -->
*/
?>
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
	</div> <!-- /#reviews-container -->
	
	</div> <!-- col-8 -->

	<div class='col-xs-12 col-sm-12 col-md-4'>
		<div id='blogSideContainer'>
			<?php $this->load->view('blog/categories'); ?>
			<?php $this->load->view('blog/recent_blogs'); ?>
		</div> <!-- #blogSideContainer -->
	</div> <!-- col-4 -->
</div> <!-- .row -->

</div> <!-- .container -->