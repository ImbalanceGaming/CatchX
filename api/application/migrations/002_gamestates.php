<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* This basic migration has been auto-generated by the Gas ORM */

class Migration_gameStates extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'victory' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
			),
			'turn' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'number_of_turns' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'reveal_turns' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
			),
			'doubles' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'hiddens' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'players' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'log' => array(
				'type' => 'TEXT',
				'constraint' => 0,
			),
			'last_known_joker_position' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'turn_side' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
			),
		));

		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('gameStates', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('gameStates');
	}
}