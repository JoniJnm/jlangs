<?php

namespace langs\objs;

use langs\tables\TextTable;

class Key extends \JNMFW\ObjBase {
	/**
	 * @return TextTable
	 */
	public function getItem() {
		return $this->item;
	}
}
