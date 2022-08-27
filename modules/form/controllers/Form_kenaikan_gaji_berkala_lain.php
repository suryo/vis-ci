<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Kenaikan Gaji Berkala Lain Controller
*| --------------------------------------------------------------------------
*| Form Kenaikan Gaji Berkala Lain site
*|
*/
class Form_kenaikan_gaji_berkala_lain extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_kenaikan_gaji_berkala_lain');
	}

	/**
	* Submit Form Kenaikan Gaji Berkala Lains
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('nama_berkas', 'Nama Berkas', 'trim|required');
		$this->form_validation->set_rules('form_kenaikan_gaji_berkala_lain_berkas_kenaikan_gaji_berkala_lain_name', 'Berkas Kenaikan Gaji Berkala Lain', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_kenaikan_gaji_berkala_lain_berkas_kenaikan_gaji_berkala_lain_uuid = $this->input->post('form_kenaikan_gaji_berkala_lain_berkas_kenaikan_gaji_berkala_lain_uuid');
			$form_kenaikan_gaji_berkala_lain_berkas_kenaikan_gaji_berkala_lain_name = $this->input->post('form_kenaikan_gaji_berkala_lain_berkas_kenaikan_gaji_berkala_lain_name');
		
			$save_data = [
				'nama_berkas' => $this->input->post('nama_berkas'),
				'deskripsi_arsip' => $this->input->post('deskripsi_arsip'),
				'berkas_kenaikan_gaji_berkala_lain' => $this->input->post('berkas_kenaikan_gaji_berkala_lain'),
			];

			if (!is_dir(FCPATH . '/uploads/form_kenaikan_gaji_berkala_lain/')) {
				mkdir(FCPATH . '/uploads/form_kenaikan_gaji_berkala_lain/');
			}

			if (!empty($form_kenaikan_gaji_berkala_lain_berkas_kenaikan_gaji_berkala_lain_uuid)) {
				$form_kenaikan_gaji_berkala_lain_berkas_kenaikan_gaji_berkala_lain_name_copy = date('YmdHis') . '-' . $form_kenaikan_gaji_berkala_lain_berkas_kenaikan_gaji_berkala_lain_name;

				rename(FCPATH . 'uploads/tmp/' . $form_kenaikan_gaji_berkala_lain_berkas_kenaikan_gaji_berkala_lain_uuid . '/' . $form_kenaikan_gaji_berkala_lain_berkas_kenaikan_gaji_berkala_lain_name, 
						FCPATH . 'uploads/form_kenaikan_gaji_berkala_lain/' . $form_kenaikan_gaji_berkala_lain_berkas_kenaikan_gaji_berkala_lain_name_copy);

				if (!is_file(FCPATH . '/uploads/form_kenaikan_gaji_berkala_lain/' . $form_kenaikan_gaji_berkala_lain_berkas_kenaikan_gaji_berkala_lain_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_kenaikan_gaji_berkala_lain'] = $form_kenaikan_gaji_berkala_lain_berkas_kenaikan_gaji_berkala_lain_name_copy;
			}
		
			
			$save_form_kenaikan_gaji_berkala_lain = $this->model_form_kenaikan_gaji_berkala_lain->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_kenaikan_gaji_berkala_lain;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Kenaikan Gaji Berkala Lain	* 
	* @return JSON
	*/
	public function upload_berkas_kenaikan_gaji_berkala_lain_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_kenaikan_gaji_berkala_lain',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Kenaikan Gaji Berkala Lain	* 
	* @return JSON
	*/
	public function delete_berkas_kenaikan_gaji_berkala_lain_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_kenaikan_gaji_berkala_lain', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_kenaikan_gaji_berkala_lain',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_kenaikan_gaji_berkala_lain/'
        ]);
	}

	/**
	* Get Image Form Kenaikan Gaji Berkala Lain	* 
	* @return JSON
	*/
	public function get_berkas_kenaikan_gaji_berkala_lain_file($id)
	{
		$form_kenaikan_gaji_berkala_lain = $this->model_form_kenaikan_gaji_berkala_lain->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_kenaikan_gaji_berkala_lain', 
            'table_name'        => 'form_kenaikan_gaji_berkala_lain',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_kenaikan_gaji_berkala_lain/',
            'delete_endpoint'   => 'administrator/form_kenaikan_gaji_berkala_lain/delete_berkas_kenaikan_gaji_berkala_lain_file'
        ]);
	}
	
}


/* End of file form_kenaikan_gaji_berkala_lain.php */
/* Location: ./application/controllers/administrator/Form Kenaikan Gaji Berkala Lain.php */