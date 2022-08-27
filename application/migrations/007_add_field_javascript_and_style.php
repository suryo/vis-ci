<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_field_javascript_and_style extends CI_Migration
{

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "crud";


	public function up()
	{
		$this->dbforge->add_column($this->_table_name, [
			'style' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'javascript' => [
				'type' => 'TEXT',
				'null' => true,
			]
		], 'table_name');
	}

	public function down()
	{
		$this->dbforge->drop_column($this->_table_name, 'style');
		$this->dbforge->drop_column($this->_table_name, 'javascript');
	}
}
