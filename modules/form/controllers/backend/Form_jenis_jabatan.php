<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Jenis Jabatan Controller
*| --------------------------------------------------------------------------
*| Form Jenis Jabatan site
*|
*/
class Form_jenis_jabatan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_jenis_jabatan');
	}

	/**
	* show all Form Jenis Jabatans
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_jenis_jabatan_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_jenis_jabatans'] = $this->model_form_jenis_jabatan->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_jenis_jabatan_counts'] = $this->model_form_jenis_jabatan->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_jenis_jabatan/index/',
			'total_rows'   => $this->model_form_jenis_jabatan->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Master Jenis Jabatan List');
		$this->render('backend/standart/administrator/form_builder/form_jenis_jabatan/form_jenis_jabatan_list', $this->data);
	}

	/**
	* Update view Form Jenis Jabatans
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_jenis_jabatan_update');

		$this->data['form_jenis_jabatan'] = $this->model_form_jenis_jabatan->find($id);

		$this->template->title('Master Jenis Jabatan Update');
		$this->render('backend/standart/administrator/form_builder/form_jenis_jabatan/form_jenis_jabatan_update', $this->data);
	}

	/**
	* Update Form Jenis Jabatans
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_jenis_jabatan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('nama_jenis_jabatan', 'Nama Jenis Jabatan', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'nama_jenis_jabatan' => $this->input->post('nama_jenis_jabatan'),
			];

			
			$save_form_jenis_jabatan = $this->model_form_jenis_jabatan->change($id, $save_data);

			if ($save_form_jenis_jabatan) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_jenis_jabatan', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_jenis_jabatan');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_jenis_jabatan');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Jenis Jabatans
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_jenis_jabatan_delete');

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
            set_message(cclang('has_been_deleted', 'Form Jenis Jabatan'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Jenis Jabatan'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Jenis Jabatans
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_jenis_jabatan_view');

		$this->data['form_jenis_jabatan'] = $this->model_form_jenis_jabatan->find($id);

		$this->template->title('Master Jenis Jabatan Detail');
		$this->render('backend/standart/administrator/form_builder/form_jenis_jabatan/form_jenis_jabatan_view', $this->data);
	}

	/**
	* delete Form Jenis Jabatans
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_jenis_jabatan = $this->model_form_jenis_jabatan->find($id);

		
		return $this->model_form_jenis_jabatan->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_jenis_jabatan_export');

		$this->model_form_jenis_jabatan->export('form_jenis_jabatan', 'form_jenis_jabatan');
	}
}


/* End of file form_jenis_jabatan.php */
/* Location: ./application/controllers/administrator/Form Jenis Jabatan.php */