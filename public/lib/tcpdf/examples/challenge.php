<?php 
ini_set('display_errors', true);
error_reporting(E_ALL);
date_default_timezone_set('America/Los_Angeles');
?>
<?php 
/**
 * use http://news.google.com/?output=rss for testing
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>        
        <title>Code Challenge</title>      
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">               
        <!-- bootstrap 3.1.1 -->
        <script type="text/javascript" src="/public/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="/public/bootstrap3.1.1/js/bootstrap.min.js"></script>
        <link type="text/css" href="/public/bootstrap3.1.1/css/bootstrap.min.css" rel="Stylesheet" />
        <link type="text/css" href="/public/jquery-ui-1.10.4/css/blitzer/jquery-ui-1.10.4.custom.min.css" rel="Stylesheet" />
        <script type="text/javascript" src="/public/jquery-ui-1.10.4/js/jquery-ui-1.10.4.custom.min.js"></script>
        <link rel="shortcut icon" href="/public/images/double_helix.png" type="image/png">
        <link rel="icon" href="/public/images/double_helix.ico" type="image/png">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    	<link href="/public/css/custom-styles.css" rel="stylesheet">
    	<link href="/public/css/bootstrap-social.css" rel="stylesheet">
    	<!-- Custom Fonts -->    	
        <link href="/public/css/main.css" rel="stylesheet">
    	<link href="/public/css/media.css" rel="stylesheet">
    </head>    
    <body>
    
        <h1>CODE CHALLENGE</h1>
       
        <?php if(empty($_POST)):?>
            <form name="ccform" class="form" id="form" method="post" action="process.php">
                <input type="text" name="rsspage" id="rsspage" />
                <input type="submit" value="Submit" />
            </form>
        <?php endif;?>        
    </body>
</html>