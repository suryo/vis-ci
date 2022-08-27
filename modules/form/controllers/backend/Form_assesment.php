<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Assesment Controller
*| --------------------------------------------------------------------------
*| Form Assesment site
*|
*/
class Form_assesment extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_assesment');
	}

	/**
	* show all Form Assesments
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_assesment_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_assesments'] = $this->model_form_assesment->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_assesment_counts'] = $this->model_form_assesment->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_assesment/index/',
			'total_rows'   => $this->model_form_assesment->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Assesment List');
		$this->render('backend/standart/administrator/form_builder/form_assesment/form_assesment_list', $this->data);
	}

	/**
	* Update view Form Assesments
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_assesment_update');

		$this->data['form_assesment'] = $this->model_form_assesment->find($id);

		$this->template->title('Assesment Update');
		$this->render('backend/standart/administrator/form_builder/form_assesment/form_assesment_update', $this->data);
	}

	/**
	* Update Form Assesments
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_assesment_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('_tanggal_assesment', ' Tanggal Assesment', 'trim|required');
		$this->form_validation->set_rules('level', 'Level', 'trim|required');
		$this->form_validation->set_rules('form_assesment_berkas_assesment_name', 'Berkas Assesment', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_assesment_berkas_assesment_uuid = $this->input->post('form_assesment_berkas_assesment_uuid');
			$form_assesment_berkas_assesment_name = $this->input->post('form_assesment_berkas_assesment_name');
		
			$save_data = [
				'no_assesment' => $this->input->post('no_assesment'),
				'_tanggal_assesment' => $this->input->post('_tanggal_assesment'),
				'level' => $this->input->post('level'),
				'keterangan' => $this->input->post('keterangan'),
			];

			if (!is_dir(FCPATH . '/uploads/form_assesment/')) {
				mkdir(FCPATH . '/uploads/form_assesment/');
			}

			if (!empty($form_assesment_berkas_assesment_uuid)) {
				$form_assesment_berkas_assesment_name_copy = date('YmdHis') . '-' . $form_assesment_berkas_assesment_name;

				rename(FCPATH . 'uploads/tmp/' . $form_assesment_berkas_assesment_uuid . '/' . $form_assesment_berkas_assesment_name, 
						FCPATH . 'uploads/form_assesment/' . $form_assesment_berkas_assesment_name_copy);

				if (!is_file(FCPATH . '/uploads/form_assesment/' . $form_assesment_berkas_assesment_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_assesment'] = $form_assesment_berkas_assesment_name_copy;
			}
		
			
			$save_form_assesment = $this->model_form_assesment->change($id, $save_data);

			if ($save_form_assesment) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_assesment', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_assesment');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_assesment');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Assesments
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_assesment_delete');

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
            set_message(cclang('has_been_deleted', 'Form Assesment'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Assesment'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Assesments
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_assesment_view');

		$this->data['form_assesment'] = $this->model_form_assesment->find($id);

		$this->template->title('Assesment Detail');
		$this->render('backend/standart/administrator/form_builder/form_assesment/form_assesment_view', $this->data);
	}

	/**
	* delete Form Assesments
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_assesment = $this->model_form_assesment->find($id);

		if (!empty($form_assesment->berkas_assesment)) {
			$path = FCPATH . '/uploads/form_assesment/' . $form_assesment->berkas_assesment;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_assesment->remove($id);
	}
	
	/**
	* Upload Image Form Assesment	* 
	* @return JSON
	*/
	public function upload_berkas_assesment_file()
	{
		if (!$this->is_allowed('form_assesment_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_assesment',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Assesment	* 
	* @return JSON
	*/
	public function delete_berkas_assesment_file($uuid)
	{
		if (!$this->is_allowed('form_assesment_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_assesment', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_assesment',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_assesment/'
        ]);
	}

	/**
	* Get Image Form Assesment	* 
	* @return JSON
	*/
	public function get_berkas_assesment_file($id)
	{
		if (!$this->is_allowed('form_assesment_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_assesment = $this->model_form_assesment->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_assesment', 
            'table_name'        => 'form_assesment',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_assesment/',
            'delete_endpoint'   => 'administrator/form_assesment/delete_berkas_assesment_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_assesment_export');

		$this->model_form_assesment->export('form_assesment', 'form_assesment');
	}
}


/* End of file form_assesment.php */
/* Location: ./application/controllers/administrator/Form Assesment.php */