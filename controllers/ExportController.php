<?php

namespace langs\controllers;

use langs\models\LangModel;
use langs\models\LangsModel;
use langs\classes\LangsExporter;

class ExportController extends \JNMFW\ControllerBase {
	/**
	 * @var LangModel
	 */
	private $langModel;
	
	/**
	 * @var LangsModel
	 */
	private $langsModel;
	
	public function __construct() {
		parent::__construct();
		$this->langModel = LangModel::getInstance();
		$this->langsModel = LangsModel::getInstance();
	}
	
	public function json() {
		$langs = $this->langModel->getAll();
		$exporter = new LangsExporter($langs);
		$zipPath = $exporter->toJSON();
		
		$this->end($zipPath);
	}
	
	public function php_array() {
		$langs = $this->langModel->getAll();
		$exporter = new LangsExporter($langs);
		$zipPath = $exporter->toPHPArray();
		
		$this->end($zipPath);
	}
	
	public function php_class() {
		$langs = $this->langModel->getAll();
		$namespace = null;
		if (!$this->request->is_empty("namespace")) {
			$namespace = $this->request->getRegex("[a-z\\\\]+", "namespace");
		}
		$exporter = new LangsExporter($langs);
		$zipPath = $exporter->toPHPClass($namespace);
		
		$this->end($zipPath);
	}
	
	private function end($zipPath) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="langs.zip"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($zipPath));
		readfile($zipPath);
		exit;
	}
}
