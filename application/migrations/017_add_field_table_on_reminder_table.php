<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_field_table_on_reminder_table extends CI_Migration
{

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "reminder";

	public function up()
	{
		$this->dbforge->add_column($this->_table_name, [
			'table' => [
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => true,
			],
			'primary_field' => [
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => true,
			],
		], 'id');
	}

	public function down()
	{
		$this->dbforge->drop_column($this->_table_name, 'table');
		$this->dbforge->drop_column($this->_table_name, 'primary_field');
	}
}
