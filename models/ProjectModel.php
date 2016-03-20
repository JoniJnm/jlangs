<?php

namespace langs\models;

use langs\Config;
use langs\objs\Project;
use langs\tables\ProjectTable;

class ProjectModel extends BaseModel
{
	/**
	 * @param $id
	 * @return Project
	 */
	public function getByID($id)
	{
		return parent::getObjByID($id, 'Project');
	}

	/**
	 * @param $ids
	 * @return \langs\objs\Project[]
	 */
	public function getByIDs($ids)
	{
		return parent::getObjsByIDs($ids, 'Project');
	}

	/**
	 * @return ProjectTable[]
	 */
	public function getAll()
	{
		return $this->db->getQueryBuilderSelect(Config::TABLE_PROJECTS)
			->loadObjectList();
	}

	public function delete($id_project)
	{
		return $this->db->getQueryBuilderDelete(Config::TABLE_PROJECTS)
			->where('id', $id_project)
			->execute();
	}
}
