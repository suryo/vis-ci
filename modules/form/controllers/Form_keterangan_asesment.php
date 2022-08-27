<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Keterangan Asesment Controller
*| --------------------------------------------------------------------------
*| Form Keterangan Asesment site
*|
*/
class Form_keterangan_asesment extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_keterangan_asesment');
	}

	/**
	* Submit Form Keterangan Asesments
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('keterangan_assement', 'Keterangan Assement', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'keterangan_assement' => $this->input->post('keterangan_assement'),
			];

			
			$save_form_keterangan_asesment = $this->model_form_keterangan_asesment->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_keterangan_asesment;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
}


/* End of file form_keterangan_asesment.php */
/* Location: ./application/controllers/administrator/Form Keterangan Asesment.php */