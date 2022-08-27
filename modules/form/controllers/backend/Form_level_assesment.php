<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Level Assesment Controller
*| --------------------------------------------------------------------------
*| Form Level Assesment site
*|
*/
class Form_level_assesment extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_level_assesment');
	}

	/**
	* show all Form Level Assesments
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_level_assesment_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_level_assesments'] = $this->model_form_level_assesment->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_level_assesment_counts'] = $this->model_form_level_assesment->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_level_assesment/index/',
			'total_rows'   => $this->model_form_level_assesment->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Level Assesment List');
		$this->render('backend/standart/administrator/form_builder/form_level_assesment/form_level_assesment_list', $this->data);
	}

	/**
	* Update view Form Level Assesments
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_level_assesment_update');

		$this->data['form_level_assesment'] = $this->model_form_level_assesment->find($id);

		$this->template->title('Level Assesment Update');
		$this->render('backend/standart/administrator/form_builder/form_level_assesment/form_level_assesment_update', $this->data);
	}

	/**
	* Update Form Level Assesments
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_level_assesment_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('level_assesment', 'Level Assesment', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'level_assesment' => $this->input->post('level_assesment'),
			];

			
			$save_form_level_assesment = $this->model_form_level_assesment->change($id, $save_data);

			if ($save_form_level_assesment) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_level_assesment', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_level_assesment');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_level_assesment');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Level Assesments
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_level_assesment_delete');

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
            set_message(cclang('has_been_deleted', 'Form Level Assesment'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Level Assesment'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Level Assesments
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_level_assesment_view');

		$this->data['form_level_assesment'] = $this->model_form_level_assesment->find($id);

		$this->template->title('Level Assesment Detail');
		$this->render('backend/standart/administrator/form_builder/form_level_assesment/form_level_assesment_view', $this->data);
	}

	/**
	* delete Form Level Assesments
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_level_assesment = $this->model_form_level_assesment->find($id);

		
		return $this->model_form_level_assesment->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_level_assesment_export');

		$this->model_form_level_assesment->export('form_level_assesment', 'form_level_assesment');
	}
}


/* End of file form_level_assesment.php */
/* Location: ./application/controllers/administrator/Form Level Assesment.php */