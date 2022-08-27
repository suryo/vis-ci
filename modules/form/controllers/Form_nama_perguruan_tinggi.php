<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Nama Perguruan Tinggi Controller
*| --------------------------------------------------------------------------
*| Form Nama Perguruan Tinggi site
*|
*/
class Form_nama_perguruan_tinggi extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_nama_perguruan_tinggi');
	}

	/**
	* Submit Form Nama Perguruan Tinggis
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('nama_perguruan_tinggi', 'Nama Perguruan Tinggi', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'nama_perguruan_tinggi' => $this->input->post('nama_perguruan_tinggi'),
			];

			
			$save_form_nama_perguruan_tinggi = $this->model_form_nama_perguruan_tinggi->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_nama_perguruan_tinggi;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
}


/* End of file form_nama_perguruan_tinggi.php */
/* Location: ./application/controllers/administrator/Form Nama Perguruan Tinggi.php */