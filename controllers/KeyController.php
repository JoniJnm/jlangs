<?php

namespace langs\controllers;

use langs\models\KeyModel;
use langs\tables\KeyTable;

class KeyController extends \JNMFW\BaseController {
	/**
	 * @var KeyModel
	 */
	private $keyModel;
	
	public function __construct() {
		parent::__construct();
		$this->keyModel = KeyModel::getInstance();
	}
	
	public function get() {
		$id_bundle = $this->request->getUInt('id_bundle');
		$data = $this->keyModel->getByIdBundle($id_bundle);
		$this->server->sendData($data);
	}
	
	public function add() {
		$id_bundle = $this->request->getUInt('id_bundle');
		$name = $this->request->getCmd('name');
		
		$item = new KeyTable();
		$item->id_bundle = $id_bundle;
		$item->name = $name;
		$item->insert();
		
		$this->server->sendData($item->id);
	}
	
	public function delete() {
		$id_key = $this->request->getUInt('id_key');
		$this->keyModel->delete($id_key);
		$this->server->sendOK();
	}
}
