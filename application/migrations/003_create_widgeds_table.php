<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_widgeds_table extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "widgeds";

	public function up()
	{
		$this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
            ),
            'dashboard_id' => array(
                'type' => 'INT'
            ),
            'widged_uuid' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'widged_type' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'sort_number' => array(
                'type' => 'INTEGER',
                'constraint' => 11,
            ),
            'width' => array(
                'type' => 'INTEGER',
                'constraint' => 11,
            ),
            'height' => array(
                'type' => 'INTEGER',
                'constraint' => 11,
            ),
            'y' => array(
                'type' => 'INTEGER',
                'constraint' => 11,
            ),
            'x' => array(
                'type' => 'INTEGER',
                'constraint' => 11,
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
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

?>