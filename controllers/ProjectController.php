<?php

namespace langs\controllers;

use langs\models\ProjectModel;
use langs\tables\ProjectTable;

class ProjectController extends \JNMFW\ControllerBase {
	/**
	 * @var ProjectModel
	 */
	private $projectModel;
	
	public function __construct($route) {
		parent::__construct($route);
		$this->projectModel = ProjectModel::getInstance();
		$this->route
			->addDefaults();
	}
	
	public function fetch() {
		$data = $this->projectModel->getAll();
		$this->server->sendData($data);
	}
	
	public function create() {
		$name = $this->request->getCmd('name');
		
		$item = new ProjectTable();
		$item->name = $name;
		$item->insert();
		
		$this->server->sendData($item->id);
	}
	
	public function destroy() {
		$id_project = $this->request->getUInt('id');
		$this->projectModel->delete($id_project);
		$this->server->sendOK();
	}
}
