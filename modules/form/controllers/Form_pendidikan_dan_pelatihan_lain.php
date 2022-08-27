<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Pendidikan Dan Pelatihan Lain Controller
*| --------------------------------------------------------------------------
*| Form Pendidikan Dan Pelatihan Lain site
*|
*/
class Form_pendidikan_dan_pelatihan_lain extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_pendidikan_dan_pelatihan_lain');
	}

	/**
	* Submit Form Pendidikan Dan Pelatihan Lains
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('nama_berkas', 'Nama Berkas', 'trim|required');
		$this->form_validation->set_rules('form_pendidikan_dan_pelatihan_lain_berkas_pendidikan_pelatihan_lain_name', 'Berkas Pendidikan & Pelatihan Lain', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_pendidikan_dan_pelatihan_lain_berkas_pendidikan_pelatihan_lain_uuid = $this->input->post('form_pendidikan_dan_pelatihan_lain_berkas_pendidikan_pelatihan_lain_uuid');
			$form_pendidikan_dan_pelatihan_lain_berkas_pendidikan_pelatihan_lain_name = $this->input->post('form_pendidikan_dan_pelatihan_lain_berkas_pendidikan_pelatihan_lain_name');
		
			$save_data = [
				'nama_berkas' => $this->input->post('nama_berkas'),
				'deskripsi_arsip' => $this->input->post('deskripsi_arsip'),
				'berkas_pendidikan_pelatihan_lain' => $this->input->post('berkas_pendidikan_pelatihan_lain'),
			];

			if (!is_dir(FCPATH . '/uploads/form_pendidikan_dan_pelatihan_lain/')) {
				mkdir(FCPATH . '/uploads/form_pendidikan_dan_pelatihan_lain/');
			}

			if (!empty($form_pendidikan_dan_pelatihan_lain_berkas_pendidikan_pelatihan_lain_uuid)) {
				$form_pendidikan_dan_pelatihan_lain_berkas_pendidikan_pelatihan_lain_name_copy = date('YmdHis') . '-' . $form_pendidikan_dan_pelatihan_lain_berkas_pendidikan_pelatihan_lain_name;

				rename(FCPATH . 'uploads/tmp/' . $form_pendidikan_dan_pelatihan_lain_berkas_pendidikan_pelatihan_lain_uuid . '/' . $form_pendidikan_dan_pelatihan_lain_berkas_pendidikan_pelatihan_lain_name, 
						FCPATH . 'uploads/form_pendidikan_dan_pelatihan_lain/' . $form_pendidikan_dan_pelatihan_lain_berkas_pendidikan_pelatihan_lain_name_copy);

				if (!is_file(FCPATH . '/uploads/form_pendidikan_dan_pelatihan_lain/' . $form_pendidikan_dan_pelatihan_lain_berkas_pendidikan_pelatihan_lain_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_pendidikan_pelatihan_lain'] = $form_pendidikan_dan_pelatihan_lain_berkas_pendidikan_pelatihan_lain_name_copy;
			}
		
			
			$save_form_pendidikan_dan_pelatihan_lain = $this->model_form_pendidikan_dan_pelatihan_lain->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_pendidikan_dan_pelatihan_lain;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Pendidikan Dan Pelatihan Lain	* 
	* @return JSON
	*/
	public function upload_berkas_pendidikan_pelatihan_lain_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_pendidikan_dan_pelatihan_lain',
		]);
	}

	/**
	* Delete Image Form Pendidikan Dan Pelatihan Lain	* 
	* @return JSON
	*/
	public function delete_berkas_pendidikan_pelatihan_lain_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_pendidikan_pelatihan_lain', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_pendidikan_dan_pelatihan_lain',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pendidikan_dan_pelatihan_lain/'
        ]);
	}

	/**
	* Get Image Form Pendidikan Dan Pelatihan Lain	* 
	* @return JSON
	*/
	public function get_berkas_pendidikan_pelatihan_lain_file($id)
	{
		$form_pendidikan_dan_pelatihan_lain = $this->model_form_pendidikan_dan_pelatihan_lain->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_pendidikan_pelatihan_lain', 
            'table_name'        => 'form_pendidikan_dan_pelatihan_lain',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pendidikan_dan_pelatihan_lain/',
            'delete_endpoint'   => 'administrator/form_pendidikan_dan_pelatihan_lain/delete_berkas_pendidikan_pelatihan_lain_file'
        ]);
	}
	
}


/* End of file form_pendidikan_dan_pelatihan_lain.php */
/* Location: ./application/controllers/administrator/Form Pendidikan Dan Pelatihan Lain.php */