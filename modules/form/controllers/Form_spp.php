<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Spp Controller
*| --------------------------------------------------------------------------
*| Form Spp site
*|
*/
class Form_spp extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_spp');
	}

	/**
	* Submit Form Spps
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_spp', 'No. SPP', 'trim|required');
		$this->form_validation->set_rules('tanggal_spp', 'Tanggal SPP', 'trim|required');
		$this->form_validation->set_rules('form_spp_berkas_spp_name', 'Berkas SPP', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_spp_berkas_spp_uuid = $this->input->post('form_spp_berkas_spp_uuid');
			$form_spp_berkas_spp_name = $this->input->post('form_spp_berkas_spp_name');
		
			$save_data = [
				'no_spp' => $this->input->post('no_spp'),
				'tanggal_spp' => $this->input->post('tanggal_spp'),
				'deskripsi_spp' => $this->input->post('deskripsi_spp'),
				'berkas_spp' => $this->input->post('berkas_spp'),
			];

			if (!is_dir(FCPATH . '/uploads/form_spp/')) {
				mkdir(FCPATH . '/uploads/form_spp/');
			}

			if (!empty($form_spp_berkas_spp_uuid)) {
				$form_spp_berkas_spp_name_copy = date('YmdHis') . '-' . $form_spp_berkas_spp_name;

				rename(FCPATH . 'uploads/tmp/' . $form_spp_berkas_spp_uuid . '/' . $form_spp_berkas_spp_name, 
						FCPATH . 'uploads/form_spp/' . $form_spp_berkas_spp_name_copy);

				if (!is_file(FCPATH . '/uploads/form_spp/' . $form_spp_berkas_spp_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_spp'] = $form_spp_berkas_spp_name_copy;
			}
		
			
			$save_form_spp = $this->model_form_spp->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_spp;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Spp	* 
	* @return JSON
	*/
	public function upload_berkas_spp_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_spp',
		]);
	}

	/**
	* Delete Image Form Spp	* 
	* @return JSON
	*/
	public function delete_berkas_spp_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_spp', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_spp',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_spp/'
        ]);
	}

	/**
	* Get Image Form Spp	* 
	* @return JSON
	*/
	public function get_berkas_spp_file($id)
	{
		$form_spp = $this->model_form_spp->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_spp', 
            'table_name'        => 'form_spp',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_spp/',
            'delete_endpoint'   => 'administrator/form_spp/delete_berkas_spp_file'
        ]);
	}
	
}


/* End of file form_spp.php */
/* Location: ./application/controllers/administrator/Form Spp.php */