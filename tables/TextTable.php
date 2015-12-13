<?php

namespace langs\tables;

use langs\Config;

class TextTable extends \JNMFW\TableBase {
	public $id_lang;
	public $id_key;
	public $value;
	
	protected function getPrimaryKey() {
		return null;
	}

	protected function getTableName() {
		return Config::TABLE_KEYS;
	}
}
