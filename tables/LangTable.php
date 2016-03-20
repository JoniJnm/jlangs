<?php

namespace langs\tables;

use langs\Config;

class LangTable extends \JNMFW\TableBase
{
	public $id;
	public $id_project;
	public $code;

	public function getPrimaryKey()
	{
		return 'id';
	}

	public function getTableName()
	{
		return Config::TABLE_PROJECTS;
	}
}
