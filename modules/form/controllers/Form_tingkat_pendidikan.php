<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Tingkat Pendidikan Controller
*| --------------------------------------------------------------------------
*| Form Tingkat Pendidikan site
*|
*/
class Form_tingkat_pendidikan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_tingkat_pendidikan');
	}

	/**
	* Submit Form Tingkat Pendidikans
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('tingkat_pendidikan', 'Tingkat Pendidikan', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'tingkat_pendidikan' => $this->input->post('tingkat_pendidikan'),
			];

			
			$save_form_tingkat_pendidikan = $this->model_form_tingkat_pendidikan->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_tingkat_pendidikan;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
}


/* End of file form_tingkat_pendidikan.php */
/* Location: ./application/controllers/administrator/Form Tingkat Pendidikan.php */