<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Penghargaan Lainya Controller
*| --------------------------------------------------------------------------
*| Form Penghargaan Lainya site
*|
*/
class Form_penghargaan_lainya extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_penghargaan_lainya');
	}

	/**
	* show all Form Penghargaan Lainyas
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_penghargaan_lainya_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_penghargaan_lainyas'] = $this->model_form_penghargaan_lainya->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_penghargaan_lainya_counts'] = $this->model_form_penghargaan_lainya->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_penghargaan_lainya/index/',
			'total_rows'   => $this->model_form_penghargaan_lainya->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('SK Penghargaan Lainnya List');
		$this->render('backend/standart/administrator/form_builder/form_penghargaan_lainya/form_penghargaan_lainya_list', $this->data);
	}

	/**
	* Update view Form Penghargaan Lainyas
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_penghargaan_lainya_update');

		$this->data['form_penghargaan_lainya'] = $this->model_form_penghargaan_lainya->find($id);

		$this->template->title('SK Penghargaan Lainnya Update');
		$this->render('backend/standart/administrator/form_builder/form_penghargaan_lainya/form_penghargaan_lainya_update', $this->data);
	}

	/**
	* Update Form Penghargaan Lainyas
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_penghargaan_lainya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('tanggal_penghargaan_lainnya', 'Tanggal Penghargaan Lainnya', 'trim|required');
		$this->form_validation->set_rules('deskripsi_sk_penghargaan_lainnya', 'Deskripsi SK Penghargaan Lainnya', 'trim|required');
		$this->form_validation->set_rules('form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name', 'Berkas SK Penghargaan Lainnya', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_uuid = $this->input->post('form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_uuid');
			$form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name = $this->input->post('form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name');
		
			$save_data = [
				'no_sk_penghargaan_lainnya' => $this->input->post('no_sk_penghargaan_lainnya'),
				'tanggal_penghargaan_lainnya' => $this->input->post('tanggal_penghargaan_lainnya'),
				'deskripsi_sk_penghargaan_lainnya' => $this->input->post('deskripsi_sk_penghargaan_lainnya'),
			];

			if (!is_dir(FCPATH . '/uploads/form_penghargaan_lainya/')) {
				mkdir(FCPATH . '/uploads/form_penghargaan_lainya/');
			}

			if (!empty($form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_uuid)) {
				$form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name_copy = date('YmdHis') . '-' . $form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name;

				rename(FCPATH . 'uploads/tmp/' . $form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_uuid . '/' . $form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name, 
						FCPATH . 'uploads/form_penghargaan_lainya/' . $form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name_copy);

				if (!is_file(FCPATH . '/uploads/form_penghargaan_lainya/' . $form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_penghargaan_lainnya'] = $form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name_copy;
			}
		
			
			$save_form_penghargaan_lainya = $this->model_form_penghargaan_lainya->change($id, $save_data);

			if ($save_form_penghargaan_lainya) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_penghargaan_lainya', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_penghargaan_lainya');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_penghargaan_lainya');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Penghargaan Lainyas
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_penghargaan_lainya_delete');

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
            set_message(cclang('has_been_deleted', 'Form Penghargaan Lainya'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Penghargaan Lainya'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Penghargaan Lainyas
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_penghargaan_lainya_view');

		$this->data['form_penghargaan_lainya'] = $this->model_form_penghargaan_lainya->find($id);

		$this->template->title('SK Penghargaan Lainnya Detail');
		$this->render('backend/standart/administrator/form_builder/form_penghargaan_lainya/form_penghargaan_lainya_view', $this->data);
	}

	/**
	* delete Form Penghargaan Lainyas
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_penghargaan_lainya = $this->model_form_penghargaan_lainya->find($id);

		if (!empty($form_penghargaan_lainya->berkas_sk_penghargaan_lainnya)) {
			$path = FCPATH . '/uploads/form_penghargaan_lainya/' . $form_penghargaan_lainya->berkas_sk_penghargaan_lainnya;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_penghargaan_lainya->remove($id);
	}
	
	/**
	* Upload Image Form Penghargaan Lainya	* 
	* @return JSON
	*/
	public function upload_berkas_sk_penghargaan_lainnya_file()
	{
		if (!$this->is_allowed('form_penghargaan_lainya_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_penghargaan_lainya',
		]);
	}

	/**
	* Delete Image Form Penghargaan Lainya	* 
	* @return JSON
	*/
	public function delete_berkas_sk_penghargaan_lainnya_file($uuid)
	{
		if (!$this->is_allowed('form_penghargaan_lainya_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_penghargaan_lainnya', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_penghargaan_lainya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penghargaan_lainya/'
        ]);
	}

	/**
	* Get Image Form Penghargaan Lainya	* 
	* @return JSON
	*/
	public function get_berkas_sk_penghargaan_lainnya_file($id)
	{
		if (!$this->is_allowed('form_penghargaan_lainya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_penghargaan_lainya = $this->model_form_penghargaan_lainya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_penghargaan_lainnya', 
            'table_name'        => 'form_penghargaan_lainya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penghargaan_lainya/',
            'delete_endpoint'   => 'administrator/form_penghargaan_lainya/delete_berkas_sk_penghargaan_lainnya_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_penghargaan_lainya_export');

		$this->model_form_penghargaan_lainya->export('form_penghargaan_lainya', 'form_penghargaan_lainya');
	}
}


/* End of file form_penghargaan_lainya.php */
/* Location: ./application/controllers/administrator/Form Penghargaan Lainya.php */