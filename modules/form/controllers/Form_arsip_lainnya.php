<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Arsip Lainnya Controller
*| --------------------------------------------------------------------------
*| Form Arsip Lainnya site
*|
*/
class Form_arsip_lainnya extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_arsip_lainnya');
	}

	/**
	* Submit Form Arsip Lainnyas
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('nama_berkas', 'Nama Berkas', 'trim|required');
		$this->form_validation->set_rules('form_arsip_lainnya_berkas_arsip_lainnya_name', 'Berkas Arsip Lainnya', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_arsip_lainnya_berkas_arsip_lainnya_uuid = $this->input->post('form_arsip_lainnya_berkas_arsip_lainnya_uuid');
			$form_arsip_lainnya_berkas_arsip_lainnya_name = $this->input->post('form_arsip_lainnya_berkas_arsip_lainnya_name');
		
			$save_data = [
				'nama_berkas' => $this->input->post('nama_berkas'),
				'deskripsi_arsip' => $this->input->post('deskripsi_arsip'),
				'berkas_arsip_lainnya' => $this->input->post('berkas_arsip_lainnya'),
			];

			if (!is_dir(FCPATH . '/uploads/form_arsip_lainnya/')) {
				mkdir(FCPATH . '/uploads/form_arsip_lainnya/');
			}

			if (!empty($form_arsip_lainnya_berkas_arsip_lainnya_uuid)) {
				$form_arsip_lainnya_berkas_arsip_lainnya_name_copy = date('YmdHis') . '-' . $form_arsip_lainnya_berkas_arsip_lainnya_name;

				rename(FCPATH . 'uploads/tmp/' . $form_arsip_lainnya_berkas_arsip_lainnya_uuid . '/' . $form_arsip_lainnya_berkas_arsip_lainnya_name, 
						FCPATH . 'uploads/form_arsip_lainnya/' . $form_arsip_lainnya_berkas_arsip_lainnya_name_copy);

				if (!is_file(FCPATH . '/uploads/form_arsip_lainnya/' . $form_arsip_lainnya_berkas_arsip_lainnya_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_arsip_lainnya'] = $form_arsip_lainnya_berkas_arsip_lainnya_name_copy;
			}
		
			
			$save_form_arsip_lainnya = $this->model_form_arsip_lainnya->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_arsip_lainnya;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Arsip Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_arsip_lainnya_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_arsip_lainnya',
		]);
	}

	/**
	* Delete Image Form Arsip Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_arsip_lainnya_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_arsip_lainnya', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_arsip_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_arsip_lainnya/'
        ]);
	}

	/**
	* Get Image Form Arsip Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_arsip_lainnya_file($id)
	{
		$form_arsip_lainnya = $this->model_form_arsip_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_arsip_lainnya', 
            'table_name'        => 'form_arsip_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_arsip_lainnya/',
            'delete_endpoint'   => 'administrator/form_arsip_lainnya/delete_berkas_arsip_lainnya_file'
        ]);
	}
	
}


/* End of file form_arsip_lainnya.php */
/* Location: ./application/controllers/administrator/Form Arsip Lainnya.php */