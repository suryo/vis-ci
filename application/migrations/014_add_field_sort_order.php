<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_field_sort_order extends CI_Migration
{

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "crud_action";

	public function up()
	{
		$this->dbforge->add_column($this->_table_name, [
			'sort_order' => [
				'type' => 'INT',
			],
		], 'id');
	}

	public function down()
	{
		$this->dbforge->drop_column($this->_table_name, 'sort_order');
	}
}
