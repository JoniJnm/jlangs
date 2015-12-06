<?php

namespace langs\models;

use langs\objs\Lang;
use langs\tables\LangTable;
use langs\Config;

class LangModel extends BaseModel {
	/**
	 * @return Lang
	 */
	public function getByID($id) {
		return parent::getObjByID($id, 'Lang');
	}
	
	/**
	 * @return Lang[]
	 */
	public function getByIDs($ids) {
		return parent::getObjsByIDs($ids, 'Lang');
	}
	
	/**
	 * @return LangTable[]
	 */
	public function getAll() {
		return $this->db->getQueryBuilderSelect(Config::TABLE_LANGS)
			->loadObjectList();
	}
}
