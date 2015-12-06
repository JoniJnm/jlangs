<?php

namespace langs\models;

use langs\objs\Key;
use langs\tables\KeyTable;
use langs\Config;

class KeyModel extends BaseModel {
	/**
	 * @return Key
	 */
	public function getByID($id) {
		return parent::getObjByID($id, 'Key');
	}
	
	/**
	 * @return Key[]
	 */
	public function getByIDs($ids) {
		return parent::getObjsByIDs($ids, 'Key');
	}
	
	/**
	 * @return KeyTable[]
	 */
	public function getByIdBundle($id_bundle) {
		return $this->db->getQueryBuilderSelect(Config::TABLE_KEYS)
			->where('id_bundle', $id_bundle)
			->loadObjectList();
	}
	
	public function delete($id_key) {
		return $this->db->getQueryBuilderDelete(Config::TABLE_KEYS)
			->where('id', $id_key)
			->execute();
	}
}
