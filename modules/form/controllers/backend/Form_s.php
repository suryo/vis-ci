<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form S Controller
*| --------------------------------------------------------------------------
*| Form S site
*|
*/
class Form_s extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_s');
	}

	/**
	* show all Form Ss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_s_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_ss'] = $this->model_form_s->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_s_counts'] = $this->model_form_s->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_s/index/',
			'total_rows'   => $this->model_form_s->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('S List');
		$this->render('backend/standart/administrator/form_builder/form_s/form_s_list', $this->data);
	}

	/**
	* Update view Form Ss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_s_update');

		$this->data['form_s'] = $this->model_form_s->find($id);

		$this->template->title('S Update');
		$this->render('backend/standart/administrator/form_builder/form_s/form_s_update', $this->data);
	}

	/**
	* Update Form Ss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_s_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('input', 'Input', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'input' => $this->input->post('input'),
			];

			
			$save_form_s = $this->model_form_s->change($id, $save_data);

			if ($save_form_s) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_s', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_s');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_s');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Ss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_s_delete');

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
            set_message(cclang('has_been_deleted', 'Form S'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form S'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Ss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_s_view');

		$this->data['form_s'] = $this->model_form_s->find($id);

		$this->template->title('S Detail');
		$this->render('backend/standart/administrator/form_builder/form_s/form_s_view', $this->data);
	}

	/**
	* delete Form Ss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_s = $this->model_form_s->find($id);

		
		return $this->model_form_s->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_s_export');

		$this->model_form_s->export('form_s', 'form_s');
	}
}


/* End of file form_s.php */
/* Location: ./application/controllers/administrator/Form S.php */