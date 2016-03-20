<?php

namespace langs\objs;

use JNMFW\ObjBase;
use langs\tables\TextTable;

class Key extends ObjBase
{
	/**
	 * @return TextTable
	 */
	public function getItem()
	{
		return $this->item;
	}
}
