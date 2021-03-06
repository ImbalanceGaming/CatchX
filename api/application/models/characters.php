<?php namespace Model;

/* This basic model has been auto-generated by the Gas ORM */

use \Gas\Core;
use \Gas\ORM;
use \Gas\ExtendedGasORM;

class Characters extends ORM {
	
	public $primary_key = 'id';

	function _init()
	{

        self::$relationships = array(
            'players' => ORM::has_many('\\Model\\Players')
        );

		self::$fields = array(
			'id' => ORM::field('auto[11]'),
			'name' => ORM::field('char[100]'),
			'pawnImage' => ORM::field('char[100]'),
            'evil' => ORM::field('numeric[1]'),
		);

	}
}