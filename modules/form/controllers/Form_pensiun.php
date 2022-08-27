<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Pensiun Controller
*| --------------------------------------------------------------------------
*| Form Pensiun site
*|
*/
class Form_pensiun extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_pensiun');
	}

	/**
	* Submit Form Pensiuns
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('tanggal_sk_pensiun', 'Tanggal SK Pensiun', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_pensiun_berkas_sk_pensiun_name', 'Berkas SK Pensiun', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_pensiun_berkas_sk_pensiun_uuid = $this->input->post('form_pensiun_berkas_sk_pensiun_uuid');
			$form_pensiun_berkas_sk_pensiun_name = $this->input->post('form_pensiun_berkas_sk_pensiun_name');
		
			$save_data = [
				'tanggal_sk_pensiun' => $this->input->post('tanggal_sk_pensiun'),
				'tmt' => $this->input->post('tmt'),
				'berkas_sk_pensiun' => $this->input->post('berkas_sk_pensiun'),
			];

			if (!is_dir(FCPATH . '/uploads/form_pensiun/')) {
				mkdir(FCPATH . '/uploads/form_pensiun/');
			}

			if (!empty($form_pensiun_berkas_sk_pensiun_uuid)) {
				$form_pensiun_berkas_sk_pensiun_name_copy = date('YmdHis') . '-' . $form_pensiun_berkas_sk_pensiun_name;

				rename(FCPATH . 'uploads/tmp/' . $form_pensiun_berkas_sk_pensiun_uuid . '/' . $form_pensiun_berkas_sk_pensiun_name, 
						FCPATH . 'uploads/form_pensiun/' . $form_pensiun_berkas_sk_pensiun_name_copy);

				if (!is_file(FCPATH . '/uploads/form_pensiun/' . $form_pensiun_berkas_sk_pensiun_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_pensiun'] = $form_pensiun_berkas_sk_pensiun_name_copy;
			}
		
			
			$save_form_pensiun = $this->model_form_pensiun->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_pensiun;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Pensiun	* 
	* @return JSON
	*/
	public function upload_berkas_sk_pensiun_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_pensiun',
		]);
	}

	/**
	* Delete Image Form Pensiun	* 
	* @return JSON
	*/
	public function delete_berkas_sk_pensiun_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_pensiun', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_pensiun',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pensiun/'
        ]);
	}

	/**
	* Get Image Form Pensiun	* 
	* @return JSON
	*/
	public function get_berkas_sk_pensiun_file($id)
	{
		$form_pensiun = $this->model_form_pensiun->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_pensiun', 
            'table_name'        => 'form_pensiun',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pensiun/',
            'delete_endpoint'   => 'administrator/form_pensiun/delete_berkas_sk_pensiun_file'
        ]);
	}
	
}


/* End of file form_pensiun.php */
/* Location: ./application/controllers/administrator/Form Pensiun.php */