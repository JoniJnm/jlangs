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
	
	public function toJSON() {
		return $this->createZip(function($dir) {
			$files = array();
			foreach ($this->langs as $lang) {
				$file = $dir."/{$lang->code}.json";
				$data = $this->langsModel->getTexts($lang->id);
				file_put_contents($file, json_encode($data));
				$files[] = $file;
			}
			return $files;
		});
	}
	
	public function toPHPArray() {
		return $this->createZip(function($dir) {
			$files = array();
			foreach ($this->langs as $lang) {
				$file = $dir."/{$lang->code}.php";
				$data = $this->langsModel->getTexts($lang->id);
				$content = "<?php\n\$_LANG = ".var_export($data, true).";";
				file_put_contents($file, $content);
				$files[] = $file;
			}
			return $files;
		});
	}
	
	public function toPHPClass($namespace) {
		return $this->createZip(function($dir) use ($namespace) {
			$files = array();
			$keys = array();
			foreach ($this->langs as $lang) {
				$code = strtoupper($lang->code);
				$file = $dir."/Lang{$code}.php";
				$data = $this->langsModel->getTexts($lang->id);
				$content = "<?php\n\n";
				if ($namespace) $content .= "namespace ".$namespace.";\n\n";
				$content .= "class Lang{$code} {\n";
				foreach ($data as $bundle => $_data) {
					foreach ($_data as $key => $text) {
						$k = $bundle."_".$key;
						$content .= "\tconst $k = '".addslashes($text)."';\n";
					}
				}
				$keys = array_merge($keys, array_keys($_data));
				$content .= "}";
				
				file_put_contents($file, $content);
				$files[] = $file;
			}
			
			$file = $dir."/Lang.php";
			$content = "<?php\n\n";
			if ($namespace) $content .= "namespace ".$namespace.";\n\n";
			$content .= "class Lang {\n";
			foreach ($keys as $key) {
				$content .= "\tconst $key = '{$key}';\n";
			}
			$content .= "}";
			file_put_contents($file, $content);
			$files[] = $file;
			
			return $files;
		});
	}
	
	public function createZip($func) {
		$dir = $this->createTempDir();
		if (!$dir) {
			throw new \Exception("Error creating temp directory");
		}
		
		$files = $func($dir);
		
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
