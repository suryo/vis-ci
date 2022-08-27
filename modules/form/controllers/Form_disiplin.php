<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Disiplin Controller
*| --------------------------------------------------------------------------
*| Form Disiplin site
*|
*/
class Form_disiplin extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_disiplin');
	}

	/**
	* Submit Form Disiplins
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('id_pegawai', 'Id Pegawai', 'trim|required');
		$this->form_validation->set_rules('no_surat_disiplin', 'No. Surat Disiplin', 'trim|required');
		$this->form_validation->set_rules('_tanggal_surat_disiplin', 'Tanggal Surat Disiplin', 'trim|required');
		$this->form_validation->set_rules('form_disiplin_berkas_surat_disiplin_name', 'Berkas Surat Disiplin', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_disiplin_berkas_surat_disiplin_uuid = $this->input->post('form_disiplin_berkas_surat_disiplin_uuid');
			$form_disiplin_berkas_surat_disiplin_name = $this->input->post('form_disiplin_berkas_surat_disiplin_name');
		
			$save_data = [
				'id_pegawai' => $this->input->post('id_pegawai'),
				'no_surat_disiplin' => $this->input->post('no_surat_disiplin'),
				'_tanggal_surat_disiplin' => $this->input->post('_tanggal_surat_disiplin'),
				'deskripsi_surat_disiplin' => $this->input->post('deskripsi_surat_disiplin'),
				'berkas_surat_disiplin' => $this->input->post('berkas_surat_disiplin'),
			];

			if (!is_dir(FCPATH . '/uploads/form_disiplin/')) {
				mkdir(FCPATH . '/uploads/form_disiplin/');
			}

			if (!empty($form_disiplin_berkas_surat_disiplin_uuid)) {
				$form_disiplin_berkas_surat_disiplin_name_copy = date('YmdHis') . '-' . $form_disiplin_berkas_surat_disiplin_name;

				rename(FCPATH . 'uploads/tmp/' . $form_disiplin_berkas_surat_disiplin_uuid . '/' . $form_disiplin_berkas_surat_disiplin_name, 
						FCPATH . 'uploads/form_disiplin/' . $form_disiplin_berkas_surat_disiplin_name_copy);

				if (!is_file(FCPATH . '/uploads/form_disiplin/' . $form_disiplin_berkas_surat_disiplin_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_surat_disiplin'] = $form_disiplin_berkas_surat_disiplin_name_copy;
			}
		
			
			$save_form_disiplin = $this->model_form_disiplin->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_disiplin;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Disiplin	* 
	* @return JSON
	*/
	public function upload_berkas_surat_disiplin_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_disiplin',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Disiplin	* 
	* @return JSON
	*/
	public function delete_berkas_surat_disiplin_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_surat_disiplin', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_disiplin',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_disiplin/'
        ]);
	}

	/**
	* Get Image Form Disiplin	* 
	* @return JSON
	*/
	public function get_berkas_surat_disiplin_file($id)
	{
		$form_disiplin = $this->model_form_disiplin->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_surat_disiplin', 
            'table_name'        => 'form_disiplin',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_disiplin/',
            'delete_endpoint'   => 'administrator/form_disiplin/delete_berkas_surat_disiplin_file'
        ]);
	}
	
}


/* End of file form_disiplin.php */
/* Location: ./application/controllers/administrator/Form Disiplin.php */