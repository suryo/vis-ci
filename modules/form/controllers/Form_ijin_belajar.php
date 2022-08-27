<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Ijin Belajar Controller
*| --------------------------------------------------------------------------
*| Form Ijin Belajar site
*|
*/
class Form_ijin_belajar extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_ijin_belajar');
	}

	/**
	* Submit Form Ijin Belajars
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('id_pegawai', 'Id Pegawai', 'trim|required');
		$this->form_validation->set_rules('tingkat_pendidikan', 'Tingkat Pendidikan', 'trim|required');
		$this->form_validation->set_rules('sekolah_perguruan_tinggi', 'Sekolah/Perguruan Tinggi', 'trim|required');
		$this->form_validation->set_rules('form_ijin_belajar_berkas_surat_ijin_belajar_name', 'Berkas Surat Ijin Belajar', 'trim|required');
		$this->form_validation->set_rules('form_ijin_belajar_berkas_sertifikat_upkp_name', 'Berkas Sertifikat UPKP', 'trim');
		
		if ($this->form_validation->run()) {
			$form_ijin_belajar_berkas_surat_ijin_belajar_uuid = $this->input->post('form_ijin_belajar_berkas_surat_ijin_belajar_uuid');
			$form_ijin_belajar_berkas_surat_ijin_belajar_name = $this->input->post('form_ijin_belajar_berkas_surat_ijin_belajar_name');
			$form_ijin_belajar_berkas_sertifikat_upkp_uuid = $this->input->post('form_ijin_belajar_berkas_sertifikat_upkp_uuid');
			$form_ijin_belajar_berkas_sertifikat_upkp_name = $this->input->post('form_ijin_belajar_berkas_sertifikat_upkp_name');
		
			$save_data = [
				'id_pegawai' => $this->input->post('id_pegawai'),
				'tingkat_pendidikan' => $this->input->post('tingkat_pendidikan'),
				'tanggal_lulus_pendidikan' => $this->input->post('tanggal_lulus_pendidikan'),
				'no_ijazah' => $this->input->post('no_ijazah'),
				'sekolah_perguruan_tinggi' => $this->input->post('sekolah_perguruan_tinggi'),
				'berkas_surat_ijin_belajar' => $this->input->post('berkas_surat_ijin_belajar'),
				'berkas_sertifikat_upkp' => $this->input->post('berkas_sertifikat_upkp'),
			];

			if (!is_dir(FCPATH . '/uploads/form_ijin_belajar/')) {
				mkdir(FCPATH . '/uploads/form_ijin_belajar/');
			}

			if (!empty($form_ijin_belajar_berkas_surat_ijin_belajar_uuid)) {
				$form_ijin_belajar_berkas_surat_ijin_belajar_name_copy = date('YmdHis') . '-' . $form_ijin_belajar_berkas_surat_ijin_belajar_name;

				rename(FCPATH . 'uploads/tmp/' . $form_ijin_belajar_berkas_surat_ijin_belajar_uuid . '/' . $form_ijin_belajar_berkas_surat_ijin_belajar_name, 
						FCPATH . 'uploads/form_ijin_belajar/' . $form_ijin_belajar_berkas_surat_ijin_belajar_name_copy);

				if (!is_file(FCPATH . '/uploads/form_ijin_belajar/' . $form_ijin_belajar_berkas_surat_ijin_belajar_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_surat_ijin_belajar'] = $form_ijin_belajar_berkas_surat_ijin_belajar_name_copy;
			}
		
			if (!empty($form_ijin_belajar_berkas_sertifikat_upkp_uuid)) {
				$form_ijin_belajar_berkas_sertifikat_upkp_name_copy = date('YmdHis') . '-' . $form_ijin_belajar_berkas_sertifikat_upkp_name;

				rename(FCPATH . 'uploads/tmp/' . $form_ijin_belajar_berkas_sertifikat_upkp_uuid . '/' . $form_ijin_belajar_berkas_sertifikat_upkp_name, 
						FCPATH . 'uploads/form_ijin_belajar/' . $form_ijin_belajar_berkas_sertifikat_upkp_name_copy);

				if (!is_file(FCPATH . '/uploads/form_ijin_belajar/' . $form_ijin_belajar_berkas_sertifikat_upkp_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sertifikat_upkp'] = $form_ijin_belajar_berkas_sertifikat_upkp_name_copy;
			}
		
			
			$save_form_ijin_belajar = $this->model_form_ijin_belajar->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_ijin_belajar;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Ijin Belajar	* 
	* @return JSON
	*/
	public function upload_berkas_surat_ijin_belajar_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_ijin_belajar',
			'allowed_types' => 'pdf',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Ijin Belajar	* 
	* @return JSON
	*/
	public function delete_berkas_surat_ijin_belajar_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_surat_ijin_belajar', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_ijin_belajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_ijin_belajar/'
        ]);
	}

	/**
	* Get Image Form Ijin Belajar	* 
	* @return JSON
	*/
	public function get_berkas_surat_ijin_belajar_file($id)
	{
		$form_ijin_belajar = $this->model_form_ijin_belajar->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_surat_ijin_belajar', 
            'table_name'        => 'form_ijin_belajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_ijin_belajar/',
            'delete_endpoint'   => 'administrator/form_ijin_belajar/delete_berkas_surat_ijin_belajar_file'
        ]);
	}
	
	/**
	* Upload Image Form Ijin Belajar	* 
	* @return JSON
	*/
	public function upload_berkas_sertifikat_upkp_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_ijin_belajar',
			'allowed_types' => 'pdf',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Ijin Belajar	* 
	* @return JSON
	*/
	public function delete_berkas_sertifikat_upkp_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sertifikat_upkp', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_ijin_belajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_ijin_belajar/'
        ]);
	}

	/**
	* Get Image Form Ijin Belajar	* 
	* @return JSON
	*/
	public function get_berkas_sertifikat_upkp_file($id)
	{
		$form_ijin_belajar = $this->model_form_ijin_belajar->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sertifikat_upkp', 
            'table_name'        => 'form_ijin_belajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_ijin_belajar/',
            'delete_endpoint'   => 'administrator/form_ijin_belajar/delete_berkas_sertifikat_upkp_file'
        ]);
	}
	
}


/* End of file form_ijin_belajar.php */
/* Location: ./application/controllers/administrator/Form Ijin Belajar.php */