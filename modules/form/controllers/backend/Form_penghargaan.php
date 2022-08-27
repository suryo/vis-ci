<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Penghargaan Controller
*| --------------------------------------------------------------------------
*| Form Penghargaan site
*|
*/
class Form_penghargaan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_penghargaan');
	}

	/**
	* show all Form Penghargaans
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_penghargaan_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_penghargaans'] = $this->model_form_penghargaan->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_penghargaan_counts'] = $this->model_form_penghargaan->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_penghargaan/index/',
			'total_rows'   => $this->model_form_penghargaan->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('SK Penghargaan Satya Lencana List');
		$this->render('backend/standart/administrator/form_builder/form_penghargaan/form_penghargaan_list', $this->data);
	}

	/**
	* Update view Form Penghargaans
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_penghargaan_update');

		$this->data['form_penghargaan'] = $this->model_form_penghargaan->find($id);

		$this->template->title('SK Penghargaan Satya Lencana Update');
		$this->render('backend/standart/administrator/form_builder/form_penghargaan/form_penghargaan_update', $this->data);
	}

	/**
	* Update Form Penghargaans
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_penghargaan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('jenis_penghargaan_satya_lencana', 'Jenis Penghargaan Satya Lencana', 'trim|required');
		$this->form_validation->set_rules('no_sk_penghargaan', 'No.SK Penghargaan', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_penghargaan', 'Tanggal SK Penghargaan', 'trim|required');
		$this->form_validation->set_rules('form_penghargaan_berkas_sk_penghargaan_name', 'Berkas SK Penghargaan', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_penghargaan_berkas_sk_penghargaan_uuid = $this->input->post('form_penghargaan_berkas_sk_penghargaan_uuid');
			$form_penghargaan_berkas_sk_penghargaan_name = $this->input->post('form_penghargaan_berkas_sk_penghargaan_name');
		
			$save_data = [
				'jenis_penghargaan_satya_lencana' => $this->input->post('jenis_penghargaan_satya_lencana'),
				'no_sk_penghargaan' => $this->input->post('no_sk_penghargaan'),
				'tanggal_sk_penghargaan' => $this->input->post('tanggal_sk_penghargaan'),
				'deskripsi_sk_penghargaan' => $this->input->post('deskripsi_sk_penghargaan'),
			];

			if (!is_dir(FCPATH . '/uploads/form_penghargaan/')) {
				mkdir(FCPATH . '/uploads/form_penghargaan/');
			}

			if (!empty($form_penghargaan_berkas_sk_penghargaan_uuid)) {
				$form_penghargaan_berkas_sk_penghargaan_name_copy = date('YmdHis') . '-' . $form_penghargaan_berkas_sk_penghargaan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_penghargaan_berkas_sk_penghargaan_uuid . '/' . $form_penghargaan_berkas_sk_penghargaan_name, 
						FCPATH . 'uploads/form_penghargaan/' . $form_penghargaan_berkas_sk_penghargaan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_penghargaan/' . $form_penghargaan_berkas_sk_penghargaan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_penghargaan'] = $form_penghargaan_berkas_sk_penghargaan_name_copy;
			}
		
			
			$save_form_penghargaan = $this->model_form_penghargaan->change($id, $save_data);

			if ($save_form_penghargaan) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_penghargaan', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_penghargaan');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_penghargaan');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Penghargaans
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_penghargaan_delete');

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
            set_message(cclang('has_been_deleted', 'Form Penghargaan'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Penghargaan'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Penghargaans
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_penghargaan_view');

		$this->data['form_penghargaan'] = $this->model_form_penghargaan->find($id);

		$this->template->title('SK Penghargaan Satya Lencana Detail');
		$this->render('backend/standart/administrator/form_builder/form_penghargaan/form_penghargaan_view', $this->data);
	}

	/**
	* delete Form Penghargaans
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_penghargaan = $this->model_form_penghargaan->find($id);

		if (!empty($form_penghargaan->berkas_sk_penghargaan)) {
			$path = FCPATH . '/uploads/form_penghargaan/' . $form_penghargaan->berkas_sk_penghargaan;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_penghargaan->remove($id);
	}
	
	/**
	* Upload Image Form Penghargaan	* 
	* @return JSON
	*/
	public function upload_berkas_sk_penghargaan_file()
	{
		if (!$this->is_allowed('form_penghargaan_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_penghargaan',
		]);
	}

	/**
	* Delete Image Form Penghargaan	* 
	* @return JSON
	*/
	public function delete_berkas_sk_penghargaan_file($uuid)
	{
		if (!$this->is_allowed('form_penghargaan_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_penghargaan', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_penghargaan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penghargaan/'
        ]);
	}

	/**
	* Get Image Form Penghargaan	* 
	* @return JSON
	*/
	public function get_berkas_sk_penghargaan_file($id)
	{
		if (!$this->is_allowed('form_penghargaan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_penghargaan = $this->model_form_penghargaan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_penghargaan', 
            'table_name'        => 'form_penghargaan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penghargaan/',
            'delete_endpoint'   => 'administrator/form_penghargaan/delete_berkas_sk_penghargaan_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_penghargaan_export');

		$this->model_form_penghargaan->export('form_penghargaan', 'form_penghargaan');
	}
}


/* End of file form_penghargaan.php */
/* Location: ./application/controllers/administrator/Form Penghargaan.php */