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
		
		$this->end($zipPath, 'langs.zip');
	}
	
	public function php_array() {
		$langs = $this->langModel->getAll();
		$exporter = new LangsExporter($langs);
		$zipPath = $exporter->toPHPArray();
		
		$this->end($zipPath, 'langs.zip');
	}
	
	public function php_class() {
		$langs = $this->langModel->getAll();
		$namespace = null;
		if (!$this->request->is_empty("namespace")) {
			$namespace = $this->request->getRegex("[a-z\\\\]+", "namespace");
		}
		$exporter = new LangsExporter($langs);
		$zipPath = $exporter->toPHPClass($namespace);
		
		$this->end($zipPath, 'langs.zip');
	}
	
	public function mysql() {
		$langs = $this->langModel->getAll();
		$exporter = new LangsExporter($langs);
		$filePath = $exporter->toMySQL();
		
		$this->end($filePath, 'langs.sql');
	}
	
	private function end($filePath, $fileName) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="'.$fileName.'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filePath));
		readfile($filePath);
		unlink($filePath);
		exit;
	}
}
