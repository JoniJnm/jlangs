<?php

namespace langs\models;

abstract class BaseModel extends \JNMFW\ModelBase {
	protected function getObjByID($id, $name) {
		return parent::getByPrimaryKey($id, "langs\\tables\\".$name."Table", "langs\\objs\\".$name);
	}
	
	protected function getObjsByIDs($ids, $name) {
		return parent::getMultiByPrimaryKey($ids, "langs\\tables\\".$name."Table", "langs\\objs\\".$name);
	}
}
