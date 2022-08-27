<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Data Instansi Controller
*| --------------------------------------------------------------------------
*| Form Data Instansi site
*|
*/
class Form_data_instansi extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_data_instansi');
	}

	/**
	* Submit Form Data Instansis
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('nama_instansi', 'Nama Instansi', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'nama_instansi' => $this->input->post('nama_instansi'),
			];

			
			$save_form_data_instansi = $this->model_form_data_instansi->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_data_instansi;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
}


/* End of file form_data_instansi.php */
/* Location: ./application/controllers/administrator/Form Data Instansi.php */