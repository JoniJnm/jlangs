<?php

namespace langs\controllers;

use langs\models\KeyModel;

class KeyController extends BaseController {
	/**
	 * @var KeyModel
	 */
	private $keyModel;
	
	public function __construct($route) {
		parent::__construct($route);
		$this->keyModel = KeyModel::getInstance();
		$this->addDefaultRoute();
	}
	
	public function fetch() {
		$id_project = $this->request->getUInt('id_project');
		$data = $this->keyModel->getByIdProject($id_project);
		$this->server->sendData($data);
	}
	
	public function destroy() {
		$id_key = $this->request->getUInt('id');
		$this->keyModel->delete($id_key);
		$this->server->sendOK();
	}
}
