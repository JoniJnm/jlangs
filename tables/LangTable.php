<?php

namespace langs\tables;

use langs\Config;

class LangTable extends \JNMFW\BaseTable {
	public $id;
	public $code;
	
	protected function getPrimaryKey() {
		return 'id';
	}

	protected function getTableName() {
		return Config::TABLE_LANGS;
	}
}
