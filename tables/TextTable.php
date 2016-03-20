<?php

namespace langs\tables;

use JNMFW\TableBase;
use langs\Config;

class TextTable extends TableBase
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
