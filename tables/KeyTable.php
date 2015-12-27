<?php

namespace langs\tables;

use langs\Config;

class KeyTable extends \JNMFW\TableBase {
	public $id_bundle;
	public $name;
	
	public function getPrimaryKey() {
		return 'id';
	}

	public function getTableName() {
		return Config::TABLE_KEYS;
	}
}
