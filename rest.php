<?php

use JNMFW\classes\App;
use JNMFW\helpers\HTimer;

error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'OPTIONS') {
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
	exit;
}

require(__DIR__ . '/includes/init.php');

register_shutdown_function(function () {
	$last_error = error_get_last();
	if ($last_error && in_array($last_error['type'],
			array(E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR, E_RECOVERABLE_ERROR))
	) {
		//delete cache headers. If there is a 500 the output shouldn't be cached
		header('Cache-Control: no-store, no-cache, must-revalidate', true);
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT', true);
		\JNMFW\classes\databases\DBFactory::rollbackAllConnections();
	}

	$request = \JNMFW\classes\Request::getInstance();
	$request->setStrictMode(false);
	$controllerName = $request->getCmd('controller');
	$task = $request->getCmd('task');
	HTimer::end('Request', $controllerName . '::' . $task);
});

HTimer::init('Request');

(new App())
	->controllers('/rest', '\langs\controllers')
	->run();
