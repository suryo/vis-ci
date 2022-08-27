<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Spp Controller
*| --------------------------------------------------------------------------
*| Form Spp site
*|
*/
class Form_spp extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_spp');
	}

	/**
	* show all Form Spps
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_spp_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_spps'] = $this->model_form_spp->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_spp_counts'] = $this->model_form_spp->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_spp/index/',
			'total_rows'   => $this->model_form_spp->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Surat Perintah Penugasan List');
		$this->render('backend/standart/administrator/form_builder/form_spp/form_spp_list', $this->data);
	}

	/**
	* Update view Form Spps
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_spp_update');

		$this->data['form_spp'] = $this->model_form_spp->find($id);

		$this->template->title('Surat Perintah Penugasan Update');
		$this->render('backend/standart/administrator/form_builder/form_spp/form_spp_update', $this->data);
	}

	/**
	* Update Form Spps
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_spp_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('no_spp', 'No. SPP', 'trim|required');
		$this->form_validation->set_rules('tanggal_spp', 'Tanggal SPP', 'trim|required');
		$this->form_validation->set_rules('form_spp_berkas_spp_name', 'Berkas SPP', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_spp_berkas_spp_uuid = $this->input->post('form_spp_berkas_spp_uuid');
			$form_spp_berkas_spp_name = $this->input->post('form_spp_berkas_spp_name');
		
			$save_data = [
				'no_spp' => $this->input->post('no_spp'),
				'tanggal_spp' => $this->input->post('tanggal_spp'),
				'deskripsi_spp' => $this->input->post('deskripsi_spp'),
			];

			if (!is_dir(FCPATH . '/uploads/form_spp/')) {
				mkdir(FCPATH . '/uploads/form_spp/');
			}

			if (!empty($form_spp_berkas_spp_uuid)) {
				$form_spp_berkas_spp_name_copy = date('YmdHis') . '-' . $form_spp_berkas_spp_name;

				rename(FCPATH . 'uploads/tmp/' . $form_spp_berkas_spp_uuid . '/' . $form_spp_berkas_spp_name, 
						FCPATH . 'uploads/form_spp/' . $form_spp_berkas_spp_name_copy);

				if (!is_file(FCPATH . '/uploads/form_spp/' . $form_spp_berkas_spp_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_spp'] = $form_spp_berkas_spp_name_copy;
			}
		
			
			$save_form_spp = $this->model_form_spp->change($id, $save_data);

			if ($save_form_spp) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_spp', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_spp');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_spp');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Spps
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_spp_delete');

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
            set_message(cclang('has_been_deleted', 'Form Spp'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Spp'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Spps
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_spp_view');

		$this->data['form_spp'] = $this->model_form_spp->find($id);

		$this->template->title('Surat Perintah Penugasan Detail');
		$this->render('backend/standart/administrator/form_builder/form_spp/form_spp_view', $this->data);
	}

	/**
	* delete Form Spps
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_spp = $this->model_form_spp->find($id);

		if (!empty($form_spp->berkas_spp)) {
			$path = FCPATH . '/uploads/form_spp/' . $form_spp->berkas_spp;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_spp->remove($id);
	}
	
	/**
	* Upload Image Form Spp	* 
	* @return JSON
	*/
	public function upload_berkas_spp_file()
	{
		if (!$this->is_allowed('form_spp_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_spp',
		]);
	}

	/**
	* Delete Image Form Spp	* 
	* @return JSON
	*/
	public function delete_berkas_spp_file($uuid)
	{
		if (!$this->is_allowed('form_spp_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_spp', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_spp',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_spp/'
        ]);
	}

	/**
	* Get Image Form Spp	* 
	* @return JSON
	*/
	public function get_berkas_spp_file($id)
	{
		if (!$this->is_allowed('form_spp_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_spp = $this->model_form_spp->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_spp', 
            'table_name'        => 'form_spp',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_spp/',
            'delete_endpoint'   => 'administrator/form_spp/delete_berkas_spp_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_spp_export');

		$this->model_form_spp->export('form_spp', 'form_spp');
	}
}


/* End of file form_spp.php */
/* Location: ./application/controllers/administrator/Form Spp.php */