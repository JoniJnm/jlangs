<?php

namespace langs\classes;

use langs\tables\LangTable;
use langs\models\LangsModel;

class LangsExporter {
	/**
	 * @var LangTable[] 
	 */
	private $langs;
	
	/**
	 * @var LangsModel
	 */
	private $langsModel;
	
	/**
	 * @param LangTable[] $langs
	 */
	public function __construct($langs) {
		$this->langs = $langs;
		$this->langsModel = LangsModel::getInstance();
	}
	
	public function createZip() {
		$dir = $this->createTempDir();
		if (!$dir) {
			throw new \Exception("Error creating temp directory");
		}
		
		$files = array();
		foreach ($this->langs as $lang) {
			$data = $this->langsModel->getTexts($lang->id);
			$file = $dir."/{$lang->code}.json";
			file_put_contents($file, json_encode($data));
			$files[] = $file;
		}
		
		$zip = new \ZipArchive();
		$zipPath = $dir.'/langs.zip';
		
		if ($zip->open($zipPath, \ZipArchive::CREATE) !== true) {
			throw new \Exception("Error creating zip file");
		}
		
		foreach ($files as $file) {
			$zip->addFile($file, basename($file));
		}
		$zip->close();
		
		return $zipPath;
	}
	
	private function createTempDir() {
		$tempfile = tempnam(sys_get_temp_dir(), '');
		if (file_exists($tempfile)) { 
			unlink($tempfile);
			mkdir($tempfile);
			if (is_dir($tempfile)) {
				return $tempfile;
			}
		}
		return null;
	}
}
