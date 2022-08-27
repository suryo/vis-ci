<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Tugasbelajar Controller
*| --------------------------------------------------------------------------
*| Form Tugasbelajar site
*|
*/
class Form_tugasbelajar extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_tugasbelajar');
	}

	/**
	* Submit Form Tugasbelajars
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('tingkat_pendidikan', 'Tingkat Pendidikan', 'trim|required');
		$this->form_validation->set_rules('form_tugasbelajar_berkas_surat_tugas_belajar_name', 'Berkas Surat Tugas Belajar', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_tugasbelajar_berkas_surat_tugas_belajar_uuid = $this->input->post('form_tugasbelajar_berkas_surat_tugas_belajar_uuid');
			$form_tugasbelajar_berkas_surat_tugas_belajar_name = $this->input->post('form_tugasbelajar_berkas_surat_tugas_belajar_name');
			$form_tugasbelajar_berkas_laporan_selesai_pendidikan_uuid = $this->input->post('form_tugasbelajar_berkas_laporan_selesai_pendidikan_uuid');
			$form_tugasbelajar_berkas_laporan_selesai_pendidikan_name = $this->input->post('form_tugasbelajar_berkas_laporan_selesai_pendidikan_name');
		
			$save_data = [
				'tingkat_pendidikan' => $this->input->post('tingkat_pendidikan'),
				'tanggal_lulus_pendidikan' => $this->input->post('tanggal_lulus_pendidikan'),
				'no_ijazah' => $this->input->post('no_ijazah'),
				'sekolah_perguruan_tinggi' => $this->input->post('sekolah_perguruan_tinggi'),
				'berkas_surat_tugas_belajar' => $this->input->post('berkas_surat_tugas_belajar'),
				'berkas_laporan_selesai_pendidikan' => $this->input->post('berkas_laporan_selesai_pendidikan'),
			];

			if (!is_dir(FCPATH . '/uploads/form_tugasbelajar/')) {
				mkdir(FCPATH . '/uploads/form_tugasbelajar/');
			}

			if (!empty($form_tugasbelajar_berkas_surat_tugas_belajar_uuid)) {
				$form_tugasbelajar_berkas_surat_tugas_belajar_name_copy = date('YmdHis') . '-' . $form_tugasbelajar_berkas_surat_tugas_belajar_name;

				rename(FCPATH . 'uploads/tmp/' . $form_tugasbelajar_berkas_surat_tugas_belajar_uuid . '/' . $form_tugasbelajar_berkas_surat_tugas_belajar_name, 
						FCPATH . 'uploads/form_tugasbelajar/' . $form_tugasbelajar_berkas_surat_tugas_belajar_name_copy);

				if (!is_file(FCPATH . '/uploads/form_tugasbelajar/' . $form_tugasbelajar_berkas_surat_tugas_belajar_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_surat_tugas_belajar'] = $form_tugasbelajar_berkas_surat_tugas_belajar_name_copy;
			}
		
			if (!empty($form_tugasbelajar_berkas_laporan_selesai_pendidikan_uuid)) {
				$form_tugasbelajar_berkas_laporan_selesai_pendidikan_name_copy = date('YmdHis') . '-' . $form_tugasbelajar_berkas_laporan_selesai_pendidikan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_tugasbelajar_berkas_laporan_selesai_pendidikan_uuid . '/' . $form_tugasbelajar_berkas_laporan_selesai_pendidikan_name, 
						FCPATH . 'uploads/form_tugasbelajar/' . $form_tugasbelajar_berkas_laporan_selesai_pendidikan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_tugasbelajar/' . $form_tugasbelajar_berkas_laporan_selesai_pendidikan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_laporan_selesai_pendidikan'] = $form_tugasbelajar_berkas_laporan_selesai_pendidikan_name_copy;
			}
		
			
			$save_form_tugasbelajar = $this->model_form_tugasbelajar->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_tugasbelajar;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Tugasbelajar	* 
	* @return JSON
	*/
	public function upload_berkas_surat_tugas_belajar_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_tugasbelajar',
		]);
	}

	/**
	* Delete Image Form Tugasbelajar	* 
	* @return JSON
	*/
	public function delete_berkas_surat_tugas_belajar_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_surat_tugas_belajar', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_tugasbelajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugasbelajar/'
        ]);
	}

	/**
	* Get Image Form Tugasbelajar	* 
	* @return JSON
	*/
	public function get_berkas_surat_tugas_belajar_file($id)
	{
		$form_tugasbelajar = $this->model_form_tugasbelajar->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_surat_tugas_belajar', 
            'table_name'        => 'form_tugasbelajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugasbelajar/',
            'delete_endpoint'   => 'administrator/form_tugasbelajar/delete_berkas_surat_tugas_belajar_file'
        ]);
	}
	
	/**
	* Upload Image Form Tugasbelajar	* 
	* @return JSON
	*/
	public function upload_berkas_laporan_selesai_pendidikan_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_tugasbelajar',
		]);
	}

	/**
	* Delete Image Form Tugasbelajar	* 
	* @return JSON
	*/
	public function delete_berkas_laporan_selesai_pendidikan_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_laporan_selesai_pendidikan', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_tugasbelajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugasbelajar/'
        ]);
	}

	/**
	* Get Image Form Tugasbelajar	* 
	* @return JSON
	*/
	public function get_berkas_laporan_selesai_pendidikan_file($id)
	{
		$form_tugasbelajar = $this->model_form_tugasbelajar->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_laporan_selesai_pendidikan', 
            'table_name'        => 'form_tugasbelajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugasbelajar/',
            'delete_endpoint'   => 'administrator/form_tugasbelajar/delete_berkas_laporan_selesai_pendidikan_file'
        ]);
	}
	
}


/* End of file form_tugasbelajar.php */
/* Location: ./application/controllers/administrator/Form Tugasbelajar.php */