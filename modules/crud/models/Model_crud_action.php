<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_crud_action extends MY_Model
{

    private $primary_key     = 'id';
    private $table_name     = 'crud_action';
    private $field_search     = ['action', 'meta'];

    public function __construct()
    {
        $config = array(
            'primary_key'     => $this->primary_key,
            'table_name'     => $this->table_name,
            'field_search'     => $this->field_search,
        );

        parent::__construct($config);
    }
}

/* End of file Model_crud_action.php */
/* Location: ./application/models/Model_crud_action.php */