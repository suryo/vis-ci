<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Spmt Controller
*| --------------------------------------------------------------------------
*| Form Spmt site
*|
*/
class Form_spmt extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_spmt');
	}

	/**
	* show all Form Spmts
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_spmt_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_spmts'] = $this->model_form_spmt->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_spmt_counts'] = $this->model_form_spmt->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_spmt/index/',
			'total_rows'   => $this->model_form_spmt->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Surat Pernyataan Menjalankan Tugas List');
		$this->render('backend/standart/administrator/form_builder/form_spmt/form_spmt_list', $this->data);
	}

	/**
	* Update view Form Spmts
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_spmt_update');

		$this->data['form_spmt'] = $this->model_form_spmt->find($id);

		$this->template->title('Surat Pernyataan Menjalankan Tugas Update');
		$this->render('backend/standart/administrator/form_builder/form_spmt/form_spmt_update', $this->data);
	}

	/**
	* Update Form Spmts
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_spmt_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('no_spmt', 'No. SPMT', 'trim|required');
		$this->form_validation->set_rules('tanggal_spmt', 'Tanggal SPMT', 'trim|required');
		$this->form_validation->set_rules('form_spmt_berkas_spmt_name', 'Berkas SPMT', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_spmt_berkas_spmt_uuid = $this->input->post('form_spmt_berkas_spmt_uuid');
			$form_spmt_berkas_spmt_name = $this->input->post('form_spmt_berkas_spmt_name');
		
			$save_data = [
				'no_spmt' => $this->input->post('no_spmt'),
				'tanggal_spmt' => $this->input->post('tanggal_spmt'),
				'deskripsi_spmt' => $this->input->post('deskripsi_spmt'),
			];

			if (!is_dir(FCPATH . '/uploads/form_spmt/')) {
				mkdir(FCPATH . '/uploads/form_spmt/');
			}

			if (!empty($form_spmt_berkas_spmt_uuid)) {
				$form_spmt_berkas_spmt_name_copy = date('YmdHis') . '-' . $form_spmt_berkas_spmt_name;

				rename(FCPATH . 'uploads/tmp/' . $form_spmt_berkas_spmt_uuid . '/' . $form_spmt_berkas_spmt_name, 
						FCPATH . 'uploads/form_spmt/' . $form_spmt_berkas_spmt_name_copy);

				if (!is_file(FCPATH . '/uploads/form_spmt/' . $form_spmt_berkas_spmt_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_spmt'] = $form_spmt_berkas_spmt_name_copy;
			}
		
			
			$save_form_spmt = $this->model_form_spmt->change($id, $save_data);

			if ($save_form_spmt) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_spmt', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_spmt');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_spmt');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Spmts
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_spmt_delete');

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
            set_message(cclang('has_been_deleted', 'Form Spmt'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Spmt'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Spmts
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_spmt_view');

		$this->data['form_spmt'] = $this->model_form_spmt->find($id);

		$this->template->title('Surat Pernyataan Menjalankan Tugas Detail');
		$this->render('backend/standart/administrator/form_builder/form_spmt/form_spmt_view', $this->data);
	}

	/**
	* delete Form Spmts
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_spmt = $this->model_form_spmt->find($id);

		if (!empty($form_spmt->berkas_spmt)) {
			$path = FCPATH . '/uploads/form_spmt/' . $form_spmt->berkas_spmt;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_spmt->remove($id);
	}
	
	/**
	* Upload Image Form Spmt	* 
	* @return JSON
	*/
	public function upload_berkas_spmt_file()
	{
		if (!$this->is_allowed('form_spmt_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_spmt',
		]);
	}

	/**
	* Delete Image Form Spmt	* 
	* @return JSON
	*/
	public function delete_berkas_spmt_file($uuid)
	{
		if (!$this->is_allowed('form_spmt_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_spmt', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_spmt',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_spmt/'
        ]);
	}

	/**
	* Get Image Form Spmt	* 
	* @return JSON
	*/
	public function get_berkas_spmt_file($id)
	{
		if (!$this->is_allowed('form_spmt_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_spmt = $this->model_form_spmt->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_spmt', 
            'table_name'        => 'form_spmt',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_spmt/',
            'delete_endpoint'   => 'administrator/form_spmt/delete_berkas_spmt_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_spmt_export');

		$this->model_form_spmt->export('form_spmt', 'form_spmt');
	}
}


/* End of file form_spmt.php */
/* Location: ./application/controllers/administrator/Form Spmt.php */