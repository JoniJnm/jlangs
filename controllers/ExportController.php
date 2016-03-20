<?php

namespace langs\controllers;

use langs\classes\LangsExporter;
use langs\models\LangModel;
use langs\models\LangsModel;

class ExportController extends BaseController
{
	/**
	 * @var LangModel
	 */
	private $langModel;

	/**
	 * @var LangsModel
	 */
	private $langsModel;

	public function __construct($route)
	{
		parent::__construct($route);
		$this->langModel = LangModel::getInstance();
		$this->langsModel = LangsModel::getInstance();
		$this->route
			->get('/json')
			->get('/json_var')
			->get('/php_array')
			//->get('/mysql')
			->get('/csv')
			->get('/i18n');
	}

	/**
	 * @return LangsExporter
	 */
	private function getExporter()
	{
		$id_project = $this->request->getUInt('id_project');
		$langs = $this->langModel->getByIdProject($id_project);
		return new LangsExporter($id_project, $langs);
	}

	public function json()
	{
		$exporter = $this->getExporter();
		$zipPath = $exporter->toJSON();

		$this->endZip($zipPath, 'langs.zip');
	}

	public function json_var()
	{
		$varname = 'lang';
		if (!$this->request->is_empty("varname")) {
			$varname = $this->request->getCmd('varname');
		}
		$exporter = $this->getExporter();
		$zipPath = $exporter->toJSONVar($varname);

		$this->endZip($zipPath, 'langs.zip');
	}

	public function php_array()
	{
		$exporter = $this->getExporter();
		$zipPath = $exporter->toPHPArray();

		$this->endZip($zipPath, 'langs.zip');
	}

	public function mysql()
	{
		$exporter = $this->getExporter();
		$filePath = $exporter->toMySQL();

		$this->end($filePath, 'langs.sql', 'text/sql');
	}

	public function csv()
	{
		$exporter = $this->getExporter();
		$filePath = $exporter->toCSV();
		$this->end($filePath, 'langs.csv', 'text/csv');
	}

	public function i18n()
	{
		$exporter = $this->getExporter();
		$zipPath = $exporter->toi18n();
		$this->endZip($zipPath, 'langs.zip');
	}

	private function endZip($filePath, $fileName)
	{
		$this->end($filePath, $fileName, 'application/zip');
	}

	private function end($filePath, $fileName, $contentType)
	{
		header('Content-Description: File Transfer');
		header('Content-Type: ' . $contentType);
		header('Content-Disposition: attachment; filename="' . $fileName . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filePath));
		readfile($filePath);
		unlink($filePath);
		exit;
	}
}
