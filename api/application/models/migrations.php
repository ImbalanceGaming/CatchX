<?php namespace Model;

/* This basic model has been auto-generated by the Gas ORM */

use \Gas\Core;
use \Gas\ORM;

class Migrations extends ORM {
	
	function _init()
	{
		self::$fields = array(
			'version' => ORM::field('int[3]'),
		);

	}
}