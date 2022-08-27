<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Plh Controller
*| --------------------------------------------------------------------------
*| Form Plh site
*|
*/
class Form_plh extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_plh');
	}

	/**
	* show all Form Plhs
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_plh_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_plhs'] = $this->model_form_plh->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_plh_counts'] = $this->model_form_plh->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_plh/index/',
			'total_rows'   => $this->model_form_plh->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('SK PLH List');
		$this->render('backend/standart/administrator/form_builder/form_plh/form_plh_list', $this->data);
	}

	/**
	* Update view Form Plhs
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_plh_update');

		$this->data['form_plh'] = $this->model_form_plh->find($id);

		$this->template->title('SK PLH Update');
		$this->render('backend/standart/administrator/form_builder/form_plh/form_plh_update', $this->data);
	}

	/**
	* Update Form Plhs
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_plh_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('no_sk_plh', 'No. SK PLH', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_plh', 'Tanggal SK PLH', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_plh_berkas_sk_plh_name', 'Berkas SK PLH', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_plh_berkas_sk_plh_uuid = $this->input->post('form_plh_berkas_sk_plh_uuid');
			$form_plh_berkas_sk_plh_name = $this->input->post('form_plh_berkas_sk_plh_name');
		
			$save_data = [
				'no_sk_plh' => $this->input->post('no_sk_plh'),
				'tanggal_sk_plh' => $this->input->post('tanggal_sk_plh'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_sk_plh' => $this->input->post('deskripsi_sk_plh'),
			];

			if (!is_dir(FCPATH . '/uploads/form_plh/')) {
				mkdir(FCPATH . '/uploads/form_plh/');
			}

			if (!empty($form_plh_berkas_sk_plh_uuid)) {
				$form_plh_berkas_sk_plh_name_copy = date('YmdHis') . '-' . $form_plh_berkas_sk_plh_name;

				rename(FCPATH . 'uploads/tmp/' . $form_plh_berkas_sk_plh_uuid . '/' . $form_plh_berkas_sk_plh_name, 
						FCPATH . 'uploads/form_plh/' . $form_plh_berkas_sk_plh_name_copy);

				if (!is_file(FCPATH . '/uploads/form_plh/' . $form_plh_berkas_sk_plh_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_plh'] = $form_plh_berkas_sk_plh_name_copy;
			}
		
			
			$save_form_plh = $this->model_form_plh->change($id, $save_data);

			if ($save_form_plh) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_plh', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_plh');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_plh');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Plhs
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_plh_delete');

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
            set_message(cclang('has_been_deleted', 'Form Plh'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Plh'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Plhs
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_plh_view');

		$this->data['form_plh'] = $this->model_form_plh->find($id);

		$this->template->title('SK PLH Detail');
		$this->render('backend/standart/administrator/form_builder/form_plh/form_plh_view', $this->data);
	}

	/**
	* delete Form Plhs
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_plh = $this->model_form_plh->find($id);

		if (!empty($form_plh->berkas_sk_plh)) {
			$path = FCPATH . '/uploads/form_plh/' . $form_plh->berkas_sk_plh;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_plh->remove($id);
	}
	
	/**
	* Upload Image Form Plh	* 
	* @return JSON
	*/
	public function upload_berkas_sk_plh_file()
	{
		if (!$this->is_allowed('form_plh_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_plh',
		]);
	}

	/**
	* Delete Image Form Plh	* 
	* @return JSON
	*/
	public function delete_berkas_sk_plh_file($uuid)
	{
		if (!$this->is_allowed('form_plh_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_plh', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_plh',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_plh/'
        ]);
	}

	/**
	* Get Image Form Plh	* 
	* @return JSON
	*/
	public function get_berkas_sk_plh_file($id)
	{
		if (!$this->is_allowed('form_plh_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_plh = $this->model_form_plh->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_plh', 
            'table_name'        => 'form_plh',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_plh/',
            'delete_endpoint'   => 'administrator/form_plh/delete_berkas_sk_plh_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_plh_export');

		$this->model_form_plh->export('form_plh', 'form_plh');
	}
}


/* End of file form_plh.php */
/* Location: ./application/controllers/administrator/Form Plh.php */