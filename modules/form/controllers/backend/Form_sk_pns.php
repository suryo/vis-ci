<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Sk Pns Controller
*| --------------------------------------------------------------------------
*| Form Sk Pns site
*|
*/
class Form_sk_pns extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_sk_pns');
	}

	/**
	* show all Form Sk Pnss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_sk_pns_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_sk_pnss'] = $this->model_form_sk_pns->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_sk_pns_counts'] = $this->model_form_sk_pns->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_sk_pns/index/',
			'total_rows'   => $this->model_form_sk_pns->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('PNS List');
		$this->render('backend/standart/administrator/form_builder/form_sk_pns/form_sk_pns_list', $this->data);
	}

	/**
	* Update view Form Sk Pnss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_sk_pns_update');

		$this->data['form_sk_pns'] = $this->model_form_sk_pns->find($id);

		$this->template->title('PNS Update');
		$this->render('backend/standart/administrator/form_builder/form_sk_pns/form_sk_pns_update', $this->data);
	}

	/**
	* Update Form Sk Pnss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_sk_pns_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('id_pegawai', 'Id Pegawai', 'trim|required');
		$this->form_validation->set_rules('no_sk_pns', 'No. SK PNS', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_pns', 'Tanggal SK PNS', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('instansi', 'Instansi', 'trim|required');
		$this->form_validation->set_rules('deskripsi_sk_pns', 'Deskripsi SK PNS', 'trim|required');
		$this->form_validation->set_rules('form_sk_pns_berkas_sk_pns_name', 'Berkas SK PNS', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_sk_pns_berkas_sk_pns_uuid = $this->input->post('form_sk_pns_berkas_sk_pns_uuid');
			$form_sk_pns_berkas_sk_pns_name = $this->input->post('form_sk_pns_berkas_sk_pns_name');
		
			$save_data = [
				'id_pegawai' => $this->input->post('id_pegawai'),
				'no_sk_pns' => $this->input->post('no_sk_pns'),
				'tanggal_sk_pns' => $this->input->post('tanggal_sk_pns'),
				'tmt' => $this->input->post('tmt'),
				'instansi' => $this->input->post('instansi'),
				'deskripsi_sk_pns' => $this->input->post('deskripsi_sk_pns'),
			];

			if (!is_dir(FCPATH . '/uploads/form_sk_pns/')) {
				mkdir(FCPATH . '/uploads/form_sk_pns/');
			}

			if (!empty($form_sk_pns_berkas_sk_pns_uuid)) {
				$form_sk_pns_berkas_sk_pns_name_copy = date('YmdHis') . '-' . $form_sk_pns_berkas_sk_pns_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_pns_berkas_sk_pns_uuid . '/' . $form_sk_pns_berkas_sk_pns_name, 
						FCPATH . 'uploads/form_sk_pns/' . $form_sk_pns_berkas_sk_pns_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_pns/' . $form_sk_pns_berkas_sk_pns_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_pns'] = $form_sk_pns_berkas_sk_pns_name_copy;
			}
		
			
			$save_form_sk_pns = $this->model_form_sk_pns->change($id, $save_data);

			if ($save_form_sk_pns) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_sk_pns', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_sk_pns');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_sk_pns');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Sk Pnss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_sk_pns_delete');

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
            set_message(cclang('has_been_deleted', 'Form Sk Pns'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Sk Pns'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Sk Pnss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_sk_pns_view');

		$this->data['form_sk_pns'] = $this->model_form_sk_pns->find($id);

		$this->template->title('PNS Detail');
		$this->render('backend/standart/administrator/form_builder/form_sk_pns/form_sk_pns_view', $this->data);
	}

	/**
	* delete Form Sk Pnss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_sk_pns = $this->model_form_sk_pns->find($id);

		if (!empty($form_sk_pns->berkas_sk_pns)) {
			$path = FCPATH . '/uploads/form_sk_pns/' . $form_sk_pns->berkas_sk_pns;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_sk_pns->remove($id);
	}
	
	/**
	* Upload Image Form Sk Pns	* 
	* @return JSON
	*/
	public function upload_berkas_sk_pns_file()
	{
		if (!$this->is_allowed('form_sk_pns_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_pns',
		]);
	}

	/**
	* Delete Image Form Sk Pns	* 
	* @return JSON
	*/
	public function delete_berkas_sk_pns_file($uuid)
	{
		if (!$this->is_allowed('form_sk_pns_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_pns', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_pns',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_pns/'
        ]);
	}

	/**
	* Get Image Form Sk Pns	* 
	* @return JSON
	*/
	public function get_berkas_sk_pns_file($id)
	{
		if (!$this->is_allowed('form_sk_pns_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_sk_pns = $this->model_form_sk_pns->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_pns', 
            'table_name'        => 'form_sk_pns',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_pns/',
            'delete_endpoint'   => 'administrator/form_sk_pns/delete_berkas_sk_pns_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_sk_pns_export');

		$this->model_form_sk_pns->export('form_sk_pns', 'form_sk_pns');
	}
}


/* End of file form_sk_pns.php */
/* Location: ./application/controllers/administrator/Form Sk Pns.php */