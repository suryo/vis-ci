<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Sk Alih Status Kepegawaian Controller
*| --------------------------------------------------------------------------
*| Form Sk Alih Status Kepegawaian site
*|
*/
class Form_sk_alih_status_kepegawaian extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_sk_alih_status_kepegawaian');
	}

	/**
	* show all Form Sk Alih Status Kepegawaians
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_sk_alih_status_kepegawaian_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_sk_alih_status_kepegawaians'] = $this->model_form_sk_alih_status_kepegawaian->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_sk_alih_status_kepegawaian_counts'] = $this->model_form_sk_alih_status_kepegawaian->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_sk_alih_status_kepegawaian/index/',
			'total_rows'   => $this->model_form_sk_alih_status_kepegawaian->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Alih Status Kepegawaian List');
		$this->render('backend/standart/administrator/form_builder/form_sk_alih_status_kepegawaian/form_sk_alih_status_kepegawaian_list', $this->data);
	}

	/**
	* Update view Form Sk Alih Status Kepegawaians
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_sk_alih_status_kepegawaian_update');

		$this->data['form_sk_alih_status_kepegawaian'] = $this->model_form_sk_alih_status_kepegawaian->find($id);

		$this->template->title('Alih Status Kepegawaian Update');
		$this->render('backend/standart/administrator/form_builder/form_sk_alih_status_kepegawaian/form_sk_alih_status_kepegawaian_update', $this->data);
	}

	/**
	* Update Form Sk Alih Status Kepegawaians
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_sk_alih_status_kepegawaian_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('no_sk_alih_status_kepegawaian', 'No. SK  Alih Status Kepegawaian', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_alih_status_kepegawaian', 'Tanggal SK  Alih Status Kepegawaian', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('deskripsi_sk_alih_status_kepegawaian', 'Deskripsi SK  Alih Status Kepegawaian', 'trim|required');
		$this->form_validation->set_rules('berkas_sk_alih_status_kepegawaian', 'Berkas SK  Alih Status Kepegawaian', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'no_sk_alih_status_kepegawaian' => $this->input->post('no_sk_alih_status_kepegawaian'),
				'tanggal_sk_alih_status_kepegawaian' => $this->input->post('tanggal_sk_alih_status_kepegawaian'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_sk_alih_status_kepegawaian' => $this->input->post('deskripsi_sk_alih_status_kepegawaian'),
				'berkas_sk_alih_status_kepegawaian' => $this->input->post('berkas_sk_alih_status_kepegawaian'),
			];

			
			$save_form_sk_alih_status_kepegawaian = $this->model_form_sk_alih_status_kepegawaian->change($id, $save_data);

			if ($save_form_sk_alih_status_kepegawaian) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_sk_alih_status_kepegawaian', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_sk_alih_status_kepegawaian');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_sk_alih_status_kepegawaian');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Sk Alih Status Kepegawaians
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_sk_alih_status_kepegawaian_delete');

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
            set_message(cclang('has_been_deleted', 'Form Sk Alih Status Kepegawaian'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Sk Alih Status Kepegawaian'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Sk Alih Status Kepegawaians
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_sk_alih_status_kepegawaian_view');

		$this->data['form_sk_alih_status_kepegawaian'] = $this->model_form_sk_alih_status_kepegawaian->find($id);

		$this->template->title('Alih Status Kepegawaian Detail');
		$this->render('backend/standart/administrator/form_builder/form_sk_alih_status_kepegawaian/form_sk_alih_status_kepegawaian_view', $this->data);
	}

	/**
	* delete Form Sk Alih Status Kepegawaians
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_sk_alih_status_kepegawaian = $this->model_form_sk_alih_status_kepegawaian->find($id);

		
		return $this->model_form_sk_alih_status_kepegawaian->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_sk_alih_status_kepegawaian_export');

		$this->model_form_sk_alih_status_kepegawaian->export('form_sk_alih_status_kepegawaian', 'form_sk_alih_status_kepegawaian');
	}
}


/* End of file form_sk_alih_status_kepegawaian.php */
/* Location: ./application/controllers/administrator/Form Sk Alih Status Kepegawaian.php */