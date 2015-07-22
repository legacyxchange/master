<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	
	
	
	
	
</head>
<body>

<div class="container">
	<div class="content">			
		<div class="title">Payday Calculator</div>	
		<form name="payday" action="payday_calculator.php" method="post">			    
			<div class="form-group">
				<label for="paydate">First Pay Date</label>  
				<input type="date" name="paydate" value="<?php echo !empty($_POST['paydate']) ? $_POST['paydate'] : date('Y-m-d');?>" min="1970-01-01" placeholder="First Pay Date">
				<br>
				<label for="payday_interval">Pay Day Interval</label>
				<select name="payday_interval">
					<option value="weekly">Weekly</option>
					<option value="bi-weekly">Bi-weekly</option>
					<option value="monthly">Monthly</option>
					<option value="semi-monthly">Semi-monthly</option>
				</select>
			</div>                    
			<input type="submit" value="Calculate Next Payday" />				
		</form>							
	</div>
</div>
</body>

</html>