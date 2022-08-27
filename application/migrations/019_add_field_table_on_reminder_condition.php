<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_field_table_on_reminder_condition extends CI_Migration
{

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "reminder_condition";
	protected $_table_name2 = "reminder";

	public function up()
	{
		$this->dbforge->add_column($this->_table_name, [
			'cond_table' => [
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => true,
			],
			'cond_type' => [
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => true,
			],
		], 'id');

		$this->dbforge->add_column($this->_table_name2, [

			'receipent_department' => [
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => true,
			],

			'receipent_custom_query' => [
				'type' => 'TEXT',
				'null' => true,
			]
		], 'id');
	}

	public function down()
	{
		$this->dbforge->drop_column($this->_table_name, 'cond_table');
		$this->dbforge->drop_column($this->_table_name, 'cond_type');
		$this->dbforge->drop_column($this->_table_name2, 'receipent_department');
		$this->dbforge->drop_column($this->_table_name2, 'receipent_custom_query');
	}
}
