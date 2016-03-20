<?php

namespace langs\classes;

use langs\models\KeyModel;

class LangImporter
{
	private $id_project;
	private $deleted;
	private $created;

	/**
	 * @var KeyModel
	 */
	private $keyModel;

	public function __construct($id_project)
	{
		$this->id_project = $id_project;
		$this->keyModel = KeyModel::getInstance();
	}

	public function fromDic($dic)
	{
		$hashes = array_keys($dic);
		$currentHashes = $this->keyModel->getHashesByIdProject($this->id_project);
		$hashesToDelete = array_diff($currentHashes, $hashes);
		$dicToCreate = array_filter($dic, function ($key) use ($currentHashes) {
			return !in_array($key, $currentHashes);
		}, ARRAY_FILTER_USE_KEY);

		if ($hashesToDelete) {
			$this->deleted = $this->keyModel->deleteByHashes($hashesToDelete);
		}
		else {
			$this->deleted = 0;
		}

		if ($dicToCreate) {
			$this->created = $this->keyModel->createFromDic($this->id_project, $dicToCreate);
		}
		else {
			$this->created = 0;
		}
	}

	public function getDeleted()
	{
		return $this->deleted;
	}

	public function getCreated()
	{
		return $this->created;
	}
}
