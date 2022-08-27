<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Database Controller
*| --------------------------------------------------------------------------
*| Database site
*|
*/
class Database extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_database');
		$this->lang->load('web_lang', $this->current_lang);
		$this->load->dbforge();
	}

	/**
	* show all Databases
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('database_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');
		$st 	= $this->input->get('st');
		$sb 	= $this->input->get('sb');

		$databases = $this->db->list_tables();

		if ($filter) {
			$databases = array_filter($databases, function($item) use($filter){
				return strpos($item, $filter) !== false;
			});
		}

		if ($st) {
			if($st == 'ASC') {
				sort($databases);
			} else {
				rsort($databases);
			} 

		}

		
		$databases = array_diff($databases, get_table_not_allowed_for_builder());

		$this->data['databases'] = $databases;
		$this->data['database_counts'] = count($this->data['databases']);

		$this->template->title('Database List');
		$this->render('backend/standart/administrator/database/database_list', $this->data);
	}
	
	/**
	* Add new databases
	*
	*/
	public function add($table_name = '')
	{
		$this->is_allowed('database_add');

		$this->data['field_type'] = $this->model_database->get_field_type();
		$this->data['table_name'] = $table_name;

		$this->template->title('Database New');
		$this->render('backend/standart/administrator/database/database_add', $this->data);
	}


	/**
	* Add new databases
	*
	*/
	public function change_field($table_name)
	{
		$this->is_allowed('database_add');

		$table_name = ccdecrypt($table_name);

		$this->data['field_type'] = $this->model_database->get_field_type();
		$this->data['fields'] = $this->db->field_data($table_name);
		$this->data['n_fields'] = $this->db->query('SHOW COLUMNS FROM '.$table_name)->result();
		$this->data['table_name'] = $table_name;
		$this->data['field'] = $this->input->get('field');


		$name_fields = [];

		foreach($this->data['n_fields'] as $idx => $val) {
			$name_fields[$val->Field] = $this->data['fields'][$idx];
			$name_fields[$val->Field]->detail = $val;
		}

		$this->data['fields'] = $name_fields;


		$this->template->title('Database New');
		$this->render('backend/standart/administrator/database/database_update', $this->data);
	}

	/**
	* Add New Databases
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('database_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('table_name', 'Table Name', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'table_name' => $this->input->post('table_name'),
			];

			$fields = [];


			$primary_key = '';
			foreach($this->input->post('table') as $field) {
				$auto_increment = isset($field['auto_increment']) ? true : false;
				$null = isset($field['null']) ? true : false;
				$name = $field['name'];
				$constraint = $field['length'];
				$type = $field['type'];

				$default = '';

				if ($auto_increment == true and $primary_key == '') {
					$primary_key = $name;
				}

				if ($field['default'] == 'null') {
					$default = 'null';
				} 
				else if ($field['default'] == 'as_defined')  {
					$default = $field['defined_value'];
				}

				if (strtolower($type) == 'varchar' and $constraint == '' ) {
					$constraint = 255;
				}

				if ($name != '' and $type != '') {

					$fields[$name] = [
							'type' => $type,
							'constraint' => $constraint,
							//'unsigned' => TRUE,
							'auto_increment' => $auto_increment,
							'null' => $null
					];

					if ($default !== '') {
						$fields[$name]['default'] = $default;
					}
					
					if (strtolower($type) == 'enum' ) {
						$fields[$name]['constraint'] = '';
						$fields[$name]['type'] = 'ENUM('.$constraint.')';
					}
				}

			}


			if ($this->input->post('new_field') == 'yes') {

				$position = $this->input->post('position');
				$field = $this->input->post('field');
				$fields = array_map(function($val) use($field, $position){
					return $val + [
						$position => $field
					];

				}, $fields);

				if (count($fields)) {
					app()->dbforge->add_column($this->input->post('table_name'), $fields);
				}


			} else {
				if (count($fields)) {
					app()->dbforge->add_field($fields);
					app()->dbforge->add_key($primary_key, TRUE);
					app()->dbforge->create_table($this->input->post('table_name'));
				}
			}

			
			set_message(
				cclang('success_save_data_redirect', [
				anchor('administrator/database/edit/' , 'Edit Database')
			]), 'success');

			$this->data['success'] = true;
			$this->data['redirect'] = base_url('administrator/database/view/'.ccencrypt($this->input->post('table_name')));

			$this->response($this->data);


		} else {
			$this->data['success'] = false;
			$this->data['message'] = 'Opss validation failed';
			$this->data['errors'] = $this->form_validation->error_array();
		}

		echo json_encode($this->data);
	}

	/**
	* Add New Databases
	*
	* @return JSON
	*/
	public function change_field_save($table_name)
	{
		if (!$this->is_allowed('database_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$table_name = ccdecrypt($table_name);

	
		$save_data = [
			'table_name' => $this->input->post('table_name'),
		];

		$fields = [];


		$primary_key = '';
		foreach($this->input->post('table') as $field) {
			$auto_increment = isset($field['auto_increment']) ? true : false;
			$null = isset($field['null']) ? true : false;
			$name = $field['name'];
			$name_before = $this->input->post('field_before');
			$constraint = $field['length'];
			$type = $field['type'];

			$default = '';

			if ($auto_increment == true and $primary_key == '') {
				$primary_key = $name;
			}

			if ($field['default'] == 'null') {
				$default = 'null';
			} 
			else if ($field['default'] == 'as_defined')  {
				$default = $field['defined_value'];
			}

			if (strtolower($type) == 'varchar' and $constraint == '' ) {
				$constraint = 255;
			}

			if ($name != '' and $type != '') {

				$fields[$name_before] = [
						'name' => $name,
						'type' => $type,
						'constraint' => $constraint,
						//'unsigned' => TRUE,
						'auto_increment' => $auto_increment,
						'null' => $null
				];
				
				if (strtolower($type) == 'enum' ) {
					$fields[$name_before]['constraint'] = '';
					$fields[$name_before]['type'] = 'ENUM('.$constraint.')';
				}

				if ($default !== '') {
					$fields[$name_before]['default'] = $default;
				}
			} else {
				$this->data['success'] = false;
				$this->data['message'] = 'Opss validation failed';

				die(json_encode($this->data));
			}

		}


		if (count($fields)) {
			if ($auto_increment) {
				$this->db->db_debug = false;
				$this->db->query("ALTER TABLE `".$table_name."` ADD PRIMARY KEY(`".$name."`); ");
			}
			app()->dbforge->modify_column($table_name, $fields);
		}

		
		set_message(
			cclang('success_save_data_redirect', [
			anchor('administrator/database/edit/' , 'Edit Database')
		]), 'success');

		$this->data['success'] = true;
		$this->data['redirect'] = base_url('administrator/database/view/'.ccencrypt($table_name));

		echo json_encode($this->data);
	}
	
		/**
	* Update view Databases
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('database_update');


		$this->template->title('Database Update');
		$this->render('backend/standart/administrator/database/database_update', $this->data);
	}

	/**
	* Update Databases
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('database_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('table_name', 'Table Name', 'trim|required');
		$this->form_validation->set_rules('created_at', 'Created At', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'table_name' => $this->input->post('table_name'),
				'created_at' => $this->input->post('created_at'),
			];

			
			$save_database = $this->model_database->change($id, $save_data);

			if ($save_database) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/database', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/database');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/database');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = 'Opss validation failed';
			$this->data['errors'] = $this->form_validation->error_array();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Databases
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('database_delete');

		$this->load->helper('file');

		$arr_id = $this->input->get('id');
		$remove = false;

		if (!empty($id)) {
			$remove = $this->_remove($id);
		} elseif (count($arr_id) >0) {
			foreach ($arr_id as $id) {
				$remove = $this->_remove($id);
			}
		}

		if ($remove) {
            set_message(cclang('has_been_deleted', 'database'), 'success');
        } else {
            set_message(cclang('error_delete', 'database'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Databases
	*
	* @var $id String
	*/
	public function view($table_name)
	{
		$this->is_allowed('database_view');
		$table_name = ccdecrypt($table_name);

		$this->data['field_type'] = $this->model_database->get_field_type();
		$this->data['fields'] = $this->db->field_data($table_name);
		$this->data['n_fields'] = $this->db->query('SHOW COLUMNS FROM '.$table_name)->result();
		$this->data['table_name'] = $table_name;


		foreach($this->data['n_fields'] as $idx => $val) {
			$this->data['fields'][$idx]->detail = $val;
		}
		

		$this->template->title('Database Detail');
		$this->render('backend/standart/administrator/database/database_view', $this->data);
	}
	
	/**
	* delete Databases
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$database = $this->model_database->find($id);

		
		
		return $this->model_database->remove($id);
	}
	
	
	/**
	* delete Databases
	*
	* @var $table_name String
	*/
	public function drop_table($table_name)
	{
		$table_name = ccdecrypt($table_name);

        set_message(cclang('has_been_deleted', $table_name), 'success');

		$this->dbforge->drop_table($table_name);
		redirect_back();
		
	}
	
	
	/**
	* delete Databases
	*
	* @var $id String
	*/
	public function truncate($table_name)
	{
		$table_name = ccdecrypt($table_name);

        set_message(cclang('has_been_deleted', $table_name), 'success');

		$this->db->truncate($table_name);
		redirect_back();
		
	}

	
	/**
	* delete Databases
	*
	* @var $id String
	*/
	public function backup()
	{
		$this->load->dbutil();

		$backup = $this->dbutil->backup();

		$this->load->helper('download');
		force_download('mybackup.gz', $backup);
		
	}



	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('database_export');

		$this->model_database->export(
			'database', 
			'database',
			$this->model_database->field_search
		);
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('database_export');

		$this->model_database->pdf('database', 'database');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('database_export');

		$table = $title = 'database';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_database->find($id);
        $fields = $result->list_fields();

        $content = $this->pdf->loadHtmlPdf('core_template/pdf/pdf_single', [
            'data' => $data,
            'fields' => $fields,
            'title' => $title
        ], TRUE);

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table.'.pdf', 'H');
	}


	public function get_field()
	{
		$this->is_allowed('database_update');
		$table_name = $this->input->get('table_name');

		$this->data['field_type'] = $this->model_database->get_field_type();
		$this->data['fields'] = $this->db->field_data($table_name);
		$this->data['table_name'] = $table_name;


		$this->response(
			[
				'success' => true,
				'data' => $this->data['fields'],
			]
		);

	}

	public function update_table_name($table_name)
	{
		$this->is_allowed('database_update');
		$table_name = ccdecrypt($table_name);
		$table_name_change = $this->input->get('table_name_change');

		$this->dbforge->rename_table($table_name, $table_name_change);
	
		set_message('Table modified', 'success');

		redirect('administrator/database/view/'.ccencrypt($table_name_change));

	}
	
	/**
	* delete Databases
	*
	* @var $id String
	*/
	public function remove_field($table_name)
	{
		$this->is_allowed('database_update');
		$table_name = ccdecrypt($table_name);
		$field = $this->input->get('field');
        set_message((cclang('has_been_deleted', $field)), 'success');

		$this->dbforge->drop_column($table_name, $field);
		redirect_back();
		
	}


	public function add_key($table_name)
	{
		$this->is_allowed('database_update');
		$table_name = ccdecrypt($table_name);
		$field = $this->input->get('field');
		set_message(cclang('success_update_data_redirect', [
			]), 'success');

		$this->db->query("ALTER TABLE `".$table_name."` ADD PRIMARY KEY(`".$field."`); ")->result();
		redirect_back();
		
	}

	public function remove_key($table_name)
	{
		$this->is_allowed('database_update');
		$table_name = ccdecrypt($table_name);
		$field = $this->input->get('field');
		set_message(cclang('success_update_data_redirect', [
			]), 'success');

			$this->db->query("
			ALTER TABLE `".$table_name."`  MODIFY `".$field."` INT NOT NULL;");
			$this->db->query("
			ALTER TABLE  `".$table_name."` DROP PRIMARY KEY; ");
		redirect_back();
		
	}
	
	public function move_column($table_name)
	{
		$this->is_allowed('database_update');
		$table_name = ccdecrypt($table_name);

		$position = $this->input->get('position');
		$target = $this->input->get('target');
		$field = $this->input->get('field');

		$field_type = $this->model_database->get_field_type();
		$fields = $this->db->field_data($table_name);
		$n_fields = $this->db->query('SHOW COLUMNS FROM '.$table_name)->result();
		$table_name = $table_name;


		$name_fields = [];
		foreach($n_fields as $idx => $val) {
			$name_fields[$val->Field] = $fields[$idx];
			$name_fields[$val->Field]->detail = $val;
		}

		$selected = $name_fields[$field];

		$null = $selected->detail->Null == 'NO' ? 'NOT NULL' : 'NULL';

		$position = ($position == 'after') ? $position." `".$target."`" : 'FIRST';

		$this->db->debug = false;

		$default = '';

		if ($selected->detail->Default) {
			$default = 'DEFAULT "'.$selected->detail->Default.'"';
		}


		$query = "ALTER TABLE `".$table_name."`  CHANGE COLUMN `".$field."` `".$field."` ".$selected->detail->Type."  " .$null." ".$default." ".$selected->detail->Extra." ".$position;
		$this->db->query($query );

		$this->response([
			'success' => true,
			'message' => $this->db->error(),
		]);

	}

	
}


/* End of file database.php */
/* Location: ./application/controllers/administrator/Database.php */