<?php

namespace langs\controllers;

use langs\models\KeyModel;
use langs\tables\KeyTable;

class KeyController extends \JNMFW\ControllerBase {
	/**
	 * @var KeyModel
	 */
	private $keyModel;
	
	public function __construct($route) {
		parent::__construct($route);
		$this->keyModel = KeyModel::getInstance();
	}
	
	public function fetch() {
		$id_bundle = $this->request->getUInt('id_bundle');
		$data = $this->keyModel->getByIdBundle($id_bundle);
		$this->server->sendData($data);
	}
	
	public function create() {
		$id_bundle = $this->request->getUInt('id_bundle');
		$name = $this->request->getCmd('name');
		
		$item = new KeyTable();
		$item->id_bundle = $id_bundle;
		$item->name = $name;
		$item->insert();
		
		$this->server->sendData($item->id);
	}
	
	public function destroy() {
		$id_key = $this->request->getUInt('id_key');
		$this->keyModel->delete($id_key);
		$this->server->sendOK();
	}
}
