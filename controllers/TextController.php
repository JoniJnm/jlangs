<?php

namespace langs\controllers;

use langs\models\TextModel;

class TextController extends BaseController
{
	/**
	 * @var TextModel
	 */
	private $textModel;

	public function __construct($route)
	{
		parent::__construct($route);
		$this->textModel = TextModel::getInstance();
		$this->route
			->post('/clear', 'destroy');
		$this->addDefaultRoute();
	}

	public function fetch()
	{
		$id_key = $this->request->getUInt('id_key');
		$data = $this->textModel->getByIdKey($id_key);
		$this->server->sendData($data);
	}

	public function create()
	{
		$id_lang = $this->request->getUInt('id_lang');
		$id_key = $this->request->getUInt('id_key');
		$text = $this->request->getString('text');

		$this->textModel->save($id_lang, $id_key, $text);

		$this->server->sendOK();
	}

	public function destroy()
	{
		$id_lang = $this->request->getUInt('id_lang');
		$id_key = $this->request->getUInt('id_key');

		$this->textModel->delete($id_lang, $id_key);

		$this->server->sendOK();
	}
}
