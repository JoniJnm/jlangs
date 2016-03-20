<?php

namespace langs\objs;

use JNMFW\ObjBase;
use langs\tables\KeyTable;

class Key extends ObjBase
{
	/**
	 * @return KeyTable
	 */
	public function getItem()
	{
		return $this->item;
	}
}
