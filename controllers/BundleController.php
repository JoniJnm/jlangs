<?php

namespace langs\controllers;

use langs\models\BundleModel;
use langs\tables\BundleTable;

class BundleController extends \JNMFW\BaseController {
	/**
	 * @var BundleModel
	 */
	private $bundleModel;
	
	public function __construct() {
		parent::__construct();
		$this->bundleModel = BundleModel::getInstance();
	}
	
	public function get() {
		$data = $this->bundleModel->getAll();
		$this->server->sendData($data);
	}
	
	public function add() {
		$name = $this->request->getCmd('name');
		
		$item = new BundleTable();
		$item->name = $name;
		$item->insert();
		
		$this->server->sendData($item->id);
	}
	
	public function delete() {
		$id_bundle = $this->request->getUInt('id_bundle');
		$this->bundleModel->delete($id_bundle);
		$this->server->sendOK();
	}
}
