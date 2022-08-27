<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form B Controller
*| --------------------------------------------------------------------------
*| Form B site
*|
*/
class Form_b extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_b');
	}

	/**
	* show all Form Bs
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_b_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_bs'] = $this->model_form_b->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_b_counts'] = $this->model_form_b->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_b/index/',
			'total_rows'   => $this->model_form_b->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('B List');
		$this->render('backend/standart/administrator/form_builder/form_b/form_b_list', $this->data);
	}

	/**
	* Update view Form Bs
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_b_update');

		$this->data['form_b'] = $this->model_form_b->find($id);

		$this->template->title('B Update');
		$this->render('backend/standart/administrator/form_builder/form_b/form_b_update', $this->data);
	}

	/**
	* Update Form Bs
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_b_update', false)) {
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

			
			$save_form_b = $this->model_form_b->change($id, $save_data);

			if ($save_form_b) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_b', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_b');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_b');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Bs
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_b_delete');

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
            set_message(cclang('has_been_deleted', 'Form B'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form B'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Bs
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_b_view');

		$this->data['form_b'] = $this->model_form_b->find($id);

		$this->template->title('B Detail');
		$this->render('backend/standart/administrator/form_builder/form_b/form_b_view', $this->data);
	}

	/**
	* delete Form Bs
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_b = $this->model_form_b->find($id);

		
		return $this->model_form_b->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_b_export');

		$this->model_form_b->export('form_b', 'form_b');
	}
}


/* End of file form_b.php */
/* Location: ./application/controllers/administrator/Form B.php */