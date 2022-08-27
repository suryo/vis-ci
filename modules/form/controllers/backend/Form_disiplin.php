<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Disiplin Controller
*| --------------------------------------------------------------------------
*| Form Disiplin site
*|
*/
class Form_disiplin extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_disiplin');
	}

	/**
	* show all Form Disiplins
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_disiplin_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_disiplins'] = $this->model_form_disiplin->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_disiplin_counts'] = $this->model_form_disiplin->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_disiplin/index/',
			'total_rows'   => $this->model_form_disiplin->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Disiplin List');
		$this->render('backend/standart/administrator/form_builder/form_disiplin/form_disiplin_list', $this->data);
	}

	/**
	* Update view Form Disiplins
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_disiplin_update');

		$this->data['form_disiplin'] = $this->model_form_disiplin->find($id);

		$this->template->title('Disiplin Update');
		$this->render('backend/standart/administrator/form_builder/form_disiplin/form_disiplin_update', $this->data);
	}

	/**
	* Update Form Disiplins
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_disiplin_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('id_pegawai', 'Id Pegawai', 'trim|required');
		$this->form_validation->set_rules('no_surat_disiplin', 'No. Surat Disiplin', 'trim|required');
		$this->form_validation->set_rules('_tanggal_surat_disiplin', 'Tanggal Surat Disiplin', 'trim|required');
		$this->form_validation->set_rules('form_disiplin_berkas_surat_disiplin_name', 'Berkas Surat Disiplin', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_disiplin_berkas_surat_disiplin_uuid = $this->input->post('form_disiplin_berkas_surat_disiplin_uuid');
			$form_disiplin_berkas_surat_disiplin_name = $this->input->post('form_disiplin_berkas_surat_disiplin_name');
		
			$save_data = [
				'id_pegawai' => $this->input->post('id_pegawai'),
				'no_surat_disiplin' => $this->input->post('no_surat_disiplin'),
				'_tanggal_surat_disiplin' => $this->input->post('_tanggal_surat_disiplin'),
				'deskripsi_surat_disiplin' => $this->input->post('deskripsi_surat_disiplin'),
			];

			if (!is_dir(FCPATH . '/uploads/form_disiplin/')) {
				mkdir(FCPATH . '/uploads/form_disiplin/');
			}

			if (!empty($form_disiplin_berkas_surat_disiplin_uuid)) {
				$form_disiplin_berkas_surat_disiplin_name_copy = date('YmdHis') . '-' . $form_disiplin_berkas_surat_disiplin_name;

				rename(FCPATH . 'uploads/tmp/' . $form_disiplin_berkas_surat_disiplin_uuid . '/' . $form_disiplin_berkas_surat_disiplin_name, 
						FCPATH . 'uploads/form_disiplin/' . $form_disiplin_berkas_surat_disiplin_name_copy);

				if (!is_file(FCPATH . '/uploads/form_disiplin/' . $form_disiplin_berkas_surat_disiplin_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_surat_disiplin'] = $form_disiplin_berkas_surat_disiplin_name_copy;
			}
		
			
			$save_form_disiplin = $this->model_form_disiplin->change($id, $save_data);

			if ($save_form_disiplin) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_disiplin', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_disiplin');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_disiplin');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Disiplins
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_disiplin_delete');

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
            set_message(cclang('has_been_deleted', 'Form Disiplin'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Disiplin'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Disiplins
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_disiplin_view');

		$this->data['form_disiplin'] = $this->model_form_disiplin->find($id);

		$this->template->title('Disiplin Detail');
		$this->render('backend/standart/administrator/form_builder/form_disiplin/form_disiplin_view', $this->data);
	}

	/**
	* delete Form Disiplins
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_disiplin = $this->model_form_disiplin->find($id);

		if (!empty($form_disiplin->berkas_surat_disiplin)) {
			$path = FCPATH . '/uploads/form_disiplin/' . $form_disiplin->berkas_surat_disiplin;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_disiplin->remove($id);
	}
	
	/**
	* Upload Image Form Disiplin	* 
	* @return JSON
	*/
	public function upload_berkas_surat_disiplin_file()
	{
		if (!$this->is_allowed('form_disiplin_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_disiplin',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Disiplin	* 
	* @return JSON
	*/
	public function delete_berkas_surat_disiplin_file($uuid)
	{
		if (!$this->is_allowed('form_disiplin_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_surat_disiplin', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_disiplin',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_disiplin/'
        ]);
	}

	/**
	* Get Image Form Disiplin	* 
	* @return JSON
	*/
	public function get_berkas_surat_disiplin_file($id)
	{
		if (!$this->is_allowed('form_disiplin_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_disiplin = $this->model_form_disiplin->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_surat_disiplin', 
            'table_name'        => 'form_disiplin',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_disiplin/',
            'delete_endpoint'   => 'administrator/form_disiplin/delete_berkas_surat_disiplin_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_disiplin_export');

		$this->model_form_disiplin->export('form_disiplin', 'form_disiplin');
	}
}


/* End of file form_disiplin.php */
/* Location: ./application/controllers/administrator/Form Disiplin.php */