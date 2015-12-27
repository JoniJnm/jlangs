<?php

namespace langs\controllers;

use langs\models\TextModel;

class TextController extends \JNMFW\ControllerBase {
	/**
	 * @var TextModel
	 */
	private $textModel;
	
	public function __construct() {
		parent::__construct();
		$this->textModel = TextModel::getInstance();
	}
	
	public function get() {
		$id_key = $this->request->getUInt('id_key');
		$data = $this->textModel->getByIdKey($id_key);
		$this->server->sendData($data);
	}
	
	public function save() {
		$id_lang = $this->request->getUInt('id_lang');
		$id_key = $this->request->getUInt('id_key');
		$text = $this->request->getString('text');
		
		$this->textModel->save($id_lang, $id_key, $text);
		
		$this->server->sendOK();
	}
	
	public function delete() {
		$id_lang = $this->request->getUInt('id_lang');
		$id_key = $this->request->getUInt('id_key');
		
		$this->textModel->delete($id_lang, $id_key);
		
		$this->server->sendOK();
	}
}
