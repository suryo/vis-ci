<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Sk Cpns Controller
*| --------------------------------------------------------------------------
*| Form Sk Cpns site
*|
*/
class Form_sk_cpns extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_sk_cpns');
	}

	/**
	* show all Form Sk Cpnss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_sk_cpns_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_sk_cpnss'] = $this->model_form_sk_cpns->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_sk_cpns_counts'] = $this->model_form_sk_cpns->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_sk_cpns/index/',
			'total_rows'   => $this->model_form_sk_cpns->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('SK CPNS List');
		$this->render('backend/standart/administrator/form_builder/form_sk_cpns/form_sk_cpns_list', $this->data);
	}

	/**
	* Update view Form Sk Cpnss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_sk_cpns_update');

		$this->data['form_sk_cpns'] = $this->model_form_sk_cpns->find($id);

		$this->template->title('SK CPNS Update');
		$this->render('backend/standart/administrator/form_builder/form_sk_cpns/form_sk_cpns_update', $this->data);
	}

	/**
	* Update Form Sk Cpnss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_sk_cpns_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('no_sk_cpns', 'No. SK CPNS', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_cpns', 'Tanggal SK CPNS', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_sk_cpns_berkas_sk_cpns_name', 'Berkas SK CPNS', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_sk_cpns_berkas_sk_cpns_uuid = $this->input->post('form_sk_cpns_berkas_sk_cpns_uuid');
			$form_sk_cpns_berkas_sk_cpns_name = $this->input->post('form_sk_cpns_berkas_sk_cpns_name');
		
			$save_data = [
				'no_sk_cpns' => $this->input->post('no_sk_cpns'),
				'tanggal_sk_cpns' => $this->input->post('tanggal_sk_cpns'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_sk_cpns' => $this->input->post('deskripsi_sk_cpns'),
			];

			if (!is_dir(FCPATH . '/uploads/form_sk_cpns/')) {
				mkdir(FCPATH . '/uploads/form_sk_cpns/');
			}

			if (!empty($form_sk_cpns_berkas_sk_cpns_uuid)) {
				$form_sk_cpns_berkas_sk_cpns_name_copy = date('YmdHis') . '-' . $form_sk_cpns_berkas_sk_cpns_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_cpns_berkas_sk_cpns_uuid . '/' . $form_sk_cpns_berkas_sk_cpns_name, 
						FCPATH . 'uploads/form_sk_cpns/' . $form_sk_cpns_berkas_sk_cpns_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_cpns/' . $form_sk_cpns_berkas_sk_cpns_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_cpns'] = $form_sk_cpns_berkas_sk_cpns_name_copy;
			}
		
			
			$save_form_sk_cpns = $this->model_form_sk_cpns->change($id, $save_data);

			if ($save_form_sk_cpns) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_sk_cpns', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_sk_cpns');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_sk_cpns');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Sk Cpnss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_sk_cpns_delete');

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
            set_message(cclang('has_been_deleted', 'Form Sk Cpns'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Sk Cpns'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Sk Cpnss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_sk_cpns_view');

		$this->data['form_sk_cpns'] = $this->model_form_sk_cpns->find($id);

		$this->template->title('SK CPNS Detail');
		$this->render('backend/standart/administrator/form_builder/form_sk_cpns/form_sk_cpns_view', $this->data);
	}

	/**
	* delete Form Sk Cpnss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_sk_cpns = $this->model_form_sk_cpns->find($id);

		if (!empty($form_sk_cpns->berkas_sk_cpns)) {
			$path = FCPATH . '/uploads/form_sk_cpns/' . $form_sk_cpns->berkas_sk_cpns;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_sk_cpns->remove($id);
	}
	
	/**
	* Upload Image Form Sk Cpns	* 
	* @return JSON
	*/
	public function upload_berkas_sk_cpns_file()
	{
		if (!$this->is_allowed('form_sk_cpns_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_cpns',
		]);
	}

	/**
	* Delete Image Form Sk Cpns	* 
	* @return JSON
	*/
	public function delete_berkas_sk_cpns_file($uuid)
	{
		if (!$this->is_allowed('form_sk_cpns_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_cpns', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_cpns',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_cpns/'
        ]);
	}

	/**
	* Get Image Form Sk Cpns	* 
	* @return JSON
	*/
	public function get_berkas_sk_cpns_file($id)
	{
		if (!$this->is_allowed('form_sk_cpns_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_sk_cpns = $this->model_form_sk_cpns->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_cpns', 
            'table_name'        => 'form_sk_cpns',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_cpns/',
            'delete_endpoint'   => 'administrator/form_sk_cpns/delete_berkas_sk_cpns_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_sk_cpns_export');

		$this->model_form_sk_cpns->export('form_sk_cpns', 'form_sk_cpns');
	}
}


/* End of file form_sk_cpns.php */
/* Location: ./application/controllers/administrator/Form Sk Cpns.php */