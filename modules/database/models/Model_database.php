<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_database extends MY_Model {

    private $primary_key    = 'id';
    private $table_name     = 'database';
    public $field_search   = ['table_name', 'created_at'];

    public function __construct()
    {
        $config = array(
            'primary_key'   => $this->primary_key,
            'table_name'    => $this->table_name,
            'field_search'  => $this->field_search,
         );

        parent::__construct($config);
    }

    public function get_field_type()
    {
        return  [
			'most' => [
				'INT',
				'VARCHAR',
				'TEXT',
				'DATE',
			],
			'numeric' => [
				'DECIMAL',
				'FLOAT',
				'DOUBLE',
				'BIGINT',
				'SMALLINT',
				'MEDIUMINT',
				'TINYINT',
				'BIT',
				'BOOLEAN',
				'SERIAL',
				
			],
			'string' => [
				'TEXT',
				'VARCHAR',
				'CHAR',
				'LONGTEXT',
				'MEDIUMTEXT',
				'TINYTEXT',
			],
			'date & time' => [
				'DATE',
				'DATETIME',
				'TIMESTAMP',
				'TIME',
				'YEAR',
			],
			
			'spatial' => [
				'GEOMETRY',
				'LINESTRING',
				'POLYGON',
				'MULTIPOINT',
			],
			
			'other' => [
				'ENUM',
				'JSON',
			],
			
		];
    }
}

/* End of file Model_database.php */
/* Location: ./application/models/Model_database.php */