<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_reminder_cron_table extends CI_Migration
{

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "reminder_cron";

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'reminder_id' => array(
				'type' => 'INT',
			),
			'reff_id' => array(
				'type' => 'INT',
			),
			'reff_table' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
			),
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => true,
			),
			'sent_at' => array(
				'type' => 'DATETIME',
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
