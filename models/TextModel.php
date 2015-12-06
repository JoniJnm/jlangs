<?php

namespace langs\models;

use langs\objs\Value;
use langs\tables\ValueTable;
use langs\Config;

class TextModel extends BaseModel {
	/**
	 * @return Value
	 */
	public function getByID($id) {
		return parent::getObjByID($id, 'Key');
	}
	
	/**
	 * @return Value[]
	 */
	public function getByIDs($ids) {
		return parent::getObjsByIDs($ids, 'Key');
	}
	
	/**
	 * @return ValueTable[]
	 */
	public function getByIdKey($id_key) {
		return $this->db->getQueryBuilderSelect(Config::TABLE_VALUES, 'v')
			->columns(array('l.id AS id_lang', 'v.text', 'l.code AS lang_code'))
			->customJoin('RIGHT', Config::TABLE_LANGS, 'l', $this->db->createConditionAnds()
				->whereColumns('v.id_lang', 'l.id')
				->where('id_key', $id_key)
			)
			->order('l.id')
			->loadObjectList();
	}
	
	public function save($id_lang, $id_key, $text) {
		return $this->db->getQueryBuilderInsert(Config::TABLE_VALUES)
			->data(array(
				'id_lang' => $id_lang,
				'id_key' => $id_key,
				'text' => $text
			))
			->onDuplicateUpdateColumns(array('text'))
			->execute();
	}
	
	public function delete($id_lang, $id_key) {
		return $this->db->getQueryBuilderDelete(Config::TABLE_VALUES)
			->where('id_lang', $id_lang)
			->where('id_key', $id_key)
			->execute();
	}
}
