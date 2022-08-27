<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Penghargaan Controller
*| --------------------------------------------------------------------------
*| Form Penghargaan site
*|
*/
class Form_penghargaan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_penghargaan');
	}

	/**
	* Submit Form Penghargaans
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('jenis_penghargaan_satya_lencana', 'Jenis Penghargaan Satya Lencana', 'trim|required');
		$this->form_validation->set_rules('no_sk_penghargaan', 'No.SK Penghargaan', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_penghargaan', 'Tanggal SK Penghargaan', 'trim|required');
		$this->form_validation->set_rules('form_penghargaan_berkas_sk_penghargaan_name', 'Berkas SK Penghargaan', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_penghargaan_berkas_sk_penghargaan_uuid = $this->input->post('form_penghargaan_berkas_sk_penghargaan_uuid');
			$form_penghargaan_berkas_sk_penghargaan_name = $this->input->post('form_penghargaan_berkas_sk_penghargaan_name');
		
			$save_data = [
				'jenis_penghargaan_satya_lencana' => $this->input->post('jenis_penghargaan_satya_lencana'),
				'no_sk_penghargaan' => $this->input->post('no_sk_penghargaan'),
				'tanggal_sk_penghargaan' => $this->input->post('tanggal_sk_penghargaan'),
				'deskripsi_sk_penghargaan' => $this->input->post('deskripsi_sk_penghargaan'),
				'berkas_sk_penghargaan' => $this->input->post('berkas_sk_penghargaan'),
			];

			if (!is_dir(FCPATH . '/uploads/form_penghargaan/')) {
				mkdir(FCPATH . '/uploads/form_penghargaan/');
			}

			if (!empty($form_penghargaan_berkas_sk_penghargaan_uuid)) {
				$form_penghargaan_berkas_sk_penghargaan_name_copy = date('YmdHis') . '-' . $form_penghargaan_berkas_sk_penghargaan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_penghargaan_berkas_sk_penghargaan_uuid . '/' . $form_penghargaan_berkas_sk_penghargaan_name, 
						FCPATH . 'uploads/form_penghargaan/' . $form_penghargaan_berkas_sk_penghargaan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_penghargaan/' . $form_penghargaan_berkas_sk_penghargaan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_penghargaan'] = $form_penghargaan_berkas_sk_penghargaan_name_copy;
			}
		
			
			$save_form_penghargaan = $this->model_form_penghargaan->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_penghargaan;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Penghargaan	* 
	* @return JSON
	*/
	public function upload_berkas_sk_penghargaan_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_penghargaan',
		]);
	}

	/**
	* Delete Image Form Penghargaan	* 
	* @return JSON
	*/
	public function delete_berkas_sk_penghargaan_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_penghargaan', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_penghargaan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penghargaan/'
        ]);
	}

	/**
	* Get Image Form Penghargaan	* 
	* @return JSON
	*/
	public function get_berkas_sk_penghargaan_file($id)
	{
		$form_penghargaan = $this->model_form_penghargaan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_penghargaan', 
            'table_name'        => 'form_penghargaan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penghargaan/',
            'delete_endpoint'   => 'administrator/form_penghargaan/delete_berkas_sk_penghargaan_file'
        ]);
	}
	
}


/* End of file form_penghargaan.php */
/* Location: ./application/controllers/administrator/Form Penghargaan.php */