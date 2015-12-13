<?php

namespace langs\objs;

use langs\tables\KeyTable;

class Key extends \JNMFW\ObjBase {
	/**
	 * @return KeyTable
	 */
	public function getItem() {
		return $this->item;
	}
}
