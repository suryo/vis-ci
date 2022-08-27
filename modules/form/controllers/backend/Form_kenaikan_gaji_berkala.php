<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Kenaikan Gaji Berkala Controller
*| --------------------------------------------------------------------------
*| Form Kenaikan Gaji Berkala site
*|
*/
class Form_kenaikan_gaji_berkala extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_kenaikan_gaji_berkala');
	}

	/**
	* show all Form Kenaikan Gaji Berkalas
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_kenaikan_gaji_berkala_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_kenaikan_gaji_berkalas'] = $this->model_form_kenaikan_gaji_berkala->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_kenaikan_gaji_berkala_counts'] = $this->model_form_kenaikan_gaji_berkala->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_kenaikan_gaji_berkala/index/',
			'total_rows'   => $this->model_form_kenaikan_gaji_berkala->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Surat Kenaikan Gaji Berkala List');
		$this->render('backend/standart/administrator/form_builder/form_kenaikan_gaji_berkala/form_kenaikan_gaji_berkala_list', $this->data);
	}

	/**
	* Update view Form Kenaikan Gaji Berkalas
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_kenaikan_gaji_berkala_update');

		$this->data['form_kenaikan_gaji_berkala'] = $this->model_form_kenaikan_gaji_berkala->find($id);

		$this->template->title('Surat Kenaikan Gaji Berkala Update');
		$this->render('backend/standart/administrator/form_builder/form_kenaikan_gaji_berkala/form_kenaikan_gaji_berkala_update', $this->data);
	}

	/**
	* Update Form Kenaikan Gaji Berkalas
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_kenaikan_gaji_berkala_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('no_surat_kenaikan_gaji_berkala', 'No. Surat Kenaikan Gaji Berkala', 'trim|required');
		$this->form_validation->set_rules('tanggal_surat_kenaikan_gaji_berkala', 'Tanggal Surat Kenaikan Gaji Berkala', 'trim|required');
		$this->form_validation->set_rules('form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name', 'Berkas Surat Kenaikan Gaji Berkala', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_uuid = $this->input->post('form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_uuid');
			$form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name = $this->input->post('form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name');
		
			$save_data = [
				'no_surat_kenaikan_gaji_berkala' => $this->input->post('no_surat_kenaikan_gaji_berkala'),
				'tanggal_surat_kenaikan_gaji_berkala' => $this->input->post('tanggal_surat_kenaikan_gaji_berkala'),
				'deskripsi_surat_kenaikan_gaji_berkala' => $this->input->post('deskripsi_surat_kenaikan_gaji_berkala'),
			];

			if (!is_dir(FCPATH . '/uploads/form_kenaikan_gaji_berkala/')) {
				mkdir(FCPATH . '/uploads/form_kenaikan_gaji_berkala/');
			}

			if (!empty($form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_uuid)) {
				$form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name_copy = date('YmdHis') . '-' . $form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name;

				rename(FCPATH . 'uploads/tmp/' . $form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_uuid . '/' . $form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name, 
						FCPATH . 'uploads/form_kenaikan_gaji_berkala/' . $form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name_copy);

				if (!is_file(FCPATH . '/uploads/form_kenaikan_gaji_berkala/' . $form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_surat_kenaikan_gaji_berkala'] = $form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name_copy;
			}
		
			
			$save_form_kenaikan_gaji_berkala = $this->model_form_kenaikan_gaji_berkala->change($id, $save_data);

			if ($save_form_kenaikan_gaji_berkala) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_kenaikan_gaji_berkala', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_kenaikan_gaji_berkala');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_kenaikan_gaji_berkala');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Kenaikan Gaji Berkalas
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_kenaikan_gaji_berkala_delete');

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
            set_message(cclang('has_been_deleted', 'Form Kenaikan Gaji Berkala'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Kenaikan Gaji Berkala'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Kenaikan Gaji Berkalas
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_kenaikan_gaji_berkala_view');

		$this->data['form_kenaikan_gaji_berkala'] = $this->model_form_kenaikan_gaji_berkala->find($id);

		$this->template->title('Surat Kenaikan Gaji Berkala Detail');
		$this->render('backend/standart/administrator/form_builder/form_kenaikan_gaji_berkala/form_kenaikan_gaji_berkala_view', $this->data);
	}

	/**
	* delete Form Kenaikan Gaji Berkalas
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_kenaikan_gaji_berkala = $this->model_form_kenaikan_gaji_berkala->find($id);

		if (!empty($form_kenaikan_gaji_berkala->berkas_surat_kenaikan_gaji_berkala)) {
			$path = FCPATH . '/uploads/form_kenaikan_gaji_berkala/' . $form_kenaikan_gaji_berkala->berkas_surat_kenaikan_gaji_berkala;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_kenaikan_gaji_berkala->remove($id);
	}
	
	/**
	* Upload Image Form Kenaikan Gaji Berkala	* 
	* @return JSON
	*/
	public function upload_berkas_surat_kenaikan_gaji_berkala_file()
	{
		if (!$this->is_allowed('form_kenaikan_gaji_berkala_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_kenaikan_gaji_berkala',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Kenaikan Gaji Berkala	* 
	* @return JSON
	*/
	public function delete_berkas_surat_kenaikan_gaji_berkala_file($uuid)
	{
		if (!$this->is_allowed('form_kenaikan_gaji_berkala_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_surat_kenaikan_gaji_berkala', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_kenaikan_gaji_berkala',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_kenaikan_gaji_berkala/'
        ]);
	}

	/**
	* Get Image Form Kenaikan Gaji Berkala	* 
	* @return JSON
	*/
	public function get_berkas_surat_kenaikan_gaji_berkala_file($id)
	{
		if (!$this->is_allowed('form_kenaikan_gaji_berkala_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_kenaikan_gaji_berkala = $this->model_form_kenaikan_gaji_berkala->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_surat_kenaikan_gaji_berkala', 
            'table_name'        => 'form_kenaikan_gaji_berkala',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_kenaikan_gaji_berkala/',
            'delete_endpoint'   => 'administrator/form_kenaikan_gaji_berkala/delete_berkas_surat_kenaikan_gaji_berkala_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_kenaikan_gaji_berkala_export');

		$this->model_form_kenaikan_gaji_berkala->export('form_kenaikan_gaji_berkala', 'form_kenaikan_gaji_berkala');
	}
}


/* End of file form_kenaikan_gaji_berkala.php */
/* Location: ./application/controllers/administrator/Form Kenaikan Gaji Berkala.php */