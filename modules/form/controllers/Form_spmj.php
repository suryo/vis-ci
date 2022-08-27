<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Spmj Controller
*| --------------------------------------------------------------------------
*| Form Spmj site
*|
*/
class Form_spmj extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_spmj');
	}

	/**
	* Submit Form Spmjs
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_spmj', 'No. SPMJ', 'trim|required');
		$this->form_validation->set_rules('tanggal_spmj', 'Tanggal SPMJ', 'trim|required');
		$this->form_validation->set_rules('form_spmj_berkas_spmj_name', 'Berkas SPMJ', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_spmj_berkas_spmj_uuid = $this->input->post('form_spmj_berkas_spmj_uuid');
			$form_spmj_berkas_spmj_name = $this->input->post('form_spmj_berkas_spmj_name');
		
			$save_data = [
				'no_spmj' => $this->input->post('no_spmj'),
				'tanggal_spmj' => $this->input->post('tanggal_spmj'),
				'berkas_spmj' => $this->input->post('berkas_spmj'),
			];

			if (!is_dir(FCPATH . '/uploads/form_spmj/')) {
				mkdir(FCPATH . '/uploads/form_spmj/');
			}

			if (!empty($form_spmj_berkas_spmj_uuid)) {
				$form_spmj_berkas_spmj_name_copy = date('YmdHis') . '-' . $form_spmj_berkas_spmj_name;

				rename(FCPATH . 'uploads/tmp/' . $form_spmj_berkas_spmj_uuid . '/' . $form_spmj_berkas_spmj_name, 
						FCPATH . 'uploads/form_spmj/' . $form_spmj_berkas_spmj_name_copy);

				if (!is_file(FCPATH . '/uploads/form_spmj/' . $form_spmj_berkas_spmj_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_spmj'] = $form_spmj_berkas_spmj_name_copy;
			}
		
			
			$save_form_spmj = $this->model_form_spmj->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_spmj;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Spmj	* 
	* @return JSON
	*/
	public function upload_berkas_spmj_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_spmj',
		]);
	}

	/**
	* Delete Image Form Spmj	* 
	* @return JSON
	*/
	public function delete_berkas_spmj_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_spmj', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_spmj',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_spmj/'
        ]);
	}

	/**
	* Get Image Form Spmj	* 
	* @return JSON
	*/
	public function get_berkas_spmj_file($id)
	{
		$form_spmj = $this->model_form_spmj->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_spmj', 
            'table_name'        => 'form_spmj',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_spmj/',
            'delete_endpoint'   => 'administrator/form_spmj/delete_berkas_spmj_file'
        ]);
	}
	
}


/* End of file form_spmj.php */
/* Location: ./application/controllers/administrator/Form Spmj.php */