<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Assesment Controller
*| --------------------------------------------------------------------------
*| Form Assesment site
*|
*/
class Form_assesment extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_assesment');
	}

	/**
	* Submit Form Assesments
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('_tanggal_assesment', ' Tanggal Assesment', 'trim|required');
		$this->form_validation->set_rules('level', 'Level', 'trim|required');
		$this->form_validation->set_rules('form_assesment_berkas_assesment_name', 'Berkas Assesment', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_assesment_berkas_assesment_uuid = $this->input->post('form_assesment_berkas_assesment_uuid');
			$form_assesment_berkas_assesment_name = $this->input->post('form_assesment_berkas_assesment_name');
		
			$save_data = [
				'no_assesment' => $this->input->post('no_assesment'),
				'_tanggal_assesment' => $this->input->post('_tanggal_assesment'),
				'level' => $this->input->post('level'),
				'keterangan' => $this->input->post('keterangan'),
				'berkas_assesment' => $this->input->post('berkas_assesment'),
			];

			if (!is_dir(FCPATH . '/uploads/form_assesment/')) {
				mkdir(FCPATH . '/uploads/form_assesment/');
			}

			if (!empty($form_assesment_berkas_assesment_uuid)) {
				$form_assesment_berkas_assesment_name_copy = date('YmdHis') . '-' . $form_assesment_berkas_assesment_name;

				rename(FCPATH . 'uploads/tmp/' . $form_assesment_berkas_assesment_uuid . '/' . $form_assesment_berkas_assesment_name, 
						FCPATH . 'uploads/form_assesment/' . $form_assesment_berkas_assesment_name_copy);

				if (!is_file(FCPATH . '/uploads/form_assesment/' . $form_assesment_berkas_assesment_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_assesment'] = $form_assesment_berkas_assesment_name_copy;
			}
		
			
			$save_form_assesment = $this->model_form_assesment->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_assesment;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Assesment	* 
	* @return JSON
	*/
	public function upload_berkas_assesment_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_assesment',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Assesment	* 
	* @return JSON
	*/
	public function delete_berkas_assesment_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_assesment', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_assesment',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_assesment/'
        ]);
	}

	/**
	* Get Image Form Assesment	* 
	* @return JSON
	*/
	public function get_berkas_assesment_file($id)
	{
		$form_assesment = $this->model_form_assesment->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_assesment', 
            'table_name'        => 'form_assesment',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_assesment/',
            'delete_endpoint'   => 'administrator/form_assesment/delete_berkas_assesment_file'
        ]);
	}
	
}


/* End of file form_assesment.php */
/* Location: ./application/controllers/administrator/Form Assesment.php */