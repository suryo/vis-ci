<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Ujian Dinas Controller
*| --------------------------------------------------------------------------
*| Form Ujian Dinas site
*|
*/
class Form_ujian_dinas extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_ujian_dinas');
	}

	/**
	* show all Form Ujian Dinass
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_ujian_dinas_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_ujian_dinass'] = $this->model_form_ujian_dinas->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_ujian_dinas_counts'] = $this->model_form_ujian_dinas->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_ujian_dinas/index/',
			'total_rows'   => $this->model_form_ujian_dinas->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Ujian Dinas List');
		$this->render('backend/standart/administrator/form_builder/form_ujian_dinas/form_ujian_dinas_list', $this->data);
	}

	/**
	* Update view Form Ujian Dinass
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_ujian_dinas_update');

		$this->data['form_ujian_dinas'] = $this->model_form_ujian_dinas->find($id);

		$this->template->title('Ujian Dinas Update');
		$this->render('backend/standart/administrator/form_builder/form_ujian_dinas/form_ujian_dinas_update', $this->data);
	}

	/**
	* Update Form Ujian Dinass
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_ujian_dinas_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('id_pegawai', 'Id Pegawai', 'trim|required');
		$this->form_validation->set_rules('jenis_ujian_dinas', 'Jenis Ujian Dinas', 'trim|required');
		$this->form_validation->set_rules('tanggal_ujian_dinas', 'Tanggal Ujian Dinas', 'trim|required');
		$this->form_validation->set_rules('form_ujian_dinas_berkas_ujian_dinas_name', 'Berkas Ujian Dinas', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_ujian_dinas_berkas_ujian_dinas_uuid = $this->input->post('form_ujian_dinas_berkas_ujian_dinas_uuid');
			$form_ujian_dinas_berkas_ujian_dinas_name = $this->input->post('form_ujian_dinas_berkas_ujian_dinas_name');
		
			$save_data = [
				'id_pegawai' => $this->input->post('id_pegawai'),
				'jenis_ujian_dinas' => $this->input->post('jenis_ujian_dinas'),
				'tanggal_ujian_dinas' => $this->input->post('tanggal_ujian_dinas'),
				'deskripsi_ujian_dinas' => $this->input->post('deskripsi_ujian_dinas'),
			];

			if (!is_dir(FCPATH . '/uploads/form_ujian_dinas/')) {
				mkdir(FCPATH . '/uploads/form_ujian_dinas/');
			}

			if (!empty($form_ujian_dinas_berkas_ujian_dinas_uuid)) {
				$form_ujian_dinas_berkas_ujian_dinas_name_copy = date('YmdHis') . '-' . $form_ujian_dinas_berkas_ujian_dinas_name;

				rename(FCPATH . 'uploads/tmp/' . $form_ujian_dinas_berkas_ujian_dinas_uuid . '/' . $form_ujian_dinas_berkas_ujian_dinas_name, 
						FCPATH . 'uploads/form_ujian_dinas/' . $form_ujian_dinas_berkas_ujian_dinas_name_copy);

				if (!is_file(FCPATH . '/uploads/form_ujian_dinas/' . $form_ujian_dinas_berkas_ujian_dinas_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_ujian_dinas'] = $form_ujian_dinas_berkas_ujian_dinas_name_copy;
			}
		
			
			$save_form_ujian_dinas = $this->model_form_ujian_dinas->change($id, $save_data);

			if ($save_form_ujian_dinas) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_ujian_dinas', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_ujian_dinas');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_ujian_dinas');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Ujian Dinass
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_ujian_dinas_delete');

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
            set_message(cclang('has_been_deleted', 'Form Ujian Dinas'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Ujian Dinas'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Ujian Dinass
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_ujian_dinas_view');

		$this->data['form_ujian_dinas'] = $this->model_form_ujian_dinas->find($id);

		$this->template->title('Ujian Dinas Detail');
		$this->render('backend/standart/administrator/form_builder/form_ujian_dinas/form_ujian_dinas_view', $this->data);
	}

	/**
	* delete Form Ujian Dinass
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_ujian_dinas = $this->model_form_ujian_dinas->find($id);

		if (!empty($form_ujian_dinas->berkas_ujian_dinas)) {
			$path = FCPATH . '/uploads/form_ujian_dinas/' . $form_ujian_dinas->berkas_ujian_dinas;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_ujian_dinas->remove($id);
	}
	
	/**
	* Upload Image Form Ujian Dinas	* 
	* @return JSON
	*/
	public function upload_berkas_ujian_dinas_file()
	{
		if (!$this->is_allowed('form_ujian_dinas_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_ujian_dinas',
			'allowed_types' => 'pdf',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Ujian Dinas	* 
	* @return JSON
	*/
	public function delete_berkas_ujian_dinas_file($uuid)
	{
		if (!$this->is_allowed('form_ujian_dinas_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_ujian_dinas', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_ujian_dinas',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_ujian_dinas/'
        ]);
	}

	/**
	* Get Image Form Ujian Dinas	* 
	* @return JSON
	*/
	public function get_berkas_ujian_dinas_file($id)
	{
		if (!$this->is_allowed('form_ujian_dinas_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_ujian_dinas = $this->model_form_ujian_dinas->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_ujian_dinas', 
            'table_name'        => 'form_ujian_dinas',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_ujian_dinas/',
            'delete_endpoint'   => 'administrator/form_ujian_dinas/delete_berkas_ujian_dinas_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_ujian_dinas_export');

		$this->model_form_ujian_dinas->export('form_ujian_dinas', 'form_ujian_dinas');
	}
}


/* End of file form_ujian_dinas.php */
/* Location: ./application/controllers/administrator/Form Ujian Dinas.php */