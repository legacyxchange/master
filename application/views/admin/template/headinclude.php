<?php
if (!defined('BASEPATH'))
    die('Direct access not allowed');
//require_once './application/third_party/less/lessc.inc.php';

//$less = new lessc;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $this->functions->getSiteName(); ?></title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                
        <!-- bootstrap 3.1.1 -->
        <script type="text/javascript" src="/public/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="/public/bootstrap3.1.1/js/bootstrap.min.js"></script>
        <link type="text/css" href="/public/bootstrap3.1.1/css/bootstrap.min.css" rel="Stylesheet" />
        <link type="text/css" href="/public/jquery-ui-1.10.4/css/blitzer/jquery-ui-1.10.4.custom.min.css" rel="Stylesheet" />
        <script type="text/javascript" src="/public/jquery-ui-1.10.4/js/jquery-ui-1.10.4.custom.min.js"></script>
        <link rel="shortcut icon" href="/public/images/gst_favcon.png" type="image/png">
        <link rel="icon" href="/public/images/favicon.ico" type="image/png">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- New stuff -->
        
        <!-- Custom CSS -->
    	<link href="/public/css/custom-styles.css" rel="stylesheet">
    
    	<!-- Custom Fonts -->
    	      
        <!-- end new stuff -->
        
        <!-- classy loader -->
        <?php echo  $this->functions->jsScript('../classyloader/js/jquery.classyloader.js') ?>
        <?php //<script src="/public/classyloader/js/jquery.classyloader.min.js"></script> ?>


        <?= $this->functions->cssScript('main.css') ?>
        <?= $this->functions->cssScript('media.css') ?>

        <link rel='stylesheet' type='text/css' href='/public/css/animate.css' />
        <link rel="stylesheet" href="/public/js/owl-carousel/owl.carousel.css">
        <script src="/public/js/owl-carousel/owl.carousel.min.js"></script>
        <link rel="stylesheet" href="/public/js/owl-carousel/owl.theme.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>

        <script type="text/javascript" src="/public/js/velocity/jquery.velocity.js"></script>

        <?= $this->functions->jsScript('websocket/jquery.gracefulWebSocket.js') ?>
        <?= $this->functions->jsScript('jquery.functions/jquery.functions.js') ?>

        <?= $this->functions->jsScript('global.js'); ?>

        <?php if ($this->config->item('live') == true) : ?>
            <script>
                (function(i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function() {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

                ga('create', 'UA-48112980-1', 'karateasylums.com');
                ga('send', 'pageview');

            </script>
        <?php else: ?>
            <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <?php endif; ?>

        <?= $this->functions->jsScript('facebook.js') ?>
        <?= $this->functions->jsScript('jquery.ajax-progress.js') ?>
        <?= $this->functions->jsScript('jquery-number/jquery.number.js') ?>

        <?= $this->functions->jsScript('timeago/jquery.timeago.js') ?>

        <?php
        if ($spin) {
            echo $this->functions->jsScript('spin/spin.js');
            echo $this->functions->jsScript('spin/jquery.spin.js');
        }

        if ($chat) {
            echo $this->functions->jsScript('jquery.chat.js jquery.websocket.js', 'application/third_party/bms/js/', 'text/javascript', true, 'gen');
            echo $this->functions->cssScript('jquery.chat.css', 'application/third_party/bms/css/', true, 'gen');
            //echo $this->functions->jsScript('jquery.chat/jquery.chat.js');
            //echo $this->functions->cssScript('jquery.chat.css', 'public/js/jquery.chat/');
        }
        ?>

        <?php //$this->functions->jsScript('jquery.functions/jquery.alerts/jquery.alerts.js')?>
<?php //$this->functions->cssScript('../js/jquery.alerts/jquery.alerts.css') ?>

<?php if ($googleMaps == true) : ?>
            <script type="text/javascript"
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbQLHbC3h7BuowGR0C1i1n-F6rDjcFL3s&sensor=true">
            </script>

            <?= $this->functions->jsScript('googleMaps.js') ?>
<?php endif; ?>

        <?php if ($ckeditor == true) : ?>
            <script type='text/javascript' src='/public/ckeditor4.3.3/ckeditor.js'></script>
            <script type='text/javascript' src='/public/ckeditor4.3.3/adapters/jquery.js'></script>
        <?php endif; ?>

<?php //if ($lightbox == true) echo $this->functions->jsScript('lightbox.js');  ?>

        <?php if ($lightbox == true) : ?>
            <script type="text/javascript" src="/public/js/ekko-lightbox.min.js"></script>
            <link type="text/css" href="/public/css/ekko-lightbox.min.css" rel="Stylesheet" />
        <?php endif; ?>

        <?php
// canonical tags for listing pages
        if (!empty($canonical))
            echo "<link rel='canonical' href='{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}{$canonical}' />" . PHP_EOL;
        ?>

        <?php if ($timeentry) : ?>
            <link rel="stylesheet" type="text/css" href="/public/timeentry2/jquery.timeentry.css"> 
            <script type="text/javascript" src="/public/timeentry2/jquery.plugin.js"></script> 
            <script type="text/javascript" src="/public/timeentry2/jquery.timeentry.js"></script>
<?php endif; ?>


        <?php if ($autosize) echo $this->functions->jsScript('autosize/jquery.autosize.js'); ?>


        <?php if ($masonry) : ?>
            <script type="text/javascript" src="/public/js/masonry.pkgd.min.js"></script>
        <?php endif; ?>

        <?php if ($justgal) : ?>
            <link rel="stylesheet" href="/public/justified-gallery3.1/css/justifiedGallery.min.css" />
            <script src="/public/justified-gallery3.1/js/jquery.justifiedGallery.min.js"></script>
        <?php endif; ?>

        <?php if ($slimscroll) : ?>
            <script type="text/javascript" src="/public/js/jquery.slimscroll.min.js"></script>
        <?php endif; ?>

        <?php if ($backstretch) : ?>
            <script src="/public/js/jquery-backstretch/jquery.backstretch.min.js"></script>
        <?php endif; ?>

        <?php
        if ($nailthumb) {
            echo $this->functions->jsScript('nailthumb/src/jquery.nailthumb.js');
            try {
                $less->checkedCompile("./public/js/nailthumb/src/nailthumb.less", './public/less/nailthumb.css');

                echo $this->functions->cssScript('nailthumb.css', '/public/less/');
            } catch (Exception $e) {
                $this->functions->sendStackTrace($e);
            }
        }
        ?>

        <?php
        if ($this->session->userdata('logged_in') === true) {

            echo <<< EOS
	<script type='text/javascript'>
	global.logged_in = true;
	global.userid = {$this->session->userdata('user_id')};
	</script>
EOS;
            echo PHP_EOL;
        }
        ?>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript" src="/public/js/advanced_search.js"></script>