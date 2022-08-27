<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Jenis Penghargaan Controller
*| --------------------------------------------------------------------------
*| Form Jenis Penghargaan site
*|
*/
class Form_jenis_penghargaan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_jenis_penghargaan');
	}

	/**
	* show all Form Jenis Penghargaans
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_jenis_penghargaan_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_jenis_penghargaans'] = $this->model_form_jenis_penghargaan->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_jenis_penghargaan_counts'] = $this->model_form_jenis_penghargaan->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_jenis_penghargaan/index/',
			'total_rows'   => $this->model_form_jenis_penghargaan->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Master Jenis Penghargaan List');
		$this->render('backend/standart/administrator/form_builder/form_jenis_penghargaan/form_jenis_penghargaan_list', $this->data);
	}

	/**
	* Update view Form Jenis Penghargaans
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_jenis_penghargaan_update');

		$this->data['form_jenis_penghargaan'] = $this->model_form_jenis_penghargaan->find($id);

		$this->template->title('Master Jenis Penghargaan Update');
		$this->render('backend/standart/administrator/form_builder/form_jenis_penghargaan/form_jenis_penghargaan_update', $this->data);
	}

	/**
	* Update Form Jenis Penghargaans
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_jenis_penghargaan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('jenis_penghargaan', 'Jenis Penghargaan', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'jenis_penghargaan' => $this->input->post('jenis_penghargaan'),
			];

			
			$save_form_jenis_penghargaan = $this->model_form_jenis_penghargaan->change($id, $save_data);

			if ($save_form_jenis_penghargaan) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_jenis_penghargaan', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_jenis_penghargaan');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_jenis_penghargaan');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Jenis Penghargaans
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_jenis_penghargaan_delete');

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
            set_message(cclang('has_been_deleted', 'Form Jenis Penghargaan'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Jenis Penghargaan'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Jenis Penghargaans
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_jenis_penghargaan_view');

		$this->data['form_jenis_penghargaan'] = $this->model_form_jenis_penghargaan->find($id);

		$this->template->title('Master Jenis Penghargaan Detail');
		$this->render('backend/standart/administrator/form_builder/form_jenis_penghargaan/form_jenis_penghargaan_view', $this->data);
	}

	/**
	* delete Form Jenis Penghargaans
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_jenis_penghargaan = $this->model_form_jenis_penghargaan->find($id);

		
		return $this->model_form_jenis_penghargaan->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_jenis_penghargaan_export');

		$this->model_form_jenis_penghargaan->export('form_jenis_penghargaan', 'form_jenis_penghargaan');
	}
}


/* End of file form_jenis_penghargaan.php */
/* Location: ./application/controllers/administrator/Form Jenis Penghargaan.php */