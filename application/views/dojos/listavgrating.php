<?php if(!defined('BASEPATH')) die('Direct access not allowed');

$largeClass = ($largeStar == true) ? 'largeStars' : null;

echo "<div class='listRating {$largeClass}'>" . PHP_EOL;

for ($i = 1; $i <= 5; $i++)
{
    $class = null;

    if (empty($avg)) $class = 'gray';
    else
    {
        $class = ($i <= $avg) ? 'setRating' : null;
    }

    echo "<i class='fa fa-star {$class}'></i>";
}

echo "</div> <!-- .listRating -->" . PHP_EOL;
