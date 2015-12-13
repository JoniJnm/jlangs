<?php

namespace langs\objs;

use langs\tables\LangTable;

class Key extends \JNMFW\ObjBase {
	/**
	 * @return LangTable
	 */
	public function getItem() {
		return $this->item;
	}
}
