<?php

namespace langs\models;

use langs\Config;

class LangsModel extends \JNMFW\ModelSimple
{
	public function getTexts($id_lang)
	{
		$data = $this->db->getQueryBuilderSelect(Config::TABLE_VALUES, 'v')
			->innerJoin(Config::TABLE_KEYS, 'k', 'v.id_key', 'k.id')
			->columns(array('v.text', 'k.hash'))
			->where('v.id_lang', $id_lang)
			->loadObjectList();
		$out = array();
		foreach ($data as $row) {
			$out[$row->hash] = $row->text;
		}
		return $out;
	}

	public function getTextsByIDProject($id_project, $langs)
	{
		$query = $this->db->getQueryBuilderSelect(Config::TABLE_KEYS, 'k')
			->columns(array('k.hash', 'k.default_text'))
			->where('k.id_project', $id_project);

		foreach ($langs as $lang) {
			$code = $lang->code;
			$tableAlias = 'l' . $code;
			$query = $query
				->columns($tableAlias . '.text AS ' . $code)
				->customJoin('LEFT', Config::TABLE_VALUES, $tableAlias, $this->db->createConditionAnds()
					->whereColumns($tableAlias . '.id_key', 'k.id')
					->where($tableAlias . '.id_lang', $lang->id)
				);
		}

		return $query->loadObjectList();
	}
}
