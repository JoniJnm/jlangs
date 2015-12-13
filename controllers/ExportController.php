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
	
	public function getAll() {
		$langs = $this->langModel->getAll();
		$exporter = new LangsExporter($langs);
		$zipPath = $exporter->createZip();
		
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
