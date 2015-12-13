<?php

namespace langs\tables;

use langs\Config;

class LangTable extends \JNMFW\TableBase {
	public $id;
	public $code;
	
	protected function getPrimaryKey() {
		return 'id';
	}

	protected function getTableName() {
		return Config::TABLE_LANGS;
	}
}
