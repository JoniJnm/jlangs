<?php

namespace langs\controllers;

use langs\models\BundleModel;
use langs\tables\BundleTable;

class BundleController extends \JNMFW\ControllerBase {
	/**
	 * @var BundleModel
	 */
	private $bundleModel;
	
	public function __construct() {
		parent::__construct();
		$this->bundleModel = BundleModel::getInstance();
	}
	
	public function get() {
		$id_project = $this->request->getUInt('id_project');
		$data = $this->bundleModel->getByIdProject($id_project);
		$this->server->sendData($data);
	}
	
	public function add() {
		$id_project = $this->request->getUInt('id_project');
		$name = $this->request->getCmd('name');
		
		$item = new BundleTable();
		$item->id_project = $id_project;
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
