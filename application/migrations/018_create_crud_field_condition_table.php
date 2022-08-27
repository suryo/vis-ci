<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_crud_field_condition_table extends CI_Migration
{

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "crud_field_condition";

	public function up()
	{

		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'crud_field_id' => array(
				'type' => 'INT',
			),
			'reff' => array(
				'type' => 'TEXT',
				'null' => true
			),
			'crud_id' => array(
				'type' => 'INT',
			),
			'cond_field' => array(
				'type' => 'TEXT',
				'null' => true
			),
			'cond_operator' => array(
				'type' => 'TEXT',
				'null' => true
			),
			'cond_value' => array(
				'type' => 'TEXT',
				'null' => true
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
