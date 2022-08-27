<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Jenis Jabatan Controller
*| --------------------------------------------------------------------------
*| Form Jenis Jabatan site
*|
*/
class Form_jenis_jabatan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_jenis_jabatan');
	}

	/**
	* Submit Form Jenis Jabatans
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('nama_jenis_jabatan', 'Nama Jenis Jabatan', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'nama_jenis_jabatan' => $this->input->post('nama_jenis_jabatan'),
			];

			
			$save_form_jenis_jabatan = $this->model_form_jenis_jabatan->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_jenis_jabatan;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
}


/* End of file form_jenis_jabatan.php */
/* Location: ./application/controllers/administrator/Form Jenis Jabatan.php */