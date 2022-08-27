<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Penghargaan Lainya Controller
*| --------------------------------------------------------------------------
*| Form Penghargaan Lainya site
*|
*/
class Form_penghargaan_lainya extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_penghargaan_lainya');
	}

	/**
	* Submit Form Penghargaan Lainyas
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('tanggal_penghargaan_lainnya', 'Tanggal Penghargaan Lainnya', 'trim|required');
		$this->form_validation->set_rules('deskripsi_sk_penghargaan_lainnya', 'Deskripsi SK Penghargaan Lainnya', 'trim|required');
		$this->form_validation->set_rules('form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name', 'Berkas SK Penghargaan Lainnya', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_uuid = $this->input->post('form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_uuid');
			$form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name = $this->input->post('form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name');
		
			$save_data = [
				'no_sk_penghargaan_lainnya' => $this->input->post('no_sk_penghargaan_lainnya'),
				'tanggal_penghargaan_lainnya' => $this->input->post('tanggal_penghargaan_lainnya'),
				'deskripsi_sk_penghargaan_lainnya' => $this->input->post('deskripsi_sk_penghargaan_lainnya'),
				'berkas_sk_penghargaan_lainnya' => $this->input->post('berkas_sk_penghargaan_lainnya'),
			];

			if (!is_dir(FCPATH . '/uploads/form_penghargaan_lainya/')) {
				mkdir(FCPATH . '/uploads/form_penghargaan_lainya/');
			}

			if (!empty($form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_uuid)) {
				$form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name_copy = date('YmdHis') . '-' . $form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name;

				rename(FCPATH . 'uploads/tmp/' . $form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_uuid . '/' . $form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name, 
						FCPATH . 'uploads/form_penghargaan_lainya/' . $form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name_copy);

				if (!is_file(FCPATH . '/uploads/form_penghargaan_lainya/' . $form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_penghargaan_lainnya'] = $form_penghargaan_lainya_berkas_sk_penghargaan_lainnya_name_copy;
			}
		
			
			$save_form_penghargaan_lainya = $this->model_form_penghargaan_lainya->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_penghargaan_lainya;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Penghargaan Lainya	* 
	* @return JSON
	*/
	public function upload_berkas_sk_penghargaan_lainnya_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_penghargaan_lainya',
		]);
	}

	/**
	* Delete Image Form Penghargaan Lainya	* 
	* @return JSON
	*/
	public function delete_berkas_sk_penghargaan_lainnya_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_penghargaan_lainnya', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_penghargaan_lainya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penghargaan_lainya/'
        ]);
	}

	/**
	* Get Image Form Penghargaan Lainya	* 
	* @return JSON
	*/
	public function get_berkas_sk_penghargaan_lainnya_file($id)
	{
		$form_penghargaan_lainya = $this->model_form_penghargaan_lainya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_penghargaan_lainnya', 
            'table_name'        => 'form_penghargaan_lainya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penghargaan_lainya/',
            'delete_endpoint'   => 'administrator/form_penghargaan_lainya/delete_berkas_sk_penghargaan_lainnya_file'
        ]);
	}
	
}


/* End of file form_penghargaan_lainya.php */
/* Location: ./application/controllers/administrator/Form Penghargaan Lainya.php */