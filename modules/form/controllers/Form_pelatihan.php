<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Pelatihan Controller
*| --------------------------------------------------------------------------
*| Form Pelatihan site
*|
*/
class Form_pelatihan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_pelatihan');
	}

	/**
	* Submit Form Pelatihans
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('jenis_pelatihan', 'Jenis Pelatihan', 'trim|required');
		$this->form_validation->set_rules('nama_pelatihan', 'Nama Pelatihan', 'trim|required');
		$this->form_validation->set_rules('instansi_penyelenggara', 'Instansi Penyelenggara', 'trim|required');
		$this->form_validation->set_rules('form_pelatihan_berkas_pelatihan_name', 'Berkas Pelatihan', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_pelatihan_berkas_pelatihan_uuid = $this->input->post('form_pelatihan_berkas_pelatihan_uuid');
			$form_pelatihan_berkas_pelatihan_name = $this->input->post('form_pelatihan_berkas_pelatihan_name');
		
			$save_data = [
				'jenis_pelatihan' => $this->input->post('jenis_pelatihan'),
				'nama_pelatihan' => $this->input->post('nama_pelatihan'),
				'no_sertifikat_pelatihan' => $this->input->post('no_sertifikat_pelatihan'),
				'tanggal_sertifikat_pelatihan' => $this->input->post('tanggal_sertifikat_pelatihan'),
				'tanggal_mulai_pelatihan' => $this->input->post('tanggal_mulai_pelatihan'),
				'tanggal_selesai_pelatihan' => $this->input->post('tanggal_selesai_pelatihan'),
				'durasi_pelatihan' => $this->input->post('durasi_pelatihan'),
				'instansi_penyelenggara' => $this->input->post('instansi_penyelenggara'),
				'deskripsi_pelatihan' => $this->input->post('deskripsi_pelatihan'),
				'berkas_pelatihan' => $this->input->post('berkas_pelatihan'),
			];

			if (!is_dir(FCPATH . '/uploads/form_pelatihan/')) {
				mkdir(FCPATH . '/uploads/form_pelatihan/');
			}

			if (!empty($form_pelatihan_berkas_pelatihan_uuid)) {
				$form_pelatihan_berkas_pelatihan_name_copy = date('YmdHis') . '-' . $form_pelatihan_berkas_pelatihan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_pelatihan_berkas_pelatihan_uuid . '/' . $form_pelatihan_berkas_pelatihan_name, 
						FCPATH . 'uploads/form_pelatihan/' . $form_pelatihan_berkas_pelatihan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_pelatihan/' . $form_pelatihan_berkas_pelatihan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_pelatihan'] = $form_pelatihan_berkas_pelatihan_name_copy;
			}
		
			
			$save_form_pelatihan = $this->model_form_pelatihan->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_pelatihan;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Pelatihan	* 
	* @return JSON
	*/
	public function upload_berkas_pelatihan_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_pelatihan',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Pelatihan	* 
	* @return JSON
	*/
	public function delete_berkas_pelatihan_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_pelatihan', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_pelatihan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pelatihan/'
        ]);
	}

	/**
	* Get Image Form Pelatihan	* 
	* @return JSON
	*/
	public function get_berkas_pelatihan_file($id)
	{
		$form_pelatihan = $this->model_form_pelatihan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_pelatihan', 
            'table_name'        => 'form_pelatihan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pelatihan/',
            'delete_endpoint'   => 'administrator/form_pelatihan/delete_berkas_pelatihan_file'
        ]);
	}
	
}


/* End of file form_pelatihan.php */
/* Location: ./application/controllers/administrator/Form Pelatihan.php */