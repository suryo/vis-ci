<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Keterangan Asesment Controller
*| --------------------------------------------------------------------------
*| Form Keterangan Asesment site
*|
*/
class Form_keterangan_asesment extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_keterangan_asesment');
	}

	/**
	* show all Form Keterangan Asesments
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_keterangan_asesment_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_keterangan_asesments'] = $this->model_form_keterangan_asesment->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_keterangan_asesment_counts'] = $this->model_form_keterangan_asesment->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_keterangan_asesment/index/',
			'total_rows'   => $this->model_form_keterangan_asesment->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Keterangan Asesment List');
		$this->render('backend/standart/administrator/form_builder/form_keterangan_asesment/form_keterangan_asesment_list', $this->data);
	}

	/**
	* Update view Form Keterangan Asesments
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_keterangan_asesment_update');

		$this->data['form_keterangan_asesment'] = $this->model_form_keterangan_asesment->find($id);

		$this->template->title('Keterangan Asesment Update');
		$this->render('backend/standart/administrator/form_builder/form_keterangan_asesment/form_keterangan_asesment_update', $this->data);
	}

	/**
	* Update Form Keterangan Asesments
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_keterangan_asesment_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('keterangan_assement', 'Keterangan Assement', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'keterangan_assement' => $this->input->post('keterangan_assement'),
			];

			
			$save_form_keterangan_asesment = $this->model_form_keterangan_asesment->change($id, $save_data);

			if ($save_form_keterangan_asesment) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_keterangan_asesment', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_keterangan_asesment');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_keterangan_asesment');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Keterangan Asesments
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_keterangan_asesment_delete');

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
            set_message(cclang('has_been_deleted', 'Form Keterangan Asesment'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Keterangan Asesment'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Keterangan Asesments
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_keterangan_asesment_view');

		$this->data['form_keterangan_asesment'] = $this->model_form_keterangan_asesment->find($id);

		$this->template->title('Keterangan Asesment Detail');
		$this->render('backend/standart/administrator/form_builder/form_keterangan_asesment/form_keterangan_asesment_view', $this->data);
	}

	/**
	* delete Form Keterangan Asesments
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_keterangan_asesment = $this->model_form_keterangan_asesment->find($id);

		
		return $this->model_form_keterangan_asesment->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_keterangan_asesment_export');

		$this->model_form_keterangan_asesment->export('form_keterangan_asesment', 'form_keterangan_asesment');
	}
}


/* End of file form_keterangan_asesment.php */
/* Location: ./application/controllers/administrator/Form Keterangan Asesment.php */