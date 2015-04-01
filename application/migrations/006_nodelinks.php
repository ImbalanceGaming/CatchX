<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* This basic migration has been auto-generated by the Gas ORM */

class Migration_nodeLinks extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'node_id' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'linked_node_id' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'color_id' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
		));

		$this->dbforge->add_key('node_id', TRUE);

		$this->dbforge->create_table('nodeLinks', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('nodeLinks');
	}
}