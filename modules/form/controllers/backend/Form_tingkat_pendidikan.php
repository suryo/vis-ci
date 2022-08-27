<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Tingkat Pendidikan Controller
*| --------------------------------------------------------------------------
*| Form Tingkat Pendidikan site
*|
*/
class Form_tingkat_pendidikan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_tingkat_pendidikan');
	}

	/**
	* show all Form Tingkat Pendidikans
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_tingkat_pendidikan_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_tingkat_pendidikans'] = $this->model_form_tingkat_pendidikan->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_tingkat_pendidikan_counts'] = $this->model_form_tingkat_pendidikan->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_tingkat_pendidikan/index/',
			'total_rows'   => $this->model_form_tingkat_pendidikan->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Master Tingkat Pendidikan List');
		$this->render('backend/standart/administrator/form_builder/form_tingkat_pendidikan/form_tingkat_pendidikan_list', $this->data);
	}

	/**
	* Update view Form Tingkat Pendidikans
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_tingkat_pendidikan_update');

		$this->data['form_tingkat_pendidikan'] = $this->model_form_tingkat_pendidikan->find($id);

		$this->template->title('Master Tingkat Pendidikan Update');
		$this->render('backend/standart/administrator/form_builder/form_tingkat_pendidikan/form_tingkat_pendidikan_update', $this->data);
	}

	/**
	* Update Form Tingkat Pendidikans
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_tingkat_pendidikan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('tingkat_pendidikan', 'Tingkat Pendidikan', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'tingkat_pendidikan' => $this->input->post('tingkat_pendidikan'),
			];

			
			$save_form_tingkat_pendidikan = $this->model_form_tingkat_pendidikan->change($id, $save_data);

			if ($save_form_tingkat_pendidikan) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_tingkat_pendidikan', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_tingkat_pendidikan');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_tingkat_pendidikan');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Tingkat Pendidikans
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_tingkat_pendidikan_delete');

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
            set_message(cclang('has_been_deleted', 'Form Tingkat Pendidikan'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Tingkat Pendidikan'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Tingkat Pendidikans
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_tingkat_pendidikan_view');

		$this->data['form_tingkat_pendidikan'] = $this->model_form_tingkat_pendidikan->find($id);

		$this->template->title('Master Tingkat Pendidikan Detail');
		$this->render('backend/standart/administrator/form_builder/form_tingkat_pendidikan/form_tingkat_pendidikan_view', $this->data);
	}

	/**
	* delete Form Tingkat Pendidikans
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_tingkat_pendidikan = $this->model_form_tingkat_pendidikan->find($id);

		
		return $this->model_form_tingkat_pendidikan->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_tingkat_pendidikan_export');

		$this->model_form_tingkat_pendidikan->export('form_tingkat_pendidikan', 'form_tingkat_pendidikan');
	}
}


/* End of file form_tingkat_pendidikan.php */
/* Location: ./application/controllers/administrator/Form Tingkat Pendidikan.php */