<?php

namespace langs\objs;

use JNMFW\ObjBase;
use langs\tables\ProjectTable;

class Project extends ObjBase
{
	/**
	 * @return ProjectTable
	 */
	public function getItem()
	{
		return $this->item;
	}
}
