<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Ujiandinas Controller
*| --------------------------------------------------------------------------
*| Form Ujiandinas site
*|
*/
class Form_ujiandinas extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_ujiandinas');
	}

	/**
	* Submit Form Ujiandinass
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('jenis_ujian_dinas', 'Jenis Ujian Dinas', 'trim|required');
		$this->form_validation->set_rules('tanggal_ujian_dinas', 'Tanggal Ujian Dinas', 'trim|required');
		$this->form_validation->set_rules('form_ujiandinas_berkas_ujian_dinas_name', 'Berkas Ujian Dinas', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_ujiandinas_berkas_ujian_dinas_uuid = $this->input->post('form_ujiandinas_berkas_ujian_dinas_uuid');
			$form_ujiandinas_berkas_ujian_dinas_name = $this->input->post('form_ujiandinas_berkas_ujian_dinas_name');
		
			$save_data = [
				'jenis_ujian_dinas' => $this->input->post('jenis_ujian_dinas'),
				'tanggal_ujian_dinas' => $this->input->post('tanggal_ujian_dinas'),
				'deskripsi_ujian_dinas' => $this->input->post('deskripsi_ujian_dinas'),
				'berkas_ujian_dinas' => $this->input->post('berkas_ujian_dinas'),
			];

			if (!is_dir(FCPATH . '/uploads/form_ujiandinas/')) {
				mkdir(FCPATH . '/uploads/form_ujiandinas/');
			}

			if (!empty($form_ujiandinas_berkas_ujian_dinas_uuid)) {
				$form_ujiandinas_berkas_ujian_dinas_name_copy = date('YmdHis') . '-' . $form_ujiandinas_berkas_ujian_dinas_name;

				rename(FCPATH . 'uploads/tmp/' . $form_ujiandinas_berkas_ujian_dinas_uuid . '/' . $form_ujiandinas_berkas_ujian_dinas_name, 
						FCPATH . 'uploads/form_ujiandinas/' . $form_ujiandinas_berkas_ujian_dinas_name_copy);

				if (!is_file(FCPATH . '/uploads/form_ujiandinas/' . $form_ujiandinas_berkas_ujian_dinas_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_ujian_dinas'] = $form_ujiandinas_berkas_ujian_dinas_name_copy;
			}
		
			
			$save_form_ujiandinas = $this->model_form_ujiandinas->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_ujiandinas;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Ujiandinas	* 
	* @return JSON
	*/
	public function upload_berkas_ujian_dinas_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_ujiandinas',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Ujiandinas	* 
	* @return JSON
	*/
	public function delete_berkas_ujian_dinas_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_ujian_dinas', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_ujiandinas',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_ujiandinas/'
        ]);
	}

	/**
	* Get Image Form Ujiandinas	* 
	* @return JSON
	*/
	public function get_berkas_ujian_dinas_file($id)
	{
		$form_ujiandinas = $this->model_form_ujiandinas->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_ujian_dinas', 
            'table_name'        => 'form_ujiandinas',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_ujiandinas/',
            'delete_endpoint'   => 'administrator/form_ujiandinas/delete_berkas_ujian_dinas_file'
        ]);
	}
	
}


/* End of file form_ujiandinas.php */
/* Location: ./application/controllers/administrator/Form Ujiandinas.php */