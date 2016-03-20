<?php

namespace langs\tables;

use langs\Config;

class TextTable extends \JNMFW\TableBase
{
	public $id_lang;
	public $id_key;
	public $value;

	public function getPrimaryKey()
	{
		return null;
	}

	public function getTableName()
	{
		return Config::TABLE_KEYS;
	}
}
