<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Langs</title>

	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">

	<link rel="stylesheet" href="css/app.css">

	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="bower_components/underscore/underscore-min.js"></script>
	<script src="bower_components/jstemplate/dist/jstemplate.min.js"></script>

	<script>
		var app = {
			models: {},
			views: {}
		};
	</script>

	<?php foreach (glob(dirname(__DIR__) . '/js/*.js') as $file) : ?>
		<?php $file = basename($file); ?>
		<script src="js/<?= $file ?>"></script>
	<?php endforeach; ?>

</head>
