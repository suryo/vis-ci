<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Kp4 Controller
*| --------------------------------------------------------------------------
*| Form Kp4 site
*|
*/
class Form_kp4 extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_kp4');
	}

	/**
	* Submit Form Kp4s
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_surat_kp4', 'No. Surat KP4', 'trim|required');
		$this->form_validation->set_rules('tanggal_surat_kp4', 'Tanggal Surat KP4', 'trim|required');
		$this->form_validation->set_rules('form_kp4_berkas_kp4_name', 'Berkas KP4', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_kp4_berkas_kp4_uuid = $this->input->post('form_kp4_berkas_kp4_uuid');
			$form_kp4_berkas_kp4_name = $this->input->post('form_kp4_berkas_kp4_name');
		
			$save_data = [
				'no_surat_kp4' => $this->input->post('no_surat_kp4'),
				'tanggal_surat_kp4' => $this->input->post('tanggal_surat_kp4'),
				'deskripsi_kp4' => $this->input->post('deskripsi_kp4'),
				'berkas_kp4' => $this->input->post('berkas_kp4'),
			];

			if (!is_dir(FCPATH . '/uploads/form_kp4/')) {
				mkdir(FCPATH . '/uploads/form_kp4/');
			}

			if (!empty($form_kp4_berkas_kp4_uuid)) {
				$form_kp4_berkas_kp4_name_copy = date('YmdHis') . '-' . $form_kp4_berkas_kp4_name;

				rename(FCPATH . 'uploads/tmp/' . $form_kp4_berkas_kp4_uuid . '/' . $form_kp4_berkas_kp4_name, 
						FCPATH . 'uploads/form_kp4/' . $form_kp4_berkas_kp4_name_copy);

				if (!is_file(FCPATH . '/uploads/form_kp4/' . $form_kp4_berkas_kp4_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_kp4'] = $form_kp4_berkas_kp4_name_copy;
			}
		
			
			$save_form_kp4 = $this->model_form_kp4->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_kp4;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Kp4	* 
	* @return JSON
	*/
	public function upload_berkas_kp4_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_kp4',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Kp4	* 
	* @return JSON
	*/
	public function delete_berkas_kp4_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_kp4', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_kp4',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_kp4/'
        ]);
	}

	/**
	* Get Image Form Kp4	* 
	* @return JSON
	*/
	public function get_berkas_kp4_file($id)
	{
		$form_kp4 = $this->model_form_kp4->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_kp4', 
            'table_name'        => 'form_kp4',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_kp4/',
            'delete_endpoint'   => 'administrator/form_kp4/delete_berkas_kp4_file'
        ]);
	}
	
}


/* End of file form_kp4.php */
/* Location: ./application/controllers/administrator/Form Kp4.php */