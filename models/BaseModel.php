<?php

namespace langs\models;

use JNMFW\ModelBase;

abstract class BaseModel extends ModelBase
{
	protected function getObjByID($id, $name)
	{
		return parent::getByPrimaryKey($id, "langs\\tables\\" . $name . "Table", "langs\\objs\\" . $name);
	}

	protected function getObjsByIDs($ids, $name)
	{
		return parent::getMultiByPrimaryKey($ids, "langs\\tables\\" . $name . "Table", "langs\\objs\\" . $name);
	}
}
