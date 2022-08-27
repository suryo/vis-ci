<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Check Controller
*| --------------------------------------------------------------------------
*| Form Check site
*|
*/
class Form_check extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_check');
	}

	/**
	* Submit Form Checks
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('custom_option', 'Custom Option', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'custom_option' => $this->input->post('custom_option'),
			];

			
			$save_form_check = $this->model_form_check->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_check;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
}


/* End of file form_check.php */
/* Location: ./application/controllers/administrator/Form Check.php */