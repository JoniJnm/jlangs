<?php

namespace langs\objs;

use langs\tables\TextTable;

class Key extends \JNMFW\BaseObj {
	/**
	 * @return TextTable
	 */
	public function getItem() {
		return $this->item;
	}
}
