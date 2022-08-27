<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Kp4 Lain Controller
*| --------------------------------------------------------------------------
*| Form Kp4 Lain site
*|
*/
class Form_kp4_lain extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_kp4_lain');
	}

	/**
	* show all Form Kp4 Lains
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_kp4_lain_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_kp4_lains'] = $this->model_form_kp4_lain->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_kp4_lain_counts'] = $this->model_form_kp4_lain->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_kp4_lain/index/',
			'total_rows'   => $this->model_form_kp4_lain->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('KP4 Lain List');
		$this->render('backend/standart/administrator/form_builder/form_kp4_lain/form_kp4_lain_list', $this->data);
	}

	/**
	* Update view Form Kp4 Lains
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_kp4_lain_update');

		$this->data['form_kp4_lain'] = $this->model_form_kp4_lain->find($id);

		$this->template->title('KP4 Lain Update');
		$this->render('backend/standart/administrator/form_builder/form_kp4_lain/form_kp4_lain_update', $this->data);
	}

	/**
	* Update Form Kp4 Lains
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_kp4_lain_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('nama_berkas', 'Nama Berkas', 'trim|required');
		$this->form_validation->set_rules('form_kp4_lain_berkas_kp4_lain_name', 'Berkas KP4 Lain', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_kp4_lain_berkas_kp4_lain_uuid = $this->input->post('form_kp4_lain_berkas_kp4_lain_uuid');
			$form_kp4_lain_berkas_kp4_lain_name = $this->input->post('form_kp4_lain_berkas_kp4_lain_name');
		
			$save_data = [
				'nama_berkas' => $this->input->post('nama_berkas'),
				'deskripsi_arsip' => $this->input->post('deskripsi_arsip'),
			];

			if (!is_dir(FCPATH . '/uploads/form_kp4_lain/')) {
				mkdir(FCPATH . '/uploads/form_kp4_lain/');
			}

			if (!empty($form_kp4_lain_berkas_kp4_lain_uuid)) {
				$form_kp4_lain_berkas_kp4_lain_name_copy = date('YmdHis') . '-' . $form_kp4_lain_berkas_kp4_lain_name;

				rename(FCPATH . 'uploads/tmp/' . $form_kp4_lain_berkas_kp4_lain_uuid . '/' . $form_kp4_lain_berkas_kp4_lain_name, 
						FCPATH . 'uploads/form_kp4_lain/' . $form_kp4_lain_berkas_kp4_lain_name_copy);

				if (!is_file(FCPATH . '/uploads/form_kp4_lain/' . $form_kp4_lain_berkas_kp4_lain_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_kp4_lain'] = $form_kp4_lain_berkas_kp4_lain_name_copy;
			}
		
			
			$save_form_kp4_lain = $this->model_form_kp4_lain->change($id, $save_data);

			if ($save_form_kp4_lain) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_kp4_lain', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_kp4_lain');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_kp4_lain');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Kp4 Lains
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_kp4_lain_delete');

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
            set_message(cclang('has_been_deleted', 'Form Kp4 Lain'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Kp4 Lain'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Kp4 Lains
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_kp4_lain_view');

		$this->data['form_kp4_lain'] = $this->model_form_kp4_lain->find($id);

		$this->template->title('KP4 Lain Detail');
		$this->render('backend/standart/administrator/form_builder/form_kp4_lain/form_kp4_lain_view', $this->data);
	}

	/**
	* delete Form Kp4 Lains
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_kp4_lain = $this->model_form_kp4_lain->find($id);

		if (!empty($form_kp4_lain->berkas_kp4_lain)) {
			$path = FCPATH . '/uploads/form_kp4_lain/' . $form_kp4_lain->berkas_kp4_lain;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_kp4_lain->remove($id);
	}
	
	/**
	* Upload Image Form Kp4 Lain	* 
	* @return JSON
	*/
	public function upload_berkas_kp4_lain_file()
	{
		if (!$this->is_allowed('form_kp4_lain_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_kp4_lain',
		]);
	}

	/**
	* Delete Image Form Kp4 Lain	* 
	* @return JSON
	*/
	public function delete_berkas_kp4_lain_file($uuid)
	{
		if (!$this->is_allowed('form_kp4_lain_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_kp4_lain', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_kp4_lain',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_kp4_lain/'
        ]);
	}

	/**
	* Get Image Form Kp4 Lain	* 
	* @return JSON
	*/
	public function get_berkas_kp4_lain_file($id)
	{
		if (!$this->is_allowed('form_kp4_lain_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_kp4_lain = $this->model_form_kp4_lain->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_kp4_lain', 
            'table_name'        => 'form_kp4_lain',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_kp4_lain/',
            'delete_endpoint'   => 'administrator/form_kp4_lain/delete_berkas_kp4_lain_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_kp4_lain_export');

		$this->model_form_kp4_lain->export('form_kp4_lain', 'form_kp4_lain');
	}
}


/* End of file form_kp4_lain.php */
/* Location: ./application/controllers/administrator/Form Kp4 Lain.php */