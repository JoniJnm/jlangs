<?php

namespace langs\classes;

use langs\Config;
use langs\models\LangsModel;
use langs\tables\LangTable;

class LangsExporter
{
	/**
	 * @var LangTable[]
	 */
	private $langs;

	/**
	 * @var LangsModel
	 */
	private $langsModel;

	private $id_project;

	/**
	 * @param LangTable[] $langs
	 */
	public function __construct($id_project, $langs)
	{
		$this->id_project = $id_project;
		$this->langs = $langs;
		$this->langsModel = LangsModel::getInstance();
	}

	public function toJSON()
	{
		return $this->createZip(function ($dir) {
			$paths = array();
			foreach ($this->langs as $lang) {
				$path = "{$lang->code}.json";
				$file = $dir . "/" . $path;
				$data = $this->langsModel->getTexts($lang->id);
				$this->writeFile($file,
					json_encode($data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
				$paths[] = $path;
			}
			return $paths;
		});
	}

	public function toJSONVar($varname)
	{
		return $this->createZip(function ($dir) use ($varname) {
			$paths = array();
			foreach ($this->langs as $lang) {
				$path = "{$lang->code}.js";
				$file = $dir . "/" . $path;
				$data = $this->langsModel->getTexts($lang->id);
				$this->writeFile($file, $varname . ' = ' . json_encode($data,
						JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . ';');
				$paths[] = $path;
			}
			return $paths;
		});
	}

	public function toPHPArray()
	{
		return $this->createZip(function ($dir) {
			$paths = array();
			foreach ($this->langs as $lang) {
				$path = "{$lang->code}.php";
				$file = $dir . "/" . $path;
				$data = $this->langsModel->getTexts($lang->id);
				$content = "<?php\n\$_LANG = " . var_export($data, true) . ";";
				$this->writeFile($file, $content);
				$paths[] = $path;
			}
			return $paths;
		});
	}

	public function toMySQL()
	{
		$file = $this->getTempFile();
		$exec = "mysqldump -u" . Config::DB_USER . ' -p"' . Config::DB_PASSWORD . '"';
		$exec .= " " . Config::DB_NAME . " > '" . $file . "'";
		exec($exec);
		return $file;
	}

	public function toCSV()
	{
		$file = $this->getTempFile();
		$this->writeFile($file, '');
		$texts = $this->langsModel->getTextsByIDProject($this->id_project, $this->langs);
		if (!$texts) {
			return $file;
		}
		$codes = array_diff(array_keys(get_object_vars($texts[0])), array('param'));
		$this->exportCSVRow($file, array_merge(array(''), $codes)); //header
		foreach ($texts as $text) {
			$row = array();
			$row[] = $text->param;
			foreach ($codes as $code) {
				$row[] = $text->$code;
			}
			$this->exportCSVRow($file, $row);
		}
		return $file;
	}

	private function exportCSVRow($file, $row)
	{
		$str = implode(',', array_map(function ($value) {
				return '"' . $value . '"';
			}, $row)) . "\n";
		$this->writeFile($file, $str, true);
	}

	private function writeFile($file, $content, $append = false)
	{
		$dir = dirname($file);
		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
		$options = $append ? FILE_APPEND : 0;
		return file_put_contents($file, $content, $options);
	}

	public function toi18n()
	{
		return $this->createZip(function ($dir) {
			$paths = array();

			$path = 'nls/app.js';
			$file = $dir . "/" . $path;
			$data = array();
			for ($i = 1; $i < count($this->langs); $i++) {
				$data[$this->langs[$i]->code] = true;
			}
			$data['root'] = array();
			$this->writeFile($file, 'define(' . json_encode($data, JSON_PRETTY_PRINT) . ');');
			$paths[] = $path;

			foreach ($this->langs as $lang) {
				$path = "nls/{$lang->code}/app.js";
				$file = $dir . "/" . $path;
				$data = $this->langsModel->getTexts($lang->id);
				$this->writeFile($file, 'define(' . json_encode($data, JSON_PRETTY_PRINT) . ');');
				$paths[] = $path;
			}
			return $paths;
		});
	}

	private function createZip($func)
	{
		$dir = $this->createTempDir();
		if (!$dir) {
			throw new \Exception("Error creating temp directory");
		}

		$paths = $func($dir);

		$zip = new \ZipArchive();
		$zipPath = $this->getTempFile();

		if ($zip->open($zipPath, \ZipArchive::CREATE) !== true) {
			throw new \Exception("Error creating zip file");
		}

		foreach ($paths as $path) {
			$zip->addFile($dir . '/' . $path, $path);
		}
		$zip->close();

		$this->deleteDir($dir);

		return $zipPath;
	}

	private function createTempDir()
	{
		$folder = sys_get_temp_dir() . "/pos_" . microtime(true) . "-" . rand();
		mkdir($folder);
		if (is_dir($folder)) {
			return $folder;
		}
		else {
			return null;
		}
	}

	private function getTempFile()
	{
		return sys_get_temp_dir() . "/pos_" . microtime(true) . "-" . rand();
	}

	private function deleteDir($path)
	{
		if (is_file($path)) {
			unlink($path);
		}
		else {
			$func = array($this, __FUNCTION__);
			array_map($func, glob($path . '/*'));
			rmdir($path);
		}
	}
}
