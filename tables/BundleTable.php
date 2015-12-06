<?php

namespace langs\tables;

use langs\Config;

class BundleTable extends \JNMFW\BaseTable {
	public $id;
	public $name;
	
	protected function getPrimaryKey() {
		return 'id';
	}

	protected function getTableName() {
		return Config::TABLE_BUNDLES;
	}
}
