<?php

namespace langs\tables;

use langs\Config;

class KeyTable extends \JNMFW\BaseTable {
	public $id_bundle;
	public $name;
	
	protected function getPrimaryKey() {
		return 'id';
	}

	protected function getTableName() {
		return Config::TABLE_KEYS;
	}
}
