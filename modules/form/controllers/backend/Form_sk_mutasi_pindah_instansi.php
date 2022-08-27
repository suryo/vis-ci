<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Sk Mutasi Pindah Instansi Controller
*| --------------------------------------------------------------------------
*| Form Sk Mutasi Pindah Instansi site
*|
*/
class Form_sk_mutasi_pindah_instansi extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_sk_mutasi_pindah_instansi');
	}

	/**
	* show all Form Sk Mutasi Pindah Instansis
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_sk_mutasi_pindah_instansi_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_sk_mutasi_pindah_instansis'] = $this->model_form_sk_mutasi_pindah_instansi->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_sk_mutasi_pindah_instansi_counts'] = $this->model_form_sk_mutasi_pindah_instansi->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_sk_mutasi_pindah_instansi/index/',
			'total_rows'   => $this->model_form_sk_mutasi_pindah_instansi->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Mutasi Pindah Instansi List');
		$this->render('backend/standart/administrator/form_builder/form_sk_mutasi_pindah_instansi/form_sk_mutasi_pindah_instansi_list', $this->data);
	}

	/**
	* Update view Form Sk Mutasi Pindah Instansis
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_sk_mutasi_pindah_instansi_update');

		$this->data['form_sk_mutasi_pindah_instansi'] = $this->model_form_sk_mutasi_pindah_instansi->find($id);

		$this->template->title('Mutasi Pindah Instansi Update');
		$this->render('backend/standart/administrator/form_builder/form_sk_mutasi_pindah_instansi/form_sk_mutasi_pindah_instansi_update', $this->data);
	}

	/**
	* Update Form Sk Mutasi Pindah Instansis
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_sk_mutasi_pindah_instansi_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('no_sk_mutasi_pindah_instansi', 'No. SK Mutasi Pindah Instansi', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_mutasi_pindah_instansi', 'Tanggal SK Mutasi Pindah Instansi', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('instansi_lama', 'Instansi Lama', 'trim|required');
		$this->form_validation->set_rules('instansi_baru', 'Instansi Baru', 'trim|required');
		$this->form_validation->set_rules('form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name', 'Berkas SK Mutasi Pindah Instansi', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_uuid = $this->input->post('form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_uuid');
			$form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name = $this->input->post('form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name');
		
			$save_data = [
				'no_sk_mutasi_pindah_instansi' => $this->input->post('no_sk_mutasi_pindah_instansi'),
				'tanggal_sk_mutasi_pindah_instansi' => $this->input->post('tanggal_sk_mutasi_pindah_instansi'),
				'tmt' => $this->input->post('tmt'),
				'instansi_lama' => $this->input->post('instansi_lama'),
				'instansi_baru' => $this->input->post('instansi_baru'),
				'deskripsi_sk_mutasi_pindah_instansi' => $this->input->post('deskripsi_sk_mutasi_pindah_instansi'),
			];

			if (!is_dir(FCPATH . '/uploads/form_sk_mutasi_pindah_instansi/')) {
				mkdir(FCPATH . '/uploads/form_sk_mutasi_pindah_instansi/');
			}

			if (!empty($form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_uuid)) {
				$form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name_copy = date('YmdHis') . '-' . $form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_uuid . '/' . $form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name, 
						FCPATH . 'uploads/form_sk_mutasi_pindah_instansi/' . $form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_mutasi_pindah_instansi/' . $form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_mutasi_pindah_instansi'] = $form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name_copy;
			}
		
			
			$save_form_sk_mutasi_pindah_instansi = $this->model_form_sk_mutasi_pindah_instansi->change($id, $save_data);

			if ($save_form_sk_mutasi_pindah_instansi) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_sk_mutasi_pindah_instansi', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_sk_mutasi_pindah_instansi');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_sk_mutasi_pindah_instansi');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Sk Mutasi Pindah Instansis
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_sk_mutasi_pindah_instansi_delete');

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
            set_message(cclang('has_been_deleted', 'Form Sk Mutasi Pindah Instansi'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Sk Mutasi Pindah Instansi'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Sk Mutasi Pindah Instansis
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_sk_mutasi_pindah_instansi_view');

		$this->data['form_sk_mutasi_pindah_instansi'] = $this->model_form_sk_mutasi_pindah_instansi->find($id);

		$this->template->title('Mutasi Pindah Instansi Detail');
		$this->render('backend/standart/administrator/form_builder/form_sk_mutasi_pindah_instansi/form_sk_mutasi_pindah_instansi_view', $this->data);
	}

	/**
	* delete Form Sk Mutasi Pindah Instansis
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_sk_mutasi_pindah_instansi = $this->model_form_sk_mutasi_pindah_instansi->find($id);

		if (!empty($form_sk_mutasi_pindah_instansi->berkas_sk_mutasi_pindah_instansi)) {
			$path = FCPATH . '/uploads/form_sk_mutasi_pindah_instansi/' . $form_sk_mutasi_pindah_instansi->berkas_sk_mutasi_pindah_instansi;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_sk_mutasi_pindah_instansi->remove($id);
	}
	
	/**
	* Upload Image Form Sk Mutasi Pindah Instansi	* 
	* @return JSON
	*/
	public function upload_berkas_sk_mutasi_pindah_instansi_file()
	{
		if (!$this->is_allowed('form_sk_mutasi_pindah_instansi_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_mutasi_pindah_instansi',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Sk Mutasi Pindah Instansi	* 
	* @return JSON
	*/
	public function delete_berkas_sk_mutasi_pindah_instansi_file($uuid)
	{
		if (!$this->is_allowed('form_sk_mutasi_pindah_instansi_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_mutasi_pindah_instansi', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_mutasi_pindah_instansi',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_mutasi_pindah_instansi/'
        ]);
	}

	/**
	* Get Image Form Sk Mutasi Pindah Instansi	* 
	* @return JSON
	*/
	public function get_berkas_sk_mutasi_pindah_instansi_file($id)
	{
		if (!$this->is_allowed('form_sk_mutasi_pindah_instansi_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_sk_mutasi_pindah_instansi = $this->model_form_sk_mutasi_pindah_instansi->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_mutasi_pindah_instansi', 
            'table_name'        => 'form_sk_mutasi_pindah_instansi',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_mutasi_pindah_instansi/',
            'delete_endpoint'   => 'administrator/form_sk_mutasi_pindah_instansi/delete_berkas_sk_mutasi_pindah_instansi_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_sk_mutasi_pindah_instansi_export');

		$this->model_form_sk_mutasi_pindah_instansi->export('form_sk_mutasi_pindah_instansi', 'form_sk_mutasi_pindah_instansi');
	}
}


/* End of file form_sk_mutasi_pindah_instansi.php */
/* Location: ./application/controllers/administrator/Form Sk Mutasi Pindah Instansi.php */