<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Nama Pangkat Ataugolongan Controller
*| --------------------------------------------------------------------------
*| Form Nama Pangkat Ataugolongan site
*|
*/
class Form_nama_pangkat_ataugolongan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_nama_pangkat_ataugolongan');
	}

	/**
	* Submit Form Nama Pangkat Ataugolongans
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('nama_pangkat_golongan', 'Nama Pangkat/Golongan', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'nama_pangkat_golongan' => $this->input->post('nama_pangkat_golongan'),
			];

			
			$save_form_nama_pangkat_ataugolongan = $this->model_form_nama_pangkat_ataugolongan->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_nama_pangkat_ataugolongan;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
}


/* End of file form_nama_pangkat_ataugolongan.php */
/* Location: ./application/controllers/administrator/Form Nama Pangkat Ataugolongan.php */