<?php
$class = (count($photos) == 1) ? 'post-photo-container-single' : 'post-photo-container';

if (count($photos) == 1)
    $setDim = 'true';

echo "<div class='{$class}'>" . PHP_EOL;

foreach ($photos as $pr) {
    echo "<a href=\"javascript:user.viewPhoto({$pr->id}, {$userid}, '{$pr->fileName}', {$setDim});\" id='img-preview-link-{$pr->id}'><img id='img-preview-{$pr->id}' src='{$this->config->item('bmsUrl')}user/albumphoto/{$userid}/{$pr->fileName}/300' class='img-responsive'></a>" . PHP_EOL;
}

echo "</div> <!-- /.post-photo-container -->" . PHP_EOL;