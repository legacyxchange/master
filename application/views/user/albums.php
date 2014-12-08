<?php if (!defined('BASEPATH')) die('Direct access not allowed'); ?>

<?php
$rcnt = 0;

echo "<div id='album-container'>" . PHP_EOL;

echo "<h2><i class='fa fa-picture-o'></i> Photos</h2>";

if (empty($albums)) {
    if ((int) $this->session->userdata('userid') !== $id) {
        echo $this->alerts->info('This user has no photo albums.');
    } else {
        echo <<< EOS
		<div class='row album-row'>
		

		<div class='album shadow'>
			<div class='album-preview' onclick="user.showAlbumModal();">
				<i class='fa fa-plus'></i>
			</div> <!-- /.album-preview -->
			
			<div class='album-name'><a href='javascript:user.showAlbumModal();'>Create Album</a></div>
			
		</div> <!-- /.album -->
	

	</div> <!-- /.row -->
EOS;
    }
} else {
    foreach ($albums as $r) {
        $imgDisplay = $style = null;

        try {

            $photo = $this->user->getAlbumPhotos($r->id, 1);

            if (!empty($photo))
                $imgDisplay = "<div class='nt-container'><img src='{$this->config->item('bmsUrl')}user/albumphoto/{$id}/{$photo[0]->fileName}/250'></div>";
            else
                $imgDisplay = "<i class='fa fa-camera'></i>";

            // http://dev.bms.socialasylum.com/user/albumphoto/1/b12c22866904c9446797f51217f63d2b_t.jpg/300
            //$style = "background:url({$this->config->item('bmsUrl')}user/albumphoto/{$id}/{$photo[0]->fileName}/250);";
        } catch (Exception $e) {
            $this->functions->sendStackTrace($e);
        }

        if ($rcnt == 0)
            echo "<div class='row album-row'>" . PHP_EOL;

        echo <<< EOS

		<div class='album shadow'>
			<div class='album-preview' onclick="user.viewAlbum({$r->id});">
				{$imgDisplay}
			</div> <!-- /.album-preview -->
			
			<div class='album-name'><a href='javascript:user.viewAlbum({$r->id});'>{$r->name}</a></div>
			
		</div> <!-- /.album -->
EOS;
        if ($rcnt >= 2) {
            echo "</div> <!-- /.row -->" . PHP_EOL;
            $rcnt = 0;
        } else {
            $rcnt++;
        }
    }
}

if ($rcnt == 0)
    echo "<div class='row album-row'>" . PHP_EOL;

if ($this->session->userdata('logged_in') == true && (int) $this->session->userdata('userid') == $id) :
    ?>


    <div class='album shadow'>
        <div class='album-preview' onclick="user.showAlbumModal();">
            <i class='fa fa-plus'></i>
        </div> <!-- /.album-preview -->

        <div class='album-name'><a href='javascript:user.showAlbumModal();'>Create Album</a></div>

    </div> <!-- /.album -->


    <?php
endif;

// closes row if not 3 albums in the row
if ($rcnt < 3)
    echo "</div> <!-- /.row -->" . PHP_EOL;

echo "</div> <!-- #album-container -->" . PHP_EOL;
?>




