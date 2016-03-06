<?php

namespace langs\tables;

use langs\Config;

class KeyTable extends \JNMFW\TableBase {
	public $id;
	public $id_project;
	public $hash;
	public $default_value;
	
	public function getPrimaryKey() {
		return 'id';
	}

	public function getTableName() {
		return Config::TABLE_KEYS;
	}
}
