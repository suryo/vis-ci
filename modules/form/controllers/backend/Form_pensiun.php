<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Pensiun Controller
*| --------------------------------------------------------------------------
*| Form Pensiun site
*|
*/
class Form_pensiun extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_pensiun');
	}

	/**
	* show all Form Pensiuns
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_pensiun_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_pensiuns'] = $this->model_form_pensiun->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_pensiun_counts'] = $this->model_form_pensiun->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_pensiun/index/',
			'total_rows'   => $this->model_form_pensiun->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('SK Pensiun List');
		$this->render('backend/standart/administrator/form_builder/form_pensiun/form_pensiun_list', $this->data);
	}

	/**
	* Update view Form Pensiuns
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_pensiun_update');

		$this->data['form_pensiun'] = $this->model_form_pensiun->find($id);

		$this->template->title('SK Pensiun Update');
		$this->render('backend/standart/administrator/form_builder/form_pensiun/form_pensiun_update', $this->data);
	}

	/**
	* Update Form Pensiuns
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_pensiun_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('tanggal_sk_pensiun', 'Tanggal SK Pensiun', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_pensiun_berkas_sk_pensiun_name', 'Berkas SK Pensiun', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_pensiun_berkas_sk_pensiun_uuid = $this->input->post('form_pensiun_berkas_sk_pensiun_uuid');
			$form_pensiun_berkas_sk_pensiun_name = $this->input->post('form_pensiun_berkas_sk_pensiun_name');
		
			$save_data = [
				'tanggal_sk_pensiun' => $this->input->post('tanggal_sk_pensiun'),
				'tmt' => $this->input->post('tmt'),
			];

			if (!is_dir(FCPATH . '/uploads/form_pensiun/')) {
				mkdir(FCPATH . '/uploads/form_pensiun/');
			}

			if (!empty($form_pensiun_berkas_sk_pensiun_uuid)) {
				$form_pensiun_berkas_sk_pensiun_name_copy = date('YmdHis') . '-' . $form_pensiun_berkas_sk_pensiun_name;

				rename(FCPATH . 'uploads/tmp/' . $form_pensiun_berkas_sk_pensiun_uuid . '/' . $form_pensiun_berkas_sk_pensiun_name, 
						FCPATH . 'uploads/form_pensiun/' . $form_pensiun_berkas_sk_pensiun_name_copy);

				if (!is_file(FCPATH . '/uploads/form_pensiun/' . $form_pensiun_berkas_sk_pensiun_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_pensiun'] = $form_pensiun_berkas_sk_pensiun_name_copy;
			}
		
			
			$save_form_pensiun = $this->model_form_pensiun->change($id, $save_data);

			if ($save_form_pensiun) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_pensiun', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_pensiun');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_pensiun');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Pensiuns
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_pensiun_delete');

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
            set_message(cclang('has_been_deleted', 'Form Pensiun'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Pensiun'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Pensiuns
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_pensiun_view');

		$this->data['form_pensiun'] = $this->model_form_pensiun->find($id);

		$this->template->title('SK Pensiun Detail');
		$this->render('backend/standart/administrator/form_builder/form_pensiun/form_pensiun_view', $this->data);
	}

	/**
	* delete Form Pensiuns
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_pensiun = $this->model_form_pensiun->find($id);

		if (!empty($form_pensiun->berkas_sk_pensiun)) {
			$path = FCPATH . '/uploads/form_pensiun/' . $form_pensiun->berkas_sk_pensiun;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_pensiun->remove($id);
	}
	
	/**
	* Upload Image Form Pensiun	* 
	* @return JSON
	*/
	public function upload_berkas_sk_pensiun_file()
	{
		if (!$this->is_allowed('form_pensiun_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_pensiun',
		]);
	}

	/**
	* Delete Image Form Pensiun	* 
	* @return JSON
	*/
	public function delete_berkas_sk_pensiun_file($uuid)
	{
		if (!$this->is_allowed('form_pensiun_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_pensiun', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_pensiun',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pensiun/'
        ]);
	}

	/**
	* Get Image Form Pensiun	* 
	* @return JSON
	*/
	public function get_berkas_sk_pensiun_file($id)
	{
		if (!$this->is_allowed('form_pensiun_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_pensiun = $this->model_form_pensiun->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_pensiun', 
            'table_name'        => 'form_pensiun',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pensiun/',
            'delete_endpoint'   => 'administrator/form_pensiun/delete_berkas_sk_pensiun_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_pensiun_export');

		$this->model_form_pensiun->export('form_pensiun', 'form_pensiun');
	}
}


/* End of file form_pensiun.php */
/* Location: ./application/controllers/administrator/Form Pensiun.php */