<?php

namespace langs\tables;

use JNMFW\TableBase;
use langs\Config;

class KeyTable extends TableBase
{
	public $id;
	public $id_project;
	public $hash;
	public $default_value;

	public function getPrimaryKey()
	{
		return 'id';
	}

	public function getTableName()
	{
		return Config::TABLE_KEYS;
	}
}
