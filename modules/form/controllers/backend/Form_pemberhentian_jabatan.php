<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Pemberhentian Jabatan Controller
*| --------------------------------------------------------------------------
*| Form Pemberhentian Jabatan site
*|
*/
class Form_pemberhentian_jabatan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_pemberhentian_jabatan');
	}

	/**
	* show all Form Pemberhentian Jabatans
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_pemberhentian_jabatan_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_pemberhentian_jabatans'] = $this->model_form_pemberhentian_jabatan->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_pemberhentian_jabatan_counts'] = $this->model_form_pemberhentian_jabatan->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_pemberhentian_jabatan/index/',
			'total_rows'   => $this->model_form_pemberhentian_jabatan->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('SK Pemberhentian Jabatan List');
		$this->render('backend/standart/administrator/form_builder/form_pemberhentian_jabatan/form_pemberhentian_jabatan_list', $this->data);
	}

	/**
	* Update view Form Pemberhentian Jabatans
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_pemberhentian_jabatan_update');

		$this->data['form_pemberhentian_jabatan'] = $this->model_form_pemberhentian_jabatan->find($id);

		$this->template->title('SK Pemberhentian Jabatan Update');
		$this->render('backend/standart/administrator/form_builder/form_pemberhentian_jabatan/form_pemberhentian_jabatan_update', $this->data);
	}

	/**
	* Update Form Pemberhentian Jabatans
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_pemberhentian_jabatan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('no_sk_pemberhentian_jabatan', 'No. SK Pemberhentian Jabatan', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_pemberhentian_jabatan', 'Tanggal SK Pemberhentian Jabatan', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name', 'Berkas SK Pemberhentian Jabatan', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_uuid = $this->input->post('form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_uuid');
			$form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name = $this->input->post('form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name');
		
			$save_data = [
				'no_sk_pemberhentian_jabatan' => $this->input->post('no_sk_pemberhentian_jabatan'),
				'tanggal_sk_pemberhentian_jabatan' => $this->input->post('tanggal_sk_pemberhentian_jabatan'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_sk_pemberhentian_jabatan' => $this->input->post('deskripsi_sk_pemberhentian_jabatan'),
			];

			if (!is_dir(FCPATH . '/uploads/form_pemberhentian_jabatan/')) {
				mkdir(FCPATH . '/uploads/form_pemberhentian_jabatan/');
			}

			if (!empty($form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_uuid)) {
				$form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name_copy = date('YmdHis') . '-' . $form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_uuid . '/' . $form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name, 
						FCPATH . 'uploads/form_pemberhentian_jabatan/' . $form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_pemberhentian_jabatan/' . $form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_pemberhentian_jabatan'] = $form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name_copy;
			}
		
			
			$save_form_pemberhentian_jabatan = $this->model_form_pemberhentian_jabatan->change($id, $save_data);

			if ($save_form_pemberhentian_jabatan) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_pemberhentian_jabatan', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_pemberhentian_jabatan');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_pemberhentian_jabatan');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Pemberhentian Jabatans
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_pemberhentian_jabatan_delete');

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
            set_message(cclang('has_been_deleted', 'Form Pemberhentian Jabatan'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Pemberhentian Jabatan'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Pemberhentian Jabatans
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_pemberhentian_jabatan_view');

		$this->data['form_pemberhentian_jabatan'] = $this->model_form_pemberhentian_jabatan->find($id);

		$this->template->title('SK Pemberhentian Jabatan Detail');
		$this->render('backend/standart/administrator/form_builder/form_pemberhentian_jabatan/form_pemberhentian_jabatan_view', $this->data);
	}

	/**
	* delete Form Pemberhentian Jabatans
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_pemberhentian_jabatan = $this->model_form_pemberhentian_jabatan->find($id);

		if (!empty($form_pemberhentian_jabatan->berkas_sk_pemberhentian_jabatan)) {
			$path = FCPATH . '/uploads/form_pemberhentian_jabatan/' . $form_pemberhentian_jabatan->berkas_sk_pemberhentian_jabatan;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_pemberhentian_jabatan->remove($id);
	}
	
	/**
	* Upload Image Form Pemberhentian Jabatan	* 
	* @return JSON
	*/
	public function upload_berkas_sk_pemberhentian_jabatan_file()
	{
		if (!$this->is_allowed('form_pemberhentian_jabatan_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_pemberhentian_jabatan',
		]);
	}

	/**
	* Delete Image Form Pemberhentian Jabatan	* 
	* @return JSON
	*/
	public function delete_berkas_sk_pemberhentian_jabatan_file($uuid)
	{
		if (!$this->is_allowed('form_pemberhentian_jabatan_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_pemberhentian_jabatan', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_pemberhentian_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pemberhentian_jabatan/'
        ]);
	}

	/**
	* Get Image Form Pemberhentian Jabatan	* 
	* @return JSON
	*/
	public function get_berkas_sk_pemberhentian_jabatan_file($id)
	{
		if (!$this->is_allowed('form_pemberhentian_jabatan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_pemberhentian_jabatan = $this->model_form_pemberhentian_jabatan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_pemberhentian_jabatan', 
            'table_name'        => 'form_pemberhentian_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pemberhentian_jabatan/',
            'delete_endpoint'   => 'administrator/form_pemberhentian_jabatan/delete_berkas_sk_pemberhentian_jabatan_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_pemberhentian_jabatan_export');

		$this->model_form_pemberhentian_jabatan->export('form_pemberhentian_jabatan', 'form_pemberhentian_jabatan');
	}
}


/* End of file form_pemberhentian_jabatan.php */
/* Location: ./application/controllers/administrator/Form Pemberhentian Jabatan.php */