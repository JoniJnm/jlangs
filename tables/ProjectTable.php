<?php

namespace langs\tables;

use JNMFW\TableBase;
use langs\Config;

class ProjectTable extends TableBase
{
	public $id;
	public $name;

	public function getPrimaryKey()
	{
		return 'id';
	}

	public function getTableName()
	{
		return Config::TABLE_PROJECTS;
	}
}
