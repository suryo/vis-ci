<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_crud_function_table extends CI_Migration
{

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "crud_function";
	protected $_table_name2 = "crud_field";
	protected $_table_name3 = "form_field";
	protected $_table_name4 = "crud_action";
	protected $_table_name5 = "crud";

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'slug' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
			),
			'type' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
			),
			'crud_id' => array(
				'type' => 'INT'
			),
			'content' => array(
				'type' => 'TEXT',
				'null' => true,
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($this->_table_name);


		$this->dbforge->add_column($this->_table_name2, [
			'auto_generate_help_block' => [
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => true,
			],
			'placeholder' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'help_block' => [
				'type' => 'TEXT',
				'null' => true,
			]
		], 'input_type');

		$this->dbforge->add_column($this->_table_name3, [
			'show_column' => [
				'type' => 'varchar',
				'constraint' => '20',
				'null' => true,
			],
			'show_add_form' => [
				'type' => 'varchar',
				'constraint' => '20',
				'null' => true,
			],
			'show_update_form' => [
				'type' => 'varchar',
				'constraint' => '20',
				'null' => true,
			],

			'show_detail_page' => [
				'type' => 'varchar',
				'constraint' => '20',
				'null' => true,
			],
		], 'placeholder');


		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => '200',
			),
			'crud_id' => array(
				'type' => 'INT',
			),
			'action' => array(
				'type' => 'VARCHAR',
				'constraint' => '200',
			),
			'meta' => array(
				'type' => 'TEXT',
				'null' => true
			),
			'created_at' => array(
				'type' => 'TIMESTAMP',
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($this->_table_name4);


		$this->dbforge->add_column($this->_table_name5, [
			'sort_field' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => true,
			],
			'sort_by' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => true,
			]
		], 'table_name');
	}

	public function down()
	{
		$this->dbforge->drop_table($this->_table_name, TRUE);

		$this->dbforge->drop_column($this->_table_name2, 'auto_generate_help_block');
		$this->dbforge->drop_column($this->_table_name2, 'placeholder');
		$this->dbforge->drop_column($this->_table_name2, 'help_block');

		$this->dbforge->drop_column($this->_table_name3, 'show_column');
		$this->dbforge->drop_column($this->_table_name3, 'show_add_form');
		$this->dbforge->drop_column($this->_table_name3, 'show_update_form');
		$this->dbforge->drop_column($this->_table_name3, 'show_detail_page');

		$this->dbforge->drop_table($this->_table_name4, TRUE);

		$this->dbforge->drop_column($this->_table_name, 'sort_field');
		$this->dbforge->drop_column($this->_table_name, 'sort_by');
	}
}
