<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_change_field_group_id_to_user_id extends CI_Migration
{

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "notification";

	public function up()
	{
		$fields = array(
			'group_id' => [
				'type' => 'int',
				'name' => 'user_id'
			],
		);
		$this->dbforge->modify_column($this->_table_name, $fields);
	}

	public function down()
	{
		$fields = array(
			'user_id' => [
				'type' => 'int',
				'name' => 'group_id'
			],
		);
		$this->dbforge->modify_column($this->_table_name, $fields);
	}
}
