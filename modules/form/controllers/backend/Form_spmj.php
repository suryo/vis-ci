<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Spmj Controller
*| --------------------------------------------------------------------------
*| Form Spmj site
*|
*/
class Form_spmj extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_spmj');
	}

	/**
	* show all Form Spmjs
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_spmj_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_spmjs'] = $this->model_form_spmj->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_spmj_counts'] = $this->model_form_spmj->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_spmj/index/',
			'total_rows'   => $this->model_form_spmj->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Surat Pernyataan Masih Menduduki Jabatan List');
		$this->render('backend/standart/administrator/form_builder/form_spmj/form_spmj_list', $this->data);
	}

	/**
	* Update view Form Spmjs
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_spmj_update');

		$this->data['form_spmj'] = $this->model_form_spmj->find($id);

		$this->template->title('Surat Pernyataan Masih Menduduki Jabatan Update');
		$this->render('backend/standart/administrator/form_builder/form_spmj/form_spmj_update', $this->data);
	}

	/**
	* Update Form Spmjs
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_spmj_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('no_spmj', 'No. SPMJ', 'trim|required');
		$this->form_validation->set_rules('tanggal_spmj', 'Tanggal SPMJ', 'trim|required');
		$this->form_validation->set_rules('form_spmj_berkas_spmj_name', 'Berkas SPMJ', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_spmj_berkas_spmj_uuid = $this->input->post('form_spmj_berkas_spmj_uuid');
			$form_spmj_berkas_spmj_name = $this->input->post('form_spmj_berkas_spmj_name');
		
			$save_data = [
				'no_spmj' => $this->input->post('no_spmj'),
				'tanggal_spmj' => $this->input->post('tanggal_spmj'),
			];

			if (!is_dir(FCPATH . '/uploads/form_spmj/')) {
				mkdir(FCPATH . '/uploads/form_spmj/');
			}

			if (!empty($form_spmj_berkas_spmj_uuid)) {
				$form_spmj_berkas_spmj_name_copy = date('YmdHis') . '-' . $form_spmj_berkas_spmj_name;

				rename(FCPATH . 'uploads/tmp/' . $form_spmj_berkas_spmj_uuid . '/' . $form_spmj_berkas_spmj_name, 
						FCPATH . 'uploads/form_spmj/' . $form_spmj_berkas_spmj_name_copy);

				if (!is_file(FCPATH . '/uploads/form_spmj/' . $form_spmj_berkas_spmj_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_spmj'] = $form_spmj_berkas_spmj_name_copy;
			}
		
			
			$save_form_spmj = $this->model_form_spmj->change($id, $save_data);

			if ($save_form_spmj) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_spmj', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_spmj');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_spmj');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Spmjs
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_spmj_delete');

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
            set_message(cclang('has_been_deleted', 'Form Spmj'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Spmj'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Spmjs
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_spmj_view');

		$this->data['form_spmj'] = $this->model_form_spmj->find($id);

		$this->template->title('Surat Pernyataan Masih Menduduki Jabatan Detail');
		$this->render('backend/standart/administrator/form_builder/form_spmj/form_spmj_view', $this->data);
	}

	/**
	* delete Form Spmjs
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_spmj = $this->model_form_spmj->find($id);

		if (!empty($form_spmj->berkas_spmj)) {
			$path = FCPATH . '/uploads/form_spmj/' . $form_spmj->berkas_spmj;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_spmj->remove($id);
	}
	
	/**
	* Upload Image Form Spmj	* 
	* @return JSON
	*/
	public function upload_berkas_spmj_file()
	{
		if (!$this->is_allowed('form_spmj_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_spmj',
		]);
	}

	/**
	* Delete Image Form Spmj	* 
	* @return JSON
	*/
	public function delete_berkas_spmj_file($uuid)
	{
		if (!$this->is_allowed('form_spmj_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_spmj', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_spmj',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_spmj/'
        ]);
	}

	/**
	* Get Image Form Spmj	* 
	* @return JSON
	*/
	public function get_berkas_spmj_file($id)
	{
		if (!$this->is_allowed('form_spmj_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_spmj = $this->model_form_spmj->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_spmj', 
            'table_name'        => 'form_spmj',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_spmj/',
            'delete_endpoint'   => 'administrator/form_spmj/delete_berkas_spmj_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_spmj_export');

		$this->model_form_spmj->export('form_spmj', 'form_spmj');
	}
}


/* End of file form_spmj.php */
/* Location: ./application/controllers/administrator/Form Spmj.php */