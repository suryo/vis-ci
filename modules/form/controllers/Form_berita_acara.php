<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Berita Acara Controller
*| --------------------------------------------------------------------------
*| Form Berita Acara site
*|
*/
class Form_berita_acara extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_berita_acara');
	}

	/**
	* Submit Form Berita Acaras
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_berita_acara', 'No. Berita Acara', 'trim|required');
		$this->form_validation->set_rules('tanggal_berita_acara', 'Tanggal Berita Acara', 'trim|required');
		$this->form_validation->set_rules('form_berita_acara_berkas_berita_acara_name', 'Berkas Berita Acara', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_berita_acara_berkas_berita_acara_uuid = $this->input->post('form_berita_acara_berkas_berita_acara_uuid');
			$form_berita_acara_berkas_berita_acara_name = $this->input->post('form_berita_acara_berkas_berita_acara_name');
		
			$save_data = [
				'no_berita_acara' => $this->input->post('no_berita_acara'),
				'tanggal_berita_acara' => $this->input->post('tanggal_berita_acara'),
				'deskripsi_berita_acara' => $this->input->post('deskripsi_berita_acara'),
				'berkas_berita_acara' => $this->input->post('berkas_berita_acara'),
			];

			if (!is_dir(FCPATH . '/uploads/form_berita_acara/')) {
				mkdir(FCPATH . '/uploads/form_berita_acara/');
			}

			if (!empty($form_berita_acara_berkas_berita_acara_uuid)) {
				$form_berita_acara_berkas_berita_acara_name_copy = date('YmdHis') . '-' . $form_berita_acara_berkas_berita_acara_name;

				rename(FCPATH . 'uploads/tmp/' . $form_berita_acara_berkas_berita_acara_uuid . '/' . $form_berita_acara_berkas_berita_acara_name, 
						FCPATH . 'uploads/form_berita_acara/' . $form_berita_acara_berkas_berita_acara_name_copy);

				if (!is_file(FCPATH . '/uploads/form_berita_acara/' . $form_berita_acara_berkas_berita_acara_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_berita_acara'] = $form_berita_acara_berkas_berita_acara_name_copy;
			}
		
			
			$save_form_berita_acara = $this->model_form_berita_acara->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_berita_acara;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Berita Acara	* 
	* @return JSON
	*/
	public function upload_berkas_berita_acara_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_berita_acara',
		]);
	}

	/**
	* Delete Image Form Berita Acara	* 
	* @return JSON
	*/
	public function delete_berkas_berita_acara_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_berita_acara', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_berita_acara',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_berita_acara/'
        ]);
	}

	/**
	* Get Image Form Berita Acara	* 
	* @return JSON
	*/
	public function get_berkas_berita_acara_file($id)
	{
		$form_berita_acara = $this->model_form_berita_acara->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_berita_acara', 
            'table_name'        => 'form_berita_acara',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_berita_acara/',
            'delete_endpoint'   => 'administrator/form_berita_acara/delete_berkas_berita_acara_file'
        ]);
	}
	
}


/* End of file form_berita_acara.php */
/* Location: ./application/controllers/administrator/Form Berita Acara.php */