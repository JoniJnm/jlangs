<?php

namespace langs\controllers;

use langs\models\ProjectModel;
use langs\tables\ProjectTable;

class ProjectController extends \JNMFW\ControllerBase {
	/**
	 * @var ProjectModel
	 */
	private $projectModel;
	
	public function __construct() {
		parent::__construct();
		$this->projectModel = ProjectModel::getInstance();
	}
	
	public function get() {
		$data = $this->projectModel->getAll();
		$this->server->sendData($data);
	}
	
	public function add() {
		$name = $this->request->getCmd('name');
		
		$item = new ProjectTable();
		$item->name = $name;
		$item->insert();
		
		$this->server->sendData($item->id);
	}
	
	public function delete() {
		$id_project = $this->request->getUInt('id_project');
		$this->projectModel->delete($id_project);
		$this->server->sendOK();
	}
}
