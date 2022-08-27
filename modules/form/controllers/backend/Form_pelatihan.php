<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Pelatihan Controller
*| --------------------------------------------------------------------------
*| Form Pelatihan site
*|
*/
class Form_pelatihan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_pelatihan');
	}

	/**
	* show all Form Pelatihans
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_pelatihan_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_pelatihans'] = $this->model_form_pelatihan->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_pelatihan_counts'] = $this->model_form_pelatihan->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_pelatihan/index/',
			'total_rows'   => $this->model_form_pelatihan->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Pelatihan List');
		$this->render('backend/standart/administrator/form_builder/form_pelatihan/form_pelatihan_list', $this->data);
	}

	/**
	* Update view Form Pelatihans
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_pelatihan_update');

		$this->data['form_pelatihan'] = $this->model_form_pelatihan->find($id);

		$this->template->title('Pelatihan Update');
		$this->render('backend/standart/administrator/form_builder/form_pelatihan/form_pelatihan_update', $this->data);
	}

	/**
	* Update Form Pelatihans
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_pelatihan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('jenis_pelatihan', 'Jenis Pelatihan', 'trim|required');
		$this->form_validation->set_rules('nama_pelatihan', 'Nama Pelatihan', 'trim|required');
		$this->form_validation->set_rules('instansi_penyelenggara', 'Instansi Penyelenggara', 'trim|required');
		$this->form_validation->set_rules('form_pelatihan_berkas_pelatihan_name', 'Berkas Pelatihan', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_pelatihan_berkas_pelatihan_uuid = $this->input->post('form_pelatihan_berkas_pelatihan_uuid');
			$form_pelatihan_berkas_pelatihan_name = $this->input->post('form_pelatihan_berkas_pelatihan_name');
		
			$save_data = [
				'jenis_pelatihan' => $this->input->post('jenis_pelatihan'),
				'nama_pelatihan' => $this->input->post('nama_pelatihan'),
				'no_sertifikat_pelatihan' => $this->input->post('no_sertifikat_pelatihan'),
				'tanggal_sertifikat_pelatihan' => $this->input->post('tanggal_sertifikat_pelatihan'),
				'tanggal_mulai_pelatihan' => $this->input->post('tanggal_mulai_pelatihan'),
				'tanggal_selesai_pelatihan' => $this->input->post('tanggal_selesai_pelatihan'),
				'durasi_pelatihan' => $this->input->post('durasi_pelatihan'),
				'instansi_penyelenggara' => $this->input->post('instansi_penyelenggara'),
				'deskripsi_pelatihan' => $this->input->post('deskripsi_pelatihan'),
			];

			if (!is_dir(FCPATH . '/uploads/form_pelatihan/')) {
				mkdir(FCPATH . '/uploads/form_pelatihan/');
			}

			if (!empty($form_pelatihan_berkas_pelatihan_uuid)) {
				$form_pelatihan_berkas_pelatihan_name_copy = date('YmdHis') . '-' . $form_pelatihan_berkas_pelatihan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_pelatihan_berkas_pelatihan_uuid . '/' . $form_pelatihan_berkas_pelatihan_name, 
						FCPATH . 'uploads/form_pelatihan/' . $form_pelatihan_berkas_pelatihan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_pelatihan/' . $form_pelatihan_berkas_pelatihan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_pelatihan'] = $form_pelatihan_berkas_pelatihan_name_copy;
			}
		
			
			$save_form_pelatihan = $this->model_form_pelatihan->change($id, $save_data);

			if ($save_form_pelatihan) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_pelatihan', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_pelatihan');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_pelatihan');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Pelatihans
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_pelatihan_delete');

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
            set_message(cclang('has_been_deleted', 'Form Pelatihan'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Pelatihan'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Pelatihans
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_pelatihan_view');

		$this->data['form_pelatihan'] = $this->model_form_pelatihan->find($id);

		$this->template->title('Pelatihan Detail');
		$this->render('backend/standart/administrator/form_builder/form_pelatihan/form_pelatihan_view', $this->data);
	}

	/**
	* delete Form Pelatihans
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_pelatihan = $this->model_form_pelatihan->find($id);

		if (!empty($form_pelatihan->berkas_pelatihan)) {
			$path = FCPATH . '/uploads/form_pelatihan/' . $form_pelatihan->berkas_pelatihan;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_pelatihan->remove($id);
	}
	
	/**
	* Upload Image Form Pelatihan	* 
	* @return JSON
	*/
	public function upload_berkas_pelatihan_file()
	{
		if (!$this->is_allowed('form_pelatihan_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_pelatihan',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Pelatihan	* 
	* @return JSON
	*/
	public function delete_berkas_pelatihan_file($uuid)
	{
		if (!$this->is_allowed('form_pelatihan_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_pelatihan', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_pelatihan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pelatihan/'
        ]);
	}

	/**
	* Get Image Form Pelatihan	* 
	* @return JSON
	*/
	public function get_berkas_pelatihan_file($id)
	{
		if (!$this->is_allowed('form_pelatihan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_pelatihan = $this->model_form_pelatihan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_pelatihan', 
            'table_name'        => 'form_pelatihan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pelatihan/',
            'delete_endpoint'   => 'administrator/form_pelatihan/delete_berkas_pelatihan_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_pelatihan_export');

		$this->model_form_pelatihan->export('form_pelatihan', 'form_pelatihan');
	}
}


/* End of file form_pelatihan.php */
/* Location: ./application/controllers/administrator/Form Pelatihan.php */