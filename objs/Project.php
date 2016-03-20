<?php

namespace langs\objs;

use langs\tables\ProjectTable;

class Project extends \JNMFW\ObjBase
{
	/**
	 * @return ProjectTable
	 */
	public function getItem()
	{
		return $this->item;
	}
}
