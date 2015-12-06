<?php

namespace langs\includes;

abstract class BaseConfig {
	const VERSION_SOFTWARE = "001";
	
	const DEVELOPEMENT = true;
	
	const LOG_FILE = 'logs/langs.log';
	const LOG_LEVEL = 2; //0:verbose, 1:debug, 2:warning, 3:error, 4:none
	
	const APACHE_LOG_FILE = 'logs/apache.log';
	
	const TABLE_BUNDLES = '#__bundles';
	const TABLE_KEYS = '#__keys';
	const TABLE_LANGS = '#__langs';
	const TABLE_VALUES = '#__values';
}
