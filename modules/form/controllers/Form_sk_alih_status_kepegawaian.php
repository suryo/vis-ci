<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Sk Alih Status Kepegawaian Controller
*| --------------------------------------------------------------------------
*| Form Sk Alih Status Kepegawaian site
*|
*/
class Form_sk_alih_status_kepegawaian extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_sk_alih_status_kepegawaian');
	}

	/**
	* Submit Form Sk Alih Status Kepegawaians
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_sk_alih_status_kepegawaian', 'No. SK  Alih Status Kepegawaian', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_alih_status_kepegawaian', 'Tanggal SK  Alih Status Kepegawaian', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('deskripsi_sk_alih_status_kepegawaian', 'Deskripsi SK  Alih Status Kepegawaian', 'trim|required');
		$this->form_validation->set_rules('berkas_sk_alih_status_kepegawaian', 'Berkas SK  Alih Status Kepegawaian', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'no_sk_alih_status_kepegawaian' => $this->input->post('no_sk_alih_status_kepegawaian'),
				'tanggal_sk_alih_status_kepegawaian' => $this->input->post('tanggal_sk_alih_status_kepegawaian'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_sk_alih_status_kepegawaian' => $this->input->post('deskripsi_sk_alih_status_kepegawaian'),
				'berkas_sk_alih_status_kepegawaian' => $this->input->post('berkas_sk_alih_status_kepegawaian'),
			];

			
			$save_form_sk_alih_status_kepegawaian = $this->model_form_sk_alih_status_kepegawaian->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_sk_alih_status_kepegawaian;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
}


/* End of file form_sk_alih_status_kepegawaian.php */
/* Location: ./application/controllers/administrator/Form Sk Alih Status Kepegawaian.php */