<?php

namespace langs\objs;

use langs\tables\BundleTable;

class Bundle extends \JNMFW\BaseObj {
	/**
	 * @return BundleTable
	 */
	public function getItem() {
		return $this->item;
	}
}
