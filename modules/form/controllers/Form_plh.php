<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Plh Controller
*| --------------------------------------------------------------------------
*| Form Plh site
*|
*/
class Form_plh extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_plh');
	}

	/**
	* Submit Form Plhs
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_sk_plh', 'No. SK PLH', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_plh', 'Tanggal SK PLH', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_plh_berkas_sk_plh_name', 'Berkas SK PLH', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_plh_berkas_sk_plh_uuid = $this->input->post('form_plh_berkas_sk_plh_uuid');
			$form_plh_berkas_sk_plh_name = $this->input->post('form_plh_berkas_sk_plh_name');
		
			$save_data = [
				'no_sk_plh' => $this->input->post('no_sk_plh'),
				'tanggal_sk_plh' => $this->input->post('tanggal_sk_plh'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_sk_plh' => $this->input->post('deskripsi_sk_plh'),
				'berkas_sk_plh' => $this->input->post('berkas_sk_plh'),
			];

			if (!is_dir(FCPATH . '/uploads/form_plh/')) {
				mkdir(FCPATH . '/uploads/form_plh/');
			}

			if (!empty($form_plh_berkas_sk_plh_uuid)) {
				$form_plh_berkas_sk_plh_name_copy = date('YmdHis') . '-' . $form_plh_berkas_sk_plh_name;

				rename(FCPATH . 'uploads/tmp/' . $form_plh_berkas_sk_plh_uuid . '/' . $form_plh_berkas_sk_plh_name, 
						FCPATH . 'uploads/form_plh/' . $form_plh_berkas_sk_plh_name_copy);

				if (!is_file(FCPATH . '/uploads/form_plh/' . $form_plh_berkas_sk_plh_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_plh'] = $form_plh_berkas_sk_plh_name_copy;
			}
		
			
			$save_form_plh = $this->model_form_plh->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_plh;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Plh	* 
	* @return JSON
	*/
	public function upload_berkas_sk_plh_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_plh',
		]);
	}

	/**
	* Delete Image Form Plh	* 
	* @return JSON
	*/
	public function delete_berkas_sk_plh_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_plh', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_plh',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_plh/'
        ]);
	}

	/**
	* Get Image Form Plh	* 
	* @return JSON
	*/
	public function get_berkas_sk_plh_file($id)
	{
		$form_plh = $this->model_form_plh->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_plh', 
            'table_name'        => 'form_plh',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_plh/',
            'delete_endpoint'   => 'administrator/form_plh/delete_berkas_sk_plh_file'
        ]);
	}
	
}


/* End of file form_plh.php */
/* Location: ./application/controllers/administrator/Form Plh.php */