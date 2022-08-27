<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Nama Perguruan Tinggi Controller
*| --------------------------------------------------------------------------
*| Form Nama Perguruan Tinggi site
*|
*/
class Form_nama_perguruan_tinggi extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_nama_perguruan_tinggi');
	}

	/**
	* show all Form Nama Perguruan Tinggis
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_nama_perguruan_tinggi_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_nama_perguruan_tinggis'] = $this->model_form_nama_perguruan_tinggi->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_nama_perguruan_tinggi_counts'] = $this->model_form_nama_perguruan_tinggi->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_nama_perguruan_tinggi/index/',
			'total_rows'   => $this->model_form_nama_perguruan_tinggi->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Master Nama Perguruan Tinggi List');
		$this->render('backend/standart/administrator/form_builder/form_nama_perguruan_tinggi/form_nama_perguruan_tinggi_list', $this->data);
	}

	/**
	* Update view Form Nama Perguruan Tinggis
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_nama_perguruan_tinggi_update');

		$this->data['form_nama_perguruan_tinggi'] = $this->model_form_nama_perguruan_tinggi->find($id);

		$this->template->title('Master Nama Perguruan Tinggi Update');
		$this->render('backend/standart/administrator/form_builder/form_nama_perguruan_tinggi/form_nama_perguruan_tinggi_update', $this->data);
	}

	/**
	* Update Form Nama Perguruan Tinggis
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_nama_perguruan_tinggi_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('nama_perguruan_tinggi', 'Nama Perguruan Tinggi', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'nama_perguruan_tinggi' => $this->input->post('nama_perguruan_tinggi'),
			];

			
			$save_form_nama_perguruan_tinggi = $this->model_form_nama_perguruan_tinggi->change($id, $save_data);

			if ($save_form_nama_perguruan_tinggi) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_nama_perguruan_tinggi', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_nama_perguruan_tinggi');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_nama_perguruan_tinggi');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Nama Perguruan Tinggis
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_nama_perguruan_tinggi_delete');

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
            set_message(cclang('has_been_deleted', 'Form Nama Perguruan Tinggi'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Nama Perguruan Tinggi'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Nama Perguruan Tinggis
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_nama_perguruan_tinggi_view');

		$this->data['form_nama_perguruan_tinggi'] = $this->model_form_nama_perguruan_tinggi->find($id);

		$this->template->title('Master Nama Perguruan Tinggi Detail');
		$this->render('backend/standart/administrator/form_builder/form_nama_perguruan_tinggi/form_nama_perguruan_tinggi_view', $this->data);
	}

	/**
	* delete Form Nama Perguruan Tinggis
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_nama_perguruan_tinggi = $this->model_form_nama_perguruan_tinggi->find($id);

		
		return $this->model_form_nama_perguruan_tinggi->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_nama_perguruan_tinggi_export');

		$this->model_form_nama_perguruan_tinggi->export('form_nama_perguruan_tinggi', 'form_nama_perguruan_tinggi');
	}
}


/* End of file form_nama_perguruan_tinggi.php */
/* Location: ./application/controllers/administrator/Form Nama Perguruan Tinggi.php */