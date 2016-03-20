<?php

namespace langs\models;

use langs\Config;
use langs\objs\Lang;

class LangModel extends BaseModel
{
	/**
	 * @param $id
	 * @return Lang
	 */
	public function getByID($id)
	{
		return parent::getObjByID($id, 'Lang');
	}

	/**
	 * @param $ids
	 * @return \langs\objs\Lang[]
	 */
	public function getByIDs($ids)
	{
		return parent::getObjsByIDs($ids, 'Lang');
	}

	/**
	 * @param $id_project
	 * @return \langs\tables\LangTable[]
	 */
	public function getByIdProject($id_project)
	{
		return $this->db->getQueryBuilderSelect(Config::TABLE_LANGS)
			->where('id_project', $id_project)
			->loadObjectList();
	}
}
