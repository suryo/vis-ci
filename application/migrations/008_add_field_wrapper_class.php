<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_field_wrapper_class extends CI_Migration
{

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "crud_field";

	public function up()
	{
		$this->dbforge->add_column($this->_table_name, [
			'wrapper_class' => [
				'type' => 'TEXT',
				'null' => true,
			],
		], 'input_type');
	}

	public function down()
	{
		$this->dbforge->drop_column($this->_table_name, 'wrapper_class');
	}
}
