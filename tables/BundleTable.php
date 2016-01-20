<?php

namespace langs\tables;

use langs\Config;

class BundleTable extends \JNMFW\TableBase {
	public $id;
	public $name;
	public $id_project;
	
	public function getPrimaryKey() {
		return 'id';
	}

	public function getTableName() {
		return Config::TABLE_BUNDLES;
	}
}
