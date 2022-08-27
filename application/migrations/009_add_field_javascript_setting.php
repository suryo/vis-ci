<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_field_javascript_setting extends CI_Migration
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
			'javascript_setting_list' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'javascript_setting_create' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'javascript_setting_update' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'javascript_setting_detail' => [
				'type' => 'TEXT',
				'null' => true,
			],
		], 'style');
	}

	public function down()
	{
		$this->dbforge->drop_column($this->_table_name, 'javascript_setting_list');
		$this->dbforge->drop_column($this->_table_name, 'javascript_setting_create');
		$this->dbforge->drop_column($this->_table_name, 'javascript_setting_update');
		$this->dbforge->drop_column($this->_table_name, 'javascript_setting_detail');
	}
}
