<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Level Assesment Controller
*| --------------------------------------------------------------------------
*| Form Level Assesment site
*|
*/
class Form_level_assesment extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_level_assesment');
	}

	/**
	* Submit Form Level Assesments
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('level_assesment', 'Level Assesment', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'level_assesment' => $this->input->post('level_assesment'),
			];

			
			$save_form_level_assesment = $this->model_form_level_assesment->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_level_assesment;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
}


/* End of file form_level_assesment.php */
/* Location: ./application/controllers/administrator/Form Level Assesment.php */