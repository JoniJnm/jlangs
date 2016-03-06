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
	
	public function createFromDic($id_project, $dic) {
		$query = $this->db->getQueryBuilderInsert(Config::TABLE_KEYS);
		foreach ($dic as $hash => $value) {
			$query->data(array(
				'id_project' => $id_project,
				'hash' => $hash,
				'default_value' => $value
			));
		}
		return $query->execute();
	}
	
	/**
	 * @return KeyTable[]
	 */
	public function getByIdProject($id_project) {
		return $this->db->getQueryBuilderSelect(Config::TABLE_KEYS)
			->where('id_project', $id_project)
			->loadObjectList(KeyTable::class);
	}
	
	public function deleteByHashes($hashes) {
		return $this->db->getQueryBuilderDelete(Config::TABLE_KEYS)
			->whereIn('hash', $hashes)
			->execute();
	}
	
	public function getHashesByIdProject($id_project) {
		return $this->db->getQueryBuilderSelect(Config::TABLE_KEYS)
			->columns('hash')
			->where('id_project', $id_project)
			->loadValueArray();
	}
	
	public function delete($id_key) {
		return $this->db->getQueryBuilderDelete(Config::TABLE_KEYS)
			->where('id', $id_key)
			->execute();
	}
}
