<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Nama Pangkat Ataugolongan Controller
*| --------------------------------------------------------------------------
*| Form Nama Pangkat Ataugolongan site
*|
*/
class Form_nama_pangkat_ataugolongan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_nama_pangkat_ataugolongan');
	}

	/**
	* show all Form Nama Pangkat Ataugolongans
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_nama_pangkat_ataugolongan_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_nama_pangkat_ataugolongans'] = $this->model_form_nama_pangkat_ataugolongan->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_nama_pangkat_ataugolongan_counts'] = $this->model_form_nama_pangkat_ataugolongan->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_nama_pangkat_ataugolongan/index/',
			'total_rows'   => $this->model_form_nama_pangkat_ataugolongan->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Master Nama Pangkat Atau Golongan List');
		$this->render('backend/standart/administrator/form_builder/form_nama_pangkat_ataugolongan/form_nama_pangkat_ataugolongan_list', $this->data);
	}

	/**
	* Update view Form Nama Pangkat Ataugolongans
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_nama_pangkat_ataugolongan_update');

		$this->data['form_nama_pangkat_ataugolongan'] = $this->model_form_nama_pangkat_ataugolongan->find($id);

		$this->template->title('Master Nama Pangkat Atau Golongan Update');
		$this->render('backend/standart/administrator/form_builder/form_nama_pangkat_ataugolongan/form_nama_pangkat_ataugolongan_update', $this->data);
	}

	/**
	* Update Form Nama Pangkat Ataugolongans
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_nama_pangkat_ataugolongan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('nama_pangkat_golongan', 'Nama Pangkat/Golongan', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'nama_pangkat_golongan' => $this->input->post('nama_pangkat_golongan'),
			];

			
			$save_form_nama_pangkat_ataugolongan = $this->model_form_nama_pangkat_ataugolongan->change($id, $save_data);

			if ($save_form_nama_pangkat_ataugolongan) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_nama_pangkat_ataugolongan', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_nama_pangkat_ataugolongan');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_nama_pangkat_ataugolongan');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Nama Pangkat Ataugolongans
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_nama_pangkat_ataugolongan_delete');

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
            set_message(cclang('has_been_deleted', 'Form Nama Pangkat Ataugolongan'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Nama Pangkat Ataugolongan'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Nama Pangkat Ataugolongans
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_nama_pangkat_ataugolongan_view');

		$this->data['form_nama_pangkat_ataugolongan'] = $this->model_form_nama_pangkat_ataugolongan->find($id);

		$this->template->title('Master Nama Pangkat Atau Golongan Detail');
		$this->render('backend/standart/administrator/form_builder/form_nama_pangkat_ataugolongan/form_nama_pangkat_ataugolongan_view', $this->data);
	}

	/**
	* delete Form Nama Pangkat Ataugolongans
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_nama_pangkat_ataugolongan = $this->model_form_nama_pangkat_ataugolongan->find($id);

		
		return $this->model_form_nama_pangkat_ataugolongan->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_nama_pangkat_ataugolongan_export');

		$this->model_form_nama_pangkat_ataugolongan->export('form_nama_pangkat_ataugolongan', 'form_nama_pangkat_ataugolongan');
	}
}


/* End of file form_nama_pangkat_ataugolongan.php */
/* Location: ./application/controllers/administrator/Form Nama Pangkat Ataugolongan.php */