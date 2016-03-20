<?php

namespace langs\controllers;

class BaseController extends \JNMFW\ControllerBase
{
	public function __construct($route)
	{
		parent::__construct($route);
	}

	public function addDefaultRoute()
	{
		$this->route
			->addDefaults()
			->get('/', 'fetch')
			->put('/', 'update')
			->delete('/', 'destroy');
	}
}
