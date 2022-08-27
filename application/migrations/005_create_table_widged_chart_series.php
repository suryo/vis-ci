<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_widged_chart_series extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "widged_chart_series";

	public function up()
	{
		$this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'label' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
            ),
            'value_unit' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
            ),
            'data_table' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'data_field' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'formula' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ),
            'formula_field' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ),
            'x_axis_field' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'x_axis_field_type' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'x_axis_grouping' => array(
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'yes',
            ),
            'color' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ),
            'type' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ),
            'widged_chart_id' => array(
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