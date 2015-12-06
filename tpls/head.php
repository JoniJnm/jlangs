<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Langs</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" crossorigin="anonymous">
	
	<link rel="stylesheet" href="css/app.css" crossorigin="anonymous">
	
	<script src="//code.jquery.com/jquery-1.11.3.min.js" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" crossorigin="anonymous"></script>
	
	<script src="vendor/js/underscore.min.js"></script>
	<script src="vendor/js/jstemplate.min.js"></script>
	
	<script>
	var app = {
		models: {},
		views: {}
	};
	</script>
	
	<?php foreach (glob(dirname(__DIR__).'/js/*.js') as $file) : ?>
		<?php $file = basename($file); ?>
		<script src="js/<?= $file ?>"></script>
	<?php endforeach; ?>
</head>
