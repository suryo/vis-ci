<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form S Controller
*| --------------------------------------------------------------------------
*| Form S site
*|
*/
class Form_s extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_s');
	}

	/**
	* Submit Form Ss
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('input', 'Input', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'input' => $this->input->post('input'),
			];

			
			$save_form_s = $this->model_form_s->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_s;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
}


/* End of file form_s.php */
/* Location: ./application/controllers/administrator/Form S.php */