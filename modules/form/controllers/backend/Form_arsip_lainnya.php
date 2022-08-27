<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Arsip Lainnya Controller
*| --------------------------------------------------------------------------
*| Form Arsip Lainnya site
*|
*/
class Form_arsip_lainnya extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_arsip_lainnya');
	}

	/**
	* show all Form Arsip Lainnyas
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_arsip_lainnya_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_arsip_lainnyas'] = $this->model_form_arsip_lainnya->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_arsip_lainnya_counts'] = $this->model_form_arsip_lainnya->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_arsip_lainnya/index/',
			'total_rows'   => $this->model_form_arsip_lainnya->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Arsip Lainnya List');
		$this->render('backend/standart/administrator/form_builder/form_arsip_lainnya/form_arsip_lainnya_list', $this->data);
	}

	/**
	* Update view Form Arsip Lainnyas
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_arsip_lainnya_update');

		$this->data['form_arsip_lainnya'] = $this->model_form_arsip_lainnya->find($id);

		$this->template->title('Arsip Lainnya Update');
		$this->render('backend/standart/administrator/form_builder/form_arsip_lainnya/form_arsip_lainnya_update', $this->data);
	}

	/**
	* Update Form Arsip Lainnyas
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_arsip_lainnya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('nama_berkas', 'Nama Berkas', 'trim|required');
		$this->form_validation->set_rules('form_arsip_lainnya_berkas_arsip_lainnya_name', 'Berkas Arsip Lainnya', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_arsip_lainnya_berkas_arsip_lainnya_uuid = $this->input->post('form_arsip_lainnya_berkas_arsip_lainnya_uuid');
			$form_arsip_lainnya_berkas_arsip_lainnya_name = $this->input->post('form_arsip_lainnya_berkas_arsip_lainnya_name');
		
			$save_data = [
				'nama_berkas' => $this->input->post('nama_berkas'),
				'deskripsi_arsip' => $this->input->post('deskripsi_arsip'),
			];

			if (!is_dir(FCPATH . '/uploads/form_arsip_lainnya/')) {
				mkdir(FCPATH . '/uploads/form_arsip_lainnya/');
			}

			if (!empty($form_arsip_lainnya_berkas_arsip_lainnya_uuid)) {
				$form_arsip_lainnya_berkas_arsip_lainnya_name_copy = date('YmdHis') . '-' . $form_arsip_lainnya_berkas_arsip_lainnya_name;

				rename(FCPATH . 'uploads/tmp/' . $form_arsip_lainnya_berkas_arsip_lainnya_uuid . '/' . $form_arsip_lainnya_berkas_arsip_lainnya_name, 
						FCPATH . 'uploads/form_arsip_lainnya/' . $form_arsip_lainnya_berkas_arsip_lainnya_name_copy);

				if (!is_file(FCPATH . '/uploads/form_arsip_lainnya/' . $form_arsip_lainnya_berkas_arsip_lainnya_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_arsip_lainnya'] = $form_arsip_lainnya_berkas_arsip_lainnya_name_copy;
			}
		
			
			$save_form_arsip_lainnya = $this->model_form_arsip_lainnya->change($id, $save_data);

			if ($save_form_arsip_lainnya) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_arsip_lainnya', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_arsip_lainnya');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_arsip_lainnya');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Arsip Lainnyas
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_arsip_lainnya_delete');

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
            set_message(cclang('has_been_deleted', 'Form Arsip Lainnya'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Arsip Lainnya'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Arsip Lainnyas
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_arsip_lainnya_view');

		$this->data['form_arsip_lainnya'] = $this->model_form_arsip_lainnya->find($id);

		$this->template->title('Arsip Lainnya Detail');
		$this->render('backend/standart/administrator/form_builder/form_arsip_lainnya/form_arsip_lainnya_view', $this->data);
	}

	/**
	* delete Form Arsip Lainnyas
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_arsip_lainnya = $this->model_form_arsip_lainnya->find($id);

		if (!empty($form_arsip_lainnya->berkas_arsip_lainnya)) {
			$path = FCPATH . '/uploads/form_arsip_lainnya/' . $form_arsip_lainnya->berkas_arsip_lainnya;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_arsip_lainnya->remove($id);
	}
	
	/**
	* Upload Image Form Arsip Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_arsip_lainnya_file()
	{
		if (!$this->is_allowed('form_arsip_lainnya_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_arsip_lainnya',
		]);
	}

	/**
	* Delete Image Form Arsip Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_arsip_lainnya_file($uuid)
	{
		if (!$this->is_allowed('form_arsip_lainnya_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_arsip_lainnya', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_arsip_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_arsip_lainnya/'
        ]);
	}

	/**
	* Get Image Form Arsip Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_arsip_lainnya_file($id)
	{
		if (!$this->is_allowed('form_arsip_lainnya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_arsip_lainnya = $this->model_form_arsip_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_arsip_lainnya', 
            'table_name'        => 'form_arsip_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_arsip_lainnya/',
            'delete_endpoint'   => 'administrator/form_arsip_lainnya/delete_berkas_arsip_lainnya_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_arsip_lainnya_export');

		$this->model_form_arsip_lainnya->export('form_arsip_lainnya', 'form_arsip_lainnya');
	}
}


/* End of file form_arsip_lainnya.php */
/* Location: ./application/controllers/administrator/Form Arsip Lainnya.php */