<?php

namespace langs\models;

use langs\Config;
use langs\objs\Value;
use langs\tables\ValueTable;

class TextModel extends BaseModel
{
	/**
	 * @param $id
	 * @return Value
	 */
	public function getByID($id)
	{
		return parent::getObjByID($id, 'Key');
	}

	/**
	 * @param $ids
	 * @return \langs\objs\Value[]
	 */
	public function getByIDs($ids)
	{
		return parent::getObjsByIDs($ids, 'Key');
	}

	/**
	 * @param $id_key
	 * @return \langs\tables\ValueTable[]
	 */
	public function getByIdKey($id_key)
	{
		$id_project = $this->db->getQueryBuilderSelect(Config::TABLE_KEYS)
			->columns('id_project')
			->where('id', $id_key)
			->loadValue();

		return $this->db->getQueryBuilderSelect(Config::TABLE_LANGS, 'l')
			->columns(array('l.id AS id_lang', 'v.text', 'l.code AS lang_code'))
			->customJoin('LEFT', Config::TABLE_VALUES, 'v', $this->db->createConditionAnds()
				->whereColumns('v.id_lang', 'l.id')
				->where('v.id_key', $id_key)
			)
			->where('l.id_project', $id_project)
			->order('l.id')
			->loadObjectList();
	}

	public function save($id_lang, $id_key, $text)
	{
		return $this->db->getQueryBuilderInsert(Config::TABLE_VALUES)
			->data(array(
				'id_lang' => $id_lang,
				'id_key' => $id_key,
				'text' => $text
			))
			->onDuplicateUpdateColumns(array('text'))
			->execute();
	}

	public function delete($id_lang, $id_key)
	{
		return $this->db->getQueryBuilderDelete(Config::TABLE_VALUES)
			->where('id_lang', $id_lang)
			->where('id_key', $id_key)
			->execute();
	}
}
