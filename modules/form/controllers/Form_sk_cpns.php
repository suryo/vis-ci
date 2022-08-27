<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Sk Cpns Controller
*| --------------------------------------------------------------------------
*| Form Sk Cpns site
*|
*/
class Form_sk_cpns extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_sk_cpns');
	}

	/**
	* Submit Form Sk Cpnss
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_sk_cpns', 'No. SK CPNS', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_cpns', 'Tanggal SK CPNS', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_sk_cpns_berkas_sk_cpns_name', 'Berkas SK CPNS', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_sk_cpns_berkas_sk_cpns_uuid = $this->input->post('form_sk_cpns_berkas_sk_cpns_uuid');
			$form_sk_cpns_berkas_sk_cpns_name = $this->input->post('form_sk_cpns_berkas_sk_cpns_name');
		
			$save_data = [
				'no_sk_cpns' => $this->input->post('no_sk_cpns'),
				'tanggal_sk_cpns' => $this->input->post('tanggal_sk_cpns'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_sk_cpns' => $this->input->post('deskripsi_sk_cpns'),
				'berkas_sk_cpns' => $this->input->post('berkas_sk_cpns'),
			];

			if (!is_dir(FCPATH . '/uploads/form_sk_cpns/')) {
				mkdir(FCPATH . '/uploads/form_sk_cpns/');
			}

			if (!empty($form_sk_cpns_berkas_sk_cpns_uuid)) {
				$form_sk_cpns_berkas_sk_cpns_name_copy = date('YmdHis') . '-' . $form_sk_cpns_berkas_sk_cpns_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_cpns_berkas_sk_cpns_uuid . '/' . $form_sk_cpns_berkas_sk_cpns_name, 
						FCPATH . 'uploads/form_sk_cpns/' . $form_sk_cpns_berkas_sk_cpns_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_cpns/' . $form_sk_cpns_berkas_sk_cpns_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_cpns'] = $form_sk_cpns_berkas_sk_cpns_name_copy;
			}
		
			
			$save_form_sk_cpns = $this->model_form_sk_cpns->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_sk_cpns;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Sk Cpns	* 
	* @return JSON
	*/
	public function upload_berkas_sk_cpns_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_cpns',
		]);
	}

	/**
	* Delete Image Form Sk Cpns	* 
	* @return JSON
	*/
	public function delete_berkas_sk_cpns_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_cpns', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_cpns',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_cpns/'
        ]);
	}

	/**
	* Get Image Form Sk Cpns	* 
	* @return JSON
	*/
	public function get_berkas_sk_cpns_file($id)
	{
		$form_sk_cpns = $this->model_form_sk_cpns->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_cpns', 
            'table_name'        => 'form_sk_cpns',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_cpns/',
            'delete_endpoint'   => 'administrator/form_sk_cpns/delete_berkas_sk_cpns_file'
        ]);
	}
	
}


/* End of file form_sk_cpns.php */
/* Location: ./application/controllers/administrator/Form Sk Cpns.php */