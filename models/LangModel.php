<?php

namespace langs\models;

use langs\Config;
use langs\objs\Lang;
use langs\tables\LangTable;

class LangModel extends BaseModel
{
	/**
	 * @return Lang
	 */
	public function getByID($id)
	{
		return parent::getObjByID($id, 'Lang');
	}

	/**
	 * @return Lang[]
	 */
	public function getByIDs($ids)
	{
		return parent::getObjsByIDs($ids, 'Lang');
	}

	/**
	 * @return LangTable[]
	 */
	public function getByIdProject($id_project)
	{
		return $this->db->getQueryBuilderSelect(Config::TABLE_LANGS)
			->where('id_project', $id_project)
			->loadObjectList();
	}
}
