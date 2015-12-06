<?php

namespace langs\objs;

use langs\tables\LangTable;

class Key extends \JNMFW\BaseObj {
	/**
	 * @return LangTable
	 */
	public function getItem() {
		return $this->item;
	}
}
