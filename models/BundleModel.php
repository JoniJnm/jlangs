<?php

namespace langs\models;

use langs\objs\Bundle;
use langs\tables\BundleTable;
use langs\Config;

class BundleModel extends BaseModel {
	/**
	 * @return Bundle
	 */
	public function getByID($id) {
		return parent::getObjByID($id, 'Bundle');
	}
	
	/**
	 * @return Bundle[]
	 */
	public function getByIDs($ids) {
		return parent::getObjsByIDs($ids, 'Bundle');
	}
	
	/**
	 * @return BundleTable[]
	 */
	public function getByIdProject($id_project) {
		return $this->db->getQueryBuilderSelect(Config::TABLE_BUNDLES)
			->where('id_project', $id_project)
			->loadObjectList();
	}
	
	public function delete($id_bundle) {
		return $this->db->getQueryBuilderDelete(Config::TABLE_BUNDLES)
			->where('id', $id_bundle)
			->execute();
	}
}
