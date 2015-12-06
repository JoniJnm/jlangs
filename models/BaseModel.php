<?php

namespace langs\models;

abstract class BaseModel extends \JNMFW\BaseModel {
	protected function getObjByID($id, $name) {
		return parent::getByPrimaryKey($id, "Tienda\\tables\\".$name."Table", "Tienda\\objs\\".$name);
	}
	
	protected function getObjsByIDs($ids, $name) {
		return parent::getMultiByPrimaryKey($ids, "Tienda\\tables\\".$name."Table", "Tienda\\objs\\".$name);
	}
}
