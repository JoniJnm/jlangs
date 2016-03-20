<?php

namespace langs\controllers;

use JNMFW\ControllerBase;

class BaseController extends ControllerBase
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
