<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Jenis Penghargaan Controller
*| --------------------------------------------------------------------------
*| Form Jenis Penghargaan site
*|
*/
class Form_jenis_penghargaan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_jenis_penghargaan');
	}

	/**
	* Submit Form Jenis Penghargaans
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('jenis_penghargaan', 'Jenis Penghargaan', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'jenis_penghargaan' => $this->input->post('jenis_penghargaan'),
			];

			
			$save_form_jenis_penghargaan = $this->model_form_jenis_penghargaan->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_jenis_penghargaan;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
}


/* End of file form_jenis_penghargaan.php */
/* Location: ./application/controllers/administrator/Form Jenis Penghargaan.php */