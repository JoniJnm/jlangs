<?php

namespace langs\objs;

use langs\tables\KeyTable;

class Key extends \JNMFW\BaseObj {
	/**
	 * @return KeyTable
	 */
	public function getItem() {
		return $this->item;
	}
}
