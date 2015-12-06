<?php

namespace langs\models;

use langs\Config;

class LangsModel extends \JNMFW\SimpleModel {
	public function getTexts($id_lang) {
		$data = $this->db->getQueryBuilderSelect(Config::TABLE_VALUES, 'v')
				->innerJoin(Config::TABLE_KEYS, 'k', 'v.id_key', 'k.id')
				->innerJoin(Config::TABLE_BUNDLES, 'b', 'b.id', 'k.id_bundle')
				->columns(array('v.text', 'k.name AS `key`', 'b.name AS bundle'))
				->where('v.id_lang', $id_lang)
				->loadObjectList();
		$out = array();
		foreach ($data as $row) {
			$bundle = $row->bundle;
			if (!isset($out[$bundle])) {
				$out[$bundle] = array();
			}
			$out[$bundle][$row->key] = $row->text;
		}
		return $out;
	}
}
