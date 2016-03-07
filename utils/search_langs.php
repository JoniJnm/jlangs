<?php

if (!php_sapi_name() === 'cli') {
	die("Only cli");
}
elseif (count($argv) != 5) {
	die('Must be 4 args: \n- folder to search \n- extensions \n- functions names \n- output file \n');
}

$folder = $argv[1];
$exts = explode(',', $argv[2]);
$funcs = explode(',', $argv[3]);
$output = $argv[4];

if (!is_dir($folder)) {
	die("The folder must exists");
}

search_langs($folder, $exts, $funcs, $output);

function search_langs($folderSearch, $exts, $funcNames, $fileOutput, $exc_folders = array(".git", 'node_modules', 'bower_components', 'lib', 'libs', 'vendor')) {
	$files = listAllFiles($folderSearch, array(
		'include_exts' => $exts,
		'exclude_folders' => $exc_folders
	));
	foreach ($files as $file) {
		$file = $folderSearch.'/'.$file;
		preg_match_all("/[^a-zA-Z0-9\-_](?:".implode('|', $funcNames).")\s?\((.*?(?:\"|'))\)/", file_get_contents($file), $matchs);
		if (!$matchs) continue;
		foreach ($matchs[1] as $m) {
			$text = trim($m);
			$text = trim($text, $text[0]);
			$out[md5($text)] = $text;
		}
	}
	file_put_contents($fileOutput, json_encode($out, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
}

function isset_else(&$var, $def = null) {
	return isset($var) ? $var : $def;
}

function getExt($url, $lowercase = false) {
	$pos = strrpos($url, '.');
	if ($pos === false) return null;
	$url = substr($url, $pos+1);
	if ($lowercase) return strtolower($url);
	else return $url;
}

/*
 * ops:
 * 		include_exts array. Sólo se devolverán las extensiones de este listado (por defecto vacío)
 *		exclude_folders array. Nombres de carpetas a excluir en la búsqueda de archivos (por defecto vacío)
 * 		level_min int. A partir de qué nivel de carpetas empieza a listar (por defecto 0)
 * 		level_max int. Hasta qué nivel máximo lista (por defecto -1, -1 infinito)
 *		relativeFolder. A partir de qué carpeta relativa hacer la búsqueda (por defecto vacío)
 * 		get_files. Se devolverán los archivos (por defecto true)
 * 		get_folders. Se devolverán las carpetas (por defecto false)
 */
function listAllFiles($baseFolder, $ops = array()) {
	$relativeFolder = isset_else($ops['relativeFolder'], '');
	$rfolder = trim($relativeFolder, '/');
	$level = $rfolder ? substr_count($rfolder, '/') + 1 : 0;
	
	$include_exts = isset_else($ops['include_exts'], array());
	$exclude_folders = isset_else($ops['exclude_folders'], array());
	$level_min = isset_else($ops['level_min'], 0);
	$level_max = isset_else($ops['level_max'], -1);
	$get_files = isset_else($ops['get_files'], true);
	$get_folders = isset_else($ops['get_folders'], false);
	$_level_computed = isset_else($ops['_level_computed'], false);

	if (!$_level_computed) {
		$level_min += $level;
		if ($level_max != -1) $level_max += $level;
		$ops['_level_computed'] = true;
		$ops['level_min'] = $level_min;
		$ops['level_max'] = $level_max;
	}

	if ($level_min < 0 || ($level_max >= 0 && $level > $level_max)) return array();

	$folder = $baseFolder.'/'.$relativeFolder;
	if (!is_dir($folder)) return array();
	$out = array();
	foreach (scandir($folder) as $file) {
		if ($file == '.' || $file == '..') continue;
		if (is_dir($folder.'/'.$file)) {
			if (in_array($file, $exclude_folders)) {
				continue;
			}
			if ($get_folders) {
				$value = ltrim($relativeFolder.'/'.$file, '/');
				$out[] = $value;
			}
			$ops['relativeFolder'] = $relativeFolder.'/'.$file;
			$more = listAllFiles($baseFolder, $ops);
			$out = array_merge($out, $more);
		}
		elseif ($get_files && $level_min <= $level) {
			$ext = getExt($file, true);
			if ($include_exts && !in_array($ext, $include_exts)) {
				continue;
			}

			$value = ltrim($relativeFolder.'/'.$file, '/');
			$out[] = $value;
		}
	}
	return $out;
}