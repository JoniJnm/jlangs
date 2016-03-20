<?php

namespace langs\objs;

use JNMFW\ObjBase;
use langs\tables\LangTable;

class Key extends ObjBase
{
	/**
	 * @return LangTable
	 */
	public function getItem()
	{
		return $this->item;
	}
}
