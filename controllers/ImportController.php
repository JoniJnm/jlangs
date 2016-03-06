<?php

namespace langs\controllers;

use langs\classes\LangImporter;

class ImportController extends BaseController {
	public function __construct($route) {
		parent::__construct($route);
		$this->route
			->post('/hashes');
	}
	
	private function isValidDic($dic) {
		if (!$dic || !is_array($dic)) {
			return false;
		}
		foreach ($dic as $hash => $value) {
			if (!preg_match('/[a-f0-9]{32}/', $hash)) {
				return false;
			}
			if (!is_string($value)) {
				return false;
			}
		}
		return true;
	}
	
	public function hashes() {
		$id_project = $this->request->getUInt('id_project');
		$file = $this->request->getFile('dic');
		$content = file_get_contents($file);
		$dic = json_decode($content, true);
		if (!$this->isValidDic($dic)) {
			$this->server->sendInvalidParameter('dic');
		}
		$importer = new LangImporter($id_project);
		$importer->fromDic($dic);
		$this->server->sendData(array(
			'created' => $importer->getCreated(),
			'deleted' => $importer->getDeleted()
		));
	}
}
