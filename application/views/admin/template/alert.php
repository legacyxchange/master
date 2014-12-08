<?php if(!defined('BASEPATH')) die('Direct access not allowed'); ?>

<div class='headingAlerts'>
<div id='site-alert'></div>
<?php
if (isset($_GET['site-alert']) && !empty($_GET['site-alert']))
{
        echo "<div class='alert alert-warning animated fadeIn'>" .
                    "<button type='button' class='close' data-dismiss='alert'>&times;</button>" .
        "<h4><i class='fa fa-exclamation-triangle'></i> Alert</h4>" . urldecode($_GET['site-alert']) . "</div>";
}
if (isset($_GET['site-info']) && !empty($_GET['site-info']))
{
        echo "<div class='alert alert-info animated fadeIn'>" .
                    "<button type='button' class='close' data-dismiss='alert'>&times;</button>" .
        "<h4><i class='fa fa-exclamation-circle'></i> Information</h4>" . urldecode($_GET['site-info']) . "</div>";
}
if (isset($_GET['site-success']) && !empty($_GET['site-success']))
{
        echo "<div class='alert alert-success animated fadeIn'>" .
                    "<button type='button' class='close' data-dismiss='alert'>&times;</button>" .
        "<h4><i class='fa fa-thumbs-up'></i> Success</h4>" . urldecode($_GET['site-success']) . "</div>";
}

if (isset($_GET['site-error']) && !empty($_GET['site-error']))
{
        echo "<div class='alert alert-danger animated fadeIn'>" .
                    "<button type='button' class='close' data-dismiss='alert'>&times;</button>" .
        "<h4><i class='fa fa-times-circle-o'></i> Error</h4>" . urldecode($_GET['site-error']) . "</div>";
}
?>
</div>