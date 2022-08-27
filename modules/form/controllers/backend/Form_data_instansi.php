<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Data Instansi Controller
*| --------------------------------------------------------------------------
*| Form Data Instansi site
*|
*/
class Form_data_instansi extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_data_instansi');
	}

	/**
	* show all Form Data Instansis
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_data_instansi_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_data_instansis'] = $this->model_form_data_instansi->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_data_instansi_counts'] = $this->model_form_data_instansi->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_data_instansi/index/',
			'total_rows'   => $this->model_form_data_instansi->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Master Data Instansi List');
		$this->render('backend/standart/administrator/form_builder/form_data_instansi/form_data_instansi_list', $this->data);
	}

	/**
	* Update view Form Data Instansis
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_data_instansi_update');

		$this->data['form_data_instansi'] = $this->model_form_data_instansi->find($id);

		$this->template->title('Master Data Instansi Update');
		$this->render('backend/standart/administrator/form_builder/form_data_instansi/form_data_instansi_update', $this->data);
	}

	/**
	* Update Form Data Instansis
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_data_instansi_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('nama_instansi', 'Nama Instansi', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'nama_instansi' => $this->input->post('nama_instansi'),
			];

			
			$save_form_data_instansi = $this->model_form_data_instansi->change($id, $save_data);

			if ($save_form_data_instansi) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_data_instansi', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_data_instansi');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_data_instansi');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Data Instansis
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_data_instansi_delete');

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
            set_message(cclang('has_been_deleted', 'Form Data Instansi'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Data Instansi'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Data Instansis
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_data_instansi_view');

		$this->data['form_data_instansi'] = $this->model_form_data_instansi->find($id);

		$this->template->title('Master Data Instansi Detail');
		$this->render('backend/standart/administrator/form_builder/form_data_instansi/form_data_instansi_view', $this->data);
	}

	/**
	* delete Form Data Instansis
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_data_instansi = $this->model_form_data_instansi->find($id);

		
		return $this->model_form_data_instansi->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_data_instansi_export');

		$this->model_form_data_instansi->export('form_data_instansi', 'form_data_instansi');
	}
}


/* End of file form_data_instansi.php */
/* Location: ./application/controllers/administrator/Form Data Instansi.php */