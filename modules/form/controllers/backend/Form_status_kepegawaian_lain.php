<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Status Kepegawaian Lain Controller
*| --------------------------------------------------------------------------
*| Form Status Kepegawaian Lain site
*|
*/
class Form_status_kepegawaian_lain extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_status_kepegawaian_lain');
	}

	/**
	* show all Form Status Kepegawaian Lains
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_status_kepegawaian_lain_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_status_kepegawaian_lains'] = $this->model_form_status_kepegawaian_lain->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_status_kepegawaian_lain_counts'] = $this->model_form_status_kepegawaian_lain->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_status_kepegawaian_lain/index/',
			'total_rows'   => $this->model_form_status_kepegawaian_lain->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Status Kepegawaian Lain List');
		$this->render('backend/standart/administrator/form_builder/form_status_kepegawaian_lain/form_status_kepegawaian_lain_list', $this->data);
	}

	/**
	* Update view Form Status Kepegawaian Lains
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_status_kepegawaian_lain_update');

		$this->data['form_status_kepegawaian_lain'] = $this->model_form_status_kepegawaian_lain->find($id);

		$this->template->title('Status Kepegawaian Lain Update');
		$this->render('backend/standart/administrator/form_builder/form_status_kepegawaian_lain/form_status_kepegawaian_lain_update', $this->data);
	}

	/**
	* Update Form Status Kepegawaian Lains
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_status_kepegawaian_lain_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('nama_berkas', 'Nama Berkas', 'trim|required');
		$this->form_validation->set_rules('form_status_kepegawaian_lain_berkas_status_kepegawaian_lain_name', 'Berkas Status Kepegawaian Lain', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_status_kepegawaian_lain_berkas_status_kepegawaian_lain_uuid = $this->input->post('form_status_kepegawaian_lain_berkas_status_kepegawaian_lain_uuid');
			$form_status_kepegawaian_lain_berkas_status_kepegawaian_lain_name = $this->input->post('form_status_kepegawaian_lain_berkas_status_kepegawaian_lain_name');
		
			$save_data = [
				'nama_berkas' => $this->input->post('nama_berkas'),
				'deskripsi_arsip' => $this->input->post('deskripsi_arsip'),
			];

			if (!is_dir(FCPATH . '/uploads/form_status_kepegawaian_lain/')) {
				mkdir(FCPATH . '/uploads/form_status_kepegawaian_lain/');
			}

			if (!empty($form_status_kepegawaian_lain_berkas_status_kepegawaian_lain_uuid)) {
				$form_status_kepegawaian_lain_berkas_status_kepegawaian_lain_name_copy = date('YmdHis') . '-' . $form_status_kepegawaian_lain_berkas_status_kepegawaian_lain_name;

				rename(FCPATH . 'uploads/tmp/' . $form_status_kepegawaian_lain_berkas_status_kepegawaian_lain_uuid . '/' . $form_status_kepegawaian_lain_berkas_status_kepegawaian_lain_name, 
						FCPATH . 'uploads/form_status_kepegawaian_lain/' . $form_status_kepegawaian_lain_berkas_status_kepegawaian_lain_name_copy);

				if (!is_file(FCPATH . '/uploads/form_status_kepegawaian_lain/' . $form_status_kepegawaian_lain_berkas_status_kepegawaian_lain_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_status_kepegawaian_lain'] = $form_status_kepegawaian_lain_berkas_status_kepegawaian_lain_name_copy;
			}
		
			
			$save_form_status_kepegawaian_lain = $this->model_form_status_kepegawaian_lain->change($id, $save_data);

			if ($save_form_status_kepegawaian_lain) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_status_kepegawaian_lain', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_status_kepegawaian_lain');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_status_kepegawaian_lain');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Status Kepegawaian Lains
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_status_kepegawaian_lain_delete');

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
            set_message(cclang('has_been_deleted', 'Form Status Kepegawaian Lain'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Status Kepegawaian Lain'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Status Kepegawaian Lains
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_status_kepegawaian_lain_view');

		$this->data['form_status_kepegawaian_lain'] = $this->model_form_status_kepegawaian_lain->find($id);

		$this->template->title('Status Kepegawaian Lain Detail');
		$this->render('backend/standart/administrator/form_builder/form_status_kepegawaian_lain/form_status_kepegawaian_lain_view', $this->data);
	}

	/**
	* delete Form Status Kepegawaian Lains
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_status_kepegawaian_lain = $this->model_form_status_kepegawaian_lain->find($id);

		if (!empty($form_status_kepegawaian_lain->berkas_status_kepegawaian_lain)) {
			$path = FCPATH . '/uploads/form_status_kepegawaian_lain/' . $form_status_kepegawaian_lain->berkas_status_kepegawaian_lain;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_status_kepegawaian_lain->remove($id);
	}
	
	/**
	* Upload Image Form Status Kepegawaian Lain	* 
	* @return JSON
	*/
	public function upload_berkas_status_kepegawaian_lain_file()
	{
		if (!$this->is_allowed('form_status_kepegawaian_lain_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_status_kepegawaian_lain',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Status Kepegawaian Lain	* 
	* @return JSON
	*/
	public function delete_berkas_status_kepegawaian_lain_file($uuid)
	{
		if (!$this->is_allowed('form_status_kepegawaian_lain_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_status_kepegawaian_lain', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_status_kepegawaian_lain',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_status_kepegawaian_lain/'
        ]);
	}

	/**
	* Get Image Form Status Kepegawaian Lain	* 
	* @return JSON
	*/
	public function get_berkas_status_kepegawaian_lain_file($id)
	{
		if (!$this->is_allowed('form_status_kepegawaian_lain_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_status_kepegawaian_lain = $this->model_form_status_kepegawaian_lain->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_status_kepegawaian_lain', 
            'table_name'        => 'form_status_kepegawaian_lain',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_status_kepegawaian_lain/',
            'delete_endpoint'   => 'administrator/form_status_kepegawaian_lain/delete_berkas_status_kepegawaian_lain_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_status_kepegawaian_lain_export');

		$this->model_form_status_kepegawaian_lain->export('form_status_kepegawaian_lain', 'form_status_kepegawaian_lain');
	}
}


/* End of file form_status_kepegawaian_lain.php */
/* Location: ./application/controllers/administrator/Form Status Kepegawaian Lain.php */