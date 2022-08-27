<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Spmt Controller
*| --------------------------------------------------------------------------
*| Form Spmt site
*|
*/
class Form_spmt extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_spmt');
	}

	/**
	* Submit Form Spmts
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_spmt', 'No. SPMT', 'trim|required');
		$this->form_validation->set_rules('tanggal_spmt', 'Tanggal SPMT', 'trim|required');
		$this->form_validation->set_rules('form_spmt_berkas_spmt_name', 'Berkas SPMT', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_spmt_berkas_spmt_uuid = $this->input->post('form_spmt_berkas_spmt_uuid');
			$form_spmt_berkas_spmt_name = $this->input->post('form_spmt_berkas_spmt_name');
		
			$save_data = [
				'no_spmt' => $this->input->post('no_spmt'),
				'tanggal_spmt' => $this->input->post('tanggal_spmt'),
				'deskripsi_spmt' => $this->input->post('deskripsi_spmt'),
				'berkas_spmt' => $this->input->post('berkas_spmt'),
			];

			if (!is_dir(FCPATH . '/uploads/form_spmt/')) {
				mkdir(FCPATH . '/uploads/form_spmt/');
			}

			if (!empty($form_spmt_berkas_spmt_uuid)) {
				$form_spmt_berkas_spmt_name_copy = date('YmdHis') . '-' . $form_spmt_berkas_spmt_name;

				rename(FCPATH . 'uploads/tmp/' . $form_spmt_berkas_spmt_uuid . '/' . $form_spmt_berkas_spmt_name, 
						FCPATH . 'uploads/form_spmt/' . $form_spmt_berkas_spmt_name_copy);

				if (!is_file(FCPATH . '/uploads/form_spmt/' . $form_spmt_berkas_spmt_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_spmt'] = $form_spmt_berkas_spmt_name_copy;
			}
		
			
			$save_form_spmt = $this->model_form_spmt->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_spmt;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Spmt	* 
	* @return JSON
	*/
	public function upload_berkas_spmt_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_spmt',
		]);
	}

	/**
	* Delete Image Form Spmt	* 
	* @return JSON
	*/
	public function delete_berkas_spmt_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_spmt', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_spmt',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_spmt/'
        ]);
	}

	/**
	* Get Image Form Spmt	* 
	* @return JSON
	*/
	public function get_berkas_spmt_file($id)
	{
		$form_spmt = $this->model_form_spmt->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_spmt', 
            'table_name'        => 'form_spmt',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_spmt/',
            'delete_endpoint'   => 'administrator/form_spmt/delete_berkas_spmt_file'
        ]);
	}
	
}


/* End of file form_spmt.php */
/* Location: ./application/controllers/administrator/Form Spmt.php */