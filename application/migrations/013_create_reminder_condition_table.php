<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_reminder_condition_table extends CI_Migration
{

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "reminder_condition";

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'cond_field' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
			),
			'cond_operator' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
			),
			'cond_value' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => true
			),
			'cond_logic' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'default' => 'AND',
			),
			'reminder_id' => array(
				'type' => 'INT'
			),
			'group_id' => array(
				'type' => 'INT',
				'null' => true
			),
			'sort_order' => array(
				'type' => 'INT'
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($this->_table_name);
	}

	public function down()
	{
		$this->dbforge->drop_table($this->_table_name, TRUE);
	}
}
