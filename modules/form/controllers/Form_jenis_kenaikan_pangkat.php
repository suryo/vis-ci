<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Jenis Kenaikan Pangkat Controller
*| --------------------------------------------------------------------------
*| Form Jenis Kenaikan Pangkat site
*|
*/
class Form_jenis_kenaikan_pangkat extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_jenis_kenaikan_pangkat');
	}

	/**
	* Submit Form Jenis Kenaikan Pangkats
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('nama_jenis_kenaikan_pangkat', 'Nama Jenis Kenaikan Pangkat', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'nama_jenis_kenaikan_pangkat' => $this->input->post('nama_jenis_kenaikan_pangkat'),
			];

			
			$save_form_jenis_kenaikan_pangkat = $this->model_form_jenis_kenaikan_pangkat->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_jenis_kenaikan_pangkat;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
}


/* End of file form_jenis_kenaikan_pangkat.php */
/* Location: ./application/controllers/administrator/Form Jenis Kenaikan Pangkat.php */