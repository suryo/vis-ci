<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form B Controller
*| --------------------------------------------------------------------------
*| Form B site
*|
*/
class Form_b extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_b');
	}

	/**
	* Submit Form Bs
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('input', 'Input', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'input' => $this->input->post('input'),
			];

			
			$save_form_b = $this->model_form_b->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_b;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
}


/* End of file form_b.php */
/* Location: ./application/controllers/administrator/Form B.php */