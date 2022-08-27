<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Ujiandinas Controller
*| --------------------------------------------------------------------------
*| Form Ujiandinas site
*|
*/
class Form_ujiandinas extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_ujiandinas');
	}

	/**
	* show all Form Ujiandinass
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_ujiandinas_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_ujiandinass'] = $this->model_form_ujiandinas->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_ujiandinas_counts'] = $this->model_form_ujiandinas->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_ujiandinas/index/',
			'total_rows'   => $this->model_form_ujiandinas->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Ujian Dinas List');
		$this->render('backend/standart/administrator/form_builder/form_ujiandinas/form_ujiandinas_list', $this->data);
	}

	/**
	* Update view Form Ujiandinass
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_ujiandinas_update');

		$this->data['form_ujiandinas'] = $this->model_form_ujiandinas->find($id);

		$this->template->title('Ujian Dinas Update');
		$this->render('backend/standart/administrator/form_builder/form_ujiandinas/form_ujiandinas_update', $this->data);
	}

	/**
	* Update Form Ujiandinass
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_ujiandinas_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('jenis_ujian_dinas', 'Jenis Ujian Dinas', 'trim|required');
		$this->form_validation->set_rules('tanggal_ujian_dinas', 'Tanggal Ujian Dinas', 'trim|required');
		$this->form_validation->set_rules('form_ujiandinas_berkas_ujian_dinas_name', 'Berkas Ujian Dinas', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_ujiandinas_berkas_ujian_dinas_uuid = $this->input->post('form_ujiandinas_berkas_ujian_dinas_uuid');
			$form_ujiandinas_berkas_ujian_dinas_name = $this->input->post('form_ujiandinas_berkas_ujian_dinas_name');
		
			$save_data = [
				'jenis_ujian_dinas' => $this->input->post('jenis_ujian_dinas'),
				'tanggal_ujian_dinas' => $this->input->post('tanggal_ujian_dinas'),
				'deskripsi_ujian_dinas' => $this->input->post('deskripsi_ujian_dinas'),
			];

			if (!is_dir(FCPATH . '/uploads/form_ujiandinas/')) {
				mkdir(FCPATH . '/uploads/form_ujiandinas/');
			}

			if (!empty($form_ujiandinas_berkas_ujian_dinas_uuid)) {
				$form_ujiandinas_berkas_ujian_dinas_name_copy = date('YmdHis') . '-' . $form_ujiandinas_berkas_ujian_dinas_name;

				rename(FCPATH . 'uploads/tmp/' . $form_ujiandinas_berkas_ujian_dinas_uuid . '/' . $form_ujiandinas_berkas_ujian_dinas_name, 
						FCPATH . 'uploads/form_ujiandinas/' . $form_ujiandinas_berkas_ujian_dinas_name_copy);

				if (!is_file(FCPATH . '/uploads/form_ujiandinas/' . $form_ujiandinas_berkas_ujian_dinas_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_ujian_dinas'] = $form_ujiandinas_berkas_ujian_dinas_name_copy;
			}
		
			
			$save_form_ujiandinas = $this->model_form_ujiandinas->change($id, $save_data);

			if ($save_form_ujiandinas) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_ujiandinas', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_ujiandinas');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_ujiandinas');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Ujiandinass
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_ujiandinas_delete');

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
            set_message(cclang('has_been_deleted', 'Form Ujiandinas'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Ujiandinas'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Ujiandinass
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_ujiandinas_view');

		$this->data['form_ujiandinas'] = $this->model_form_ujiandinas->find($id);

		$this->template->title('Ujian Dinas Detail');
		$this->render('backend/standart/administrator/form_builder/form_ujiandinas/form_ujiandinas_view', $this->data);
	}

	/**
	* delete Form Ujiandinass
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_ujiandinas = $this->model_form_ujiandinas->find($id);

		if (!empty($form_ujiandinas->berkas_ujian_dinas)) {
			$path = FCPATH . '/uploads/form_ujiandinas/' . $form_ujiandinas->berkas_ujian_dinas;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_ujiandinas->remove($id);
	}
	
	/**
	* Upload Image Form Ujiandinas	* 
	* @return JSON
	*/
	public function upload_berkas_ujian_dinas_file()
	{
		if (!$this->is_allowed('form_ujiandinas_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_ujiandinas',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Ujiandinas	* 
	* @return JSON
	*/
	public function delete_berkas_ujian_dinas_file($uuid)
	{
		if (!$this->is_allowed('form_ujiandinas_delete', false)) {
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
            'table_name'        => 'form_ujiandinas',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_ujiandinas/'
        ]);
	}

	/**
	* Get Image Form Ujiandinas	* 
	* @return JSON
	*/
	public function get_berkas_ujian_dinas_file($id)
	{
		if (!$this->is_allowed('form_ujiandinas_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_ujiandinas = $this->model_form_ujiandinas->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_ujian_dinas', 
            'table_name'        => 'form_ujiandinas',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_ujiandinas/',
            'delete_endpoint'   => 'administrator/form_ujiandinas/delete_berkas_ujian_dinas_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_ujiandinas_export');

		$this->model_form_ujiandinas->export('form_ujiandinas', 'form_ujiandinas');
	}
}


/* End of file form_ujiandinas.php */
/* Location: ./application/controllers/administrator/Form Ujiandinas.php */