<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Ujian Dinas Controller
*| --------------------------------------------------------------------------
*| Form Ujian Dinas site
*|
*/
class Form_ujian_dinas extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_ujian_dinas');
	}

	/**
	* Submit Form Ujian Dinass
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('id_pegawai', 'Id Pegawai', 'trim|required');
		$this->form_validation->set_rules('jenis_ujian_dinas', 'Jenis Ujian Dinas', 'trim|required');
		$this->form_validation->set_rules('tanggal_ujian_dinas', 'Tanggal Ujian Dinas', 'trim|required');
		$this->form_validation->set_rules('form_ujian_dinas_berkas_ujian_dinas_name', 'Berkas Ujian Dinas', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_ujian_dinas_berkas_ujian_dinas_uuid = $this->input->post('form_ujian_dinas_berkas_ujian_dinas_uuid');
			$form_ujian_dinas_berkas_ujian_dinas_name = $this->input->post('form_ujian_dinas_berkas_ujian_dinas_name');
		
			$save_data = [
				'id_pegawai' => $this->input->post('id_pegawai'),
				'jenis_ujian_dinas' => $this->input->post('jenis_ujian_dinas'),
				'tanggal_ujian_dinas' => $this->input->post('tanggal_ujian_dinas'),
				'deskripsi_ujian_dinas' => $this->input->post('deskripsi_ujian_dinas'),
				'berkas_ujian_dinas' => $this->input->post('berkas_ujian_dinas'),
			];

			if (!is_dir(FCPATH . '/uploads/form_ujian_dinas/')) {
				mkdir(FCPATH . '/uploads/form_ujian_dinas/');
			}

			if (!empty($form_ujian_dinas_berkas_ujian_dinas_uuid)) {
				$form_ujian_dinas_berkas_ujian_dinas_name_copy = date('YmdHis') . '-' . $form_ujian_dinas_berkas_ujian_dinas_name;

				rename(FCPATH . 'uploads/tmp/' . $form_ujian_dinas_berkas_ujian_dinas_uuid . '/' . $form_ujian_dinas_berkas_ujian_dinas_name, 
						FCPATH . 'uploads/form_ujian_dinas/' . $form_ujian_dinas_berkas_ujian_dinas_name_copy);

				if (!is_file(FCPATH . '/uploads/form_ujian_dinas/' . $form_ujian_dinas_berkas_ujian_dinas_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_ujian_dinas'] = $form_ujian_dinas_berkas_ujian_dinas_name_copy;
			}
		
			
			$save_form_ujian_dinas = $this->model_form_ujian_dinas->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_ujian_dinas;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Ujian Dinas	* 
	* @return JSON
	*/
	public function upload_berkas_ujian_dinas_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_ujian_dinas',
			'allowed_types' => 'pdf',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Ujian Dinas	* 
	* @return JSON
	*/
	public function delete_berkas_ujian_dinas_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_ujian_dinas', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_ujian_dinas',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_ujian_dinas/'
        ]);
	}

	/**
	* Get Image Form Ujian Dinas	* 
	* @return JSON
	*/
	public function get_berkas_ujian_dinas_file($id)
	{
		$form_ujian_dinas = $this->model_form_ujian_dinas->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_ujian_dinas', 
            'table_name'        => 'form_ujian_dinas',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_ujian_dinas/',
            'delete_endpoint'   => 'administrator/form_ujian_dinas/delete_berkas_ujian_dinas_file'
        ]);
	}
	
}


/* End of file form_ujian_dinas.php */
/* Location: ./application/controllers/administrator/Form Ujian Dinas.php */