<?php

namespace Tienda\includes;

use JNMFW\classes\databases\DBFactory;
use JNMFW\classes\databases\mysqli\MySQLiDriver;
use JNMFW\helpers\HLog;
use langs\Config;

require('jnmfw/AutoLoad.php');

\spl_autoload_register(function ($className) {
	\JNMFW\jnmfw_autoload($className, 'langs', dirname(__DIR__));
});

$logfile = Config::APACHE_LOG_FILE;
if ($logfile) {
	if (substr($logfile, 0, 1) != '/') {
		$logfile = dirname(__DIR__) . '/' . $logfile;
	}
	ini_set("error_log", $logfile);
}

$logfile = Config::LOG_FILE;
if ($logfile) {
	if (substr($logfile, 0, 1) != '/') {
		$logfile = dirname(__DIR__) . '/' . $logfile;
	}
	HLog::setFile($logfile);
}

HLog::setLevel(Config::LOG_LEVEL);

$driver = new MySQLiDriver(Config::DB_SERVER, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME);
$driver->setPrefix(Config::DB_PREFIX);

DBFactory::registerDefaultInstance($driver);