<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_widged_chart_series_condition extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "widged_chart_series_condition";

	public function up()
	{
		$this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'cond_field' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
            ),
            'cond_operator' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
            ),
            'cond_value' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'cond_logic' => array(
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'AND',
            ),
            'widged_series_id' => array(
                'type' => 'INT'
            ),
            'widged_id' => array(
                'type' => 'INT'
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