<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Berita Acara Controller
*| --------------------------------------------------------------------------
*| Form Berita Acara site
*|
*/
class Form_berita_acara extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_berita_acara');
	}

	/**
	* show all Form Berita Acaras
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_berita_acara_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_berita_acaras'] = $this->model_form_berita_acara->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_berita_acara_counts'] = $this->model_form_berita_acara->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_berita_acara/index/',
			'total_rows'   => $this->model_form_berita_acara->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Surat Berita Acara List');
		$this->render('backend/standart/administrator/form_builder/form_berita_acara/form_berita_acara_list', $this->data);
	}

	/**
	* Update view Form Berita Acaras
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_berita_acara_update');

		$this->data['form_berita_acara'] = $this->model_form_berita_acara->find($id);

		$this->template->title('Surat Berita Acara Update');
		$this->render('backend/standart/administrator/form_builder/form_berita_acara/form_berita_acara_update', $this->data);
	}

	/**
	* Update Form Berita Acaras
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_berita_acara_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('no_berita_acara', 'No. Berita Acara', 'trim|required');
		$this->form_validation->set_rules('tanggal_berita_acara', 'Tanggal Berita Acara', 'trim|required');
		$this->form_validation->set_rules('form_berita_acara_berkas_berita_acara_name', 'Berkas Berita Acara', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_berita_acara_berkas_berita_acara_uuid = $this->input->post('form_berita_acara_berkas_berita_acara_uuid');
			$form_berita_acara_berkas_berita_acara_name = $this->input->post('form_berita_acara_berkas_berita_acara_name');
		
			$save_data = [
				'no_berita_acara' => $this->input->post('no_berita_acara'),
				'tanggal_berita_acara' => $this->input->post('tanggal_berita_acara'),
				'deskripsi_berita_acara' => $this->input->post('deskripsi_berita_acara'),
			];

			if (!is_dir(FCPATH . '/uploads/form_berita_acara/')) {
				mkdir(FCPATH . '/uploads/form_berita_acara/');
			}

			if (!empty($form_berita_acara_berkas_berita_acara_uuid)) {
				$form_berita_acara_berkas_berita_acara_name_copy = date('YmdHis') . '-' . $form_berita_acara_berkas_berita_acara_name;

				rename(FCPATH . 'uploads/tmp/' . $form_berita_acara_berkas_berita_acara_uuid . '/' . $form_berita_acara_berkas_berita_acara_name, 
						FCPATH . 'uploads/form_berita_acara/' . $form_berita_acara_berkas_berita_acara_name_copy);

				if (!is_file(FCPATH . '/uploads/form_berita_acara/' . $form_berita_acara_berkas_berita_acara_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_berita_acara'] = $form_berita_acara_berkas_berita_acara_name_copy;
			}
		
			
			$save_form_berita_acara = $this->model_form_berita_acara->change($id, $save_data);

			if ($save_form_berita_acara) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_berita_acara', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_berita_acara');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_berita_acara');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Berita Acaras
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_berita_acara_delete');

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
            set_message(cclang('has_been_deleted', 'Form Berita Acara'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Berita Acara'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Berita Acaras
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_berita_acara_view');

		$this->data['form_berita_acara'] = $this->model_form_berita_acara->find($id);

		$this->template->title('Surat Berita Acara Detail');
		$this->render('backend/standart/administrator/form_builder/form_berita_acara/form_berita_acara_view', $this->data);
	}

	/**
	* delete Form Berita Acaras
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_berita_acara = $this->model_form_berita_acara->find($id);

		if (!empty($form_berita_acara->berkas_berita_acara)) {
			$path = FCPATH . '/uploads/form_berita_acara/' . $form_berita_acara->berkas_berita_acara;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_berita_acara->remove($id);
	}
	
	/**
	* Upload Image Form Berita Acara	* 
	* @return JSON
	*/
	public function upload_berkas_berita_acara_file()
	{
		if (!$this->is_allowed('form_berita_acara_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_berita_acara',
		]);
	}

	/**
	* Delete Image Form Berita Acara	* 
	* @return JSON
	*/
	public function delete_berkas_berita_acara_file($uuid)
	{
		if (!$this->is_allowed('form_berita_acara_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_berita_acara', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_berita_acara',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_berita_acara/'
        ]);
	}

	/**
	* Get Image Form Berita Acara	* 
	* @return JSON
	*/
	public function get_berkas_berita_acara_file($id)
	{
		if (!$this->is_allowed('form_berita_acara_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_berita_acara = $this->model_form_berita_acara->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_berita_acara', 
            'table_name'        => 'form_berita_acara',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_berita_acara/',
            'delete_endpoint'   => 'administrator/form_berita_acara/delete_berkas_berita_acara_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_berita_acara_export');

		$this->model_form_berita_acara->export('form_berita_acara', 'form_berita_acara');
	}
}


/* End of file form_berita_acara.php */
/* Location: ./application/controllers/administrator/Form Berita Acara.php */