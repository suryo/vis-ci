<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Check Controller
*| --------------------------------------------------------------------------
*| Form Check site
*|
*/
class Form_check extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_check');
	}

	/**
	* show all Form Checks
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_check_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_checks'] = $this->model_form_check->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_check_counts'] = $this->model_form_check->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_check/index/',
			'total_rows'   => $this->model_form_check->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Check List');
		$this->render('backend/standart/administrator/form_builder/form_check/form_check_list', $this->data);
	}

	/**
	* Update view Form Checks
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_check_update');

		$this->data['form_check'] = $this->model_form_check->find($id);

		$this->template->title('Check Update');
		$this->render('backend/standart/administrator/form_builder/form_check/form_check_update', $this->data);
	}

	/**
	* Update Form Checks
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_check_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('custom_option', 'Custom Option', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'custom_option' => $this->input->post('custom_option'),
			];

			
			$save_form_check = $this->model_form_check->change($id, $save_data);

			if ($save_form_check) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_check', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_check');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_check');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Checks
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_check_delete');

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
            set_message(cclang('has_been_deleted', 'Form Check'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Check'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Checks
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_check_view');

		$this->data['form_check'] = $this->model_form_check->find($id);

		$this->template->title('Check Detail');
		$this->render('backend/standart/administrator/form_builder/form_check/form_check_view', $this->data);
	}

	/**
	* delete Form Checks
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_check = $this->model_form_check->find($id);

		
		return $this->model_form_check->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_check_export');

		$this->model_form_check->export('form_check', 'form_check');
	}
}


/* End of file form_check.php */
/* Location: ./application/controllers/administrator/Form Check.php */