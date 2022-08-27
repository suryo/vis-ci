<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_notification_table extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "notification";

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'null' => true,
				'constraint' => 200,
			),
			'content' => array(
				'type' => 'TEXT',
				'null' => true,
			),
			'url' => array(
				'type' => 'TEXT',
				'null' => true,
			),
			'read' => array(
				'type' => 'INT',
			),
			'group_id' => array(
				'type' => 'INT',
			),
			'created_at' => array(
				'type' => 'TIMESTAMP',
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($this->_table_name);
	}

	public function down()
	{
		$this->dbforge->drop_table($this->_table_name, TRUE);
	}

}
