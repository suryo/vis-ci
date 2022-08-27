<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Sk Pemberhentian Controller
*| --------------------------------------------------------------------------
*| Form Sk Pemberhentian site
*|
*/
class Form_sk_pemberhentian extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_sk_pemberhentian');
	}

	/**
	* show all Form Sk Pemberhentians
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_sk_pemberhentian_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_sk_pemberhentians'] = $this->model_form_sk_pemberhentian->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_sk_pemberhentian_counts'] = $this->model_form_sk_pemberhentian->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_sk_pemberhentian/index/',
			'total_rows'   => $this->model_form_sk_pemberhentian->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('SK Pemberhentian List');
		$this->render('backend/standart/administrator/form_builder/form_sk_pemberhentian/form_sk_pemberhentian_list', $this->data);
	}

	/**
	* Update view Form Sk Pemberhentians
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_sk_pemberhentian_update');

		$this->data['form_sk_pemberhentian'] = $this->model_form_sk_pemberhentian->find($id);

		$this->template->title('SK Pemberhentian Update');
		$this->render('backend/standart/administrator/form_builder/form_sk_pemberhentian/form_sk_pemberhentian_update', $this->data);
	}

	/**
	* Update Form Sk Pemberhentians
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_sk_pemberhentian_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('no_sk_pemberhentian', 'No. Sk Pemberhentian', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_pemberhentian', 'Tanggal SK Pemberhentian', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_sk_pemberhentian_berkas_sk_pemberhentian_name', 'Berkas SK Pemberhentian', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_sk_pemberhentian_berkas_sk_pemberhentian_uuid = $this->input->post('form_sk_pemberhentian_berkas_sk_pemberhentian_uuid');
			$form_sk_pemberhentian_berkas_sk_pemberhentian_name = $this->input->post('form_sk_pemberhentian_berkas_sk_pemberhentian_name');
		
			$save_data = [
				'no_sk_pemberhentian' => $this->input->post('no_sk_pemberhentian'),
				'tanggal_sk_pemberhentian' => $this->input->post('tanggal_sk_pemberhentian'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_sk_pemberhentian' => $this->input->post('deskripsi_sk_pemberhentian'),
			];

			if (!is_dir(FCPATH . '/uploads/form_sk_pemberhentian/')) {
				mkdir(FCPATH . '/uploads/form_sk_pemberhentian/');
			}

			if (!empty($form_sk_pemberhentian_berkas_sk_pemberhentian_uuid)) {
				$form_sk_pemberhentian_berkas_sk_pemberhentian_name_copy = date('YmdHis') . '-' . $form_sk_pemberhentian_berkas_sk_pemberhentian_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_pemberhentian_berkas_sk_pemberhentian_uuid . '/' . $form_sk_pemberhentian_berkas_sk_pemberhentian_name, 
						FCPATH . 'uploads/form_sk_pemberhentian/' . $form_sk_pemberhentian_berkas_sk_pemberhentian_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_pemberhentian/' . $form_sk_pemberhentian_berkas_sk_pemberhentian_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_pemberhentian'] = $form_sk_pemberhentian_berkas_sk_pemberhentian_name_copy;
			}
		
			
			$save_form_sk_pemberhentian = $this->model_form_sk_pemberhentian->change($id, $save_data);

			if ($save_form_sk_pemberhentian) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_sk_pemberhentian', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_sk_pemberhentian');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_sk_pemberhentian');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Sk Pemberhentians
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_sk_pemberhentian_delete');

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
            set_message(cclang('has_been_deleted', 'Form Sk Pemberhentian'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Sk Pemberhentian'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Sk Pemberhentians
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_sk_pemberhentian_view');

		$this->data['form_sk_pemberhentian'] = $this->model_form_sk_pemberhentian->find($id);

		$this->template->title('SK Pemberhentian Detail');
		$this->render('backend/standart/administrator/form_builder/form_sk_pemberhentian/form_sk_pemberhentian_view', $this->data);
	}

	/**
	* delete Form Sk Pemberhentians
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_sk_pemberhentian = $this->model_form_sk_pemberhentian->find($id);

		if (!empty($form_sk_pemberhentian->berkas_sk_pemberhentian)) {
			$path = FCPATH . '/uploads/form_sk_pemberhentian/' . $form_sk_pemberhentian->berkas_sk_pemberhentian;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_sk_pemberhentian->remove($id);
	}
	
	/**
	* Upload Image Form Sk Pemberhentian	* 
	* @return JSON
	*/
	public function upload_berkas_sk_pemberhentian_file()
	{
		if (!$this->is_allowed('form_sk_pemberhentian_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_pemberhentian',
		]);
	}

	/**
	* Delete Image Form Sk Pemberhentian	* 
	* @return JSON
	*/
	public function delete_berkas_sk_pemberhentian_file($uuid)
	{
		if (!$this->is_allowed('form_sk_pemberhentian_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_pemberhentian', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_pemberhentian',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_pemberhentian/'
        ]);
	}

	/**
	* Get Image Form Sk Pemberhentian	* 
	* @return JSON
	*/
	public function get_berkas_sk_pemberhentian_file($id)
	{
		if (!$this->is_allowed('form_sk_pemberhentian_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_sk_pemberhentian = $this->model_form_sk_pemberhentian->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_pemberhentian', 
            'table_name'        => 'form_sk_pemberhentian',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_pemberhentian/',
            'delete_endpoint'   => 'administrator/form_sk_pemberhentian/delete_berkas_sk_pemberhentian_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_sk_pemberhentian_export');

		$this->model_form_sk_pemberhentian->export('form_sk_pemberhentian', 'form_sk_pemberhentian');
	}
}


/* End of file form_sk_pemberhentian.php */
/* Location: ./application/controllers/administrator/Form Sk Pemberhentian.php */