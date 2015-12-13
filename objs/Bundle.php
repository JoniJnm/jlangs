<?php

namespace langs\objs;

use langs\tables\BundleTable;

class Bundle extends \JNMFW\ObjBase {
	/**
	 * @return BundleTable
	 */
	public function getItem() {
		return $this->item;
	}
}
