<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Tugas Belajar Controller
*| --------------------------------------------------------------------------
*| Form Tugas Belajar site
*|
*/
class Form_tugas_belajar extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_tugas_belajar');
	}

	/**
	* Submit Form Tugas Belajars
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('id_pegawai', 'Id Pegawai', 'trim|required');
		$this->form_validation->set_rules('tingkat_pendidikan', 'Tingkat Pendidikan', 'trim|required');
		$this->form_validation->set_rules('sekolah_perguruan_tinggi', 'Sekolah/Perguruan Tinggi', 'trim|required');
		$this->form_validation->set_rules('form_tugas_belajar_berkas_surat_tugas_belajar_name', 'Berkas Surat Tugas Belajar', 'trim|required');
		$this->form_validation->set_rules('form_tugas_belajar_berkas_laporan_selesai_pendidikan_name', 'Berkas Laporan Selesai Pendidikan', 'trim');
		
		if ($this->form_validation->run()) {
			$form_tugas_belajar_berkas_surat_tugas_belajar_uuid = $this->input->post('form_tugas_belajar_berkas_surat_tugas_belajar_uuid');
			$form_tugas_belajar_berkas_surat_tugas_belajar_name = $this->input->post('form_tugas_belajar_berkas_surat_tugas_belajar_name');
			$form_tugas_belajar_berkas_laporan_selesai_pendidikan_uuid = $this->input->post('form_tugas_belajar_berkas_laporan_selesai_pendidikan_uuid');
			$form_tugas_belajar_berkas_laporan_selesai_pendidikan_name = $this->input->post('form_tugas_belajar_berkas_laporan_selesai_pendidikan_name');
		
			$save_data = [
				'id_pegawai' => $this->input->post('id_pegawai'),
				'tingkat_pendidikan' => $this->input->post('tingkat_pendidikan'),
				'tanggal_lulus_pendidikan' => $this->input->post('tanggal_lulus_pendidikan'),
				'no_ijazah' => $this->input->post('no_ijazah'),
				'sekolah_perguruan_tinggi' => $this->input->post('sekolah_perguruan_tinggi'),
				'berkas_surat_tugas_belajar' => $this->input->post('berkas_surat_tugas_belajar'),
				'berkas_laporan_selesai_pendidikan' => $this->input->post('berkas_laporan_selesai_pendidikan'),
			];

			if (!is_dir(FCPATH . '/uploads/form_tugas_belajar/')) {
				mkdir(FCPATH . '/uploads/form_tugas_belajar/');
			}

			if (!empty($form_tugas_belajar_berkas_surat_tugas_belajar_uuid)) {
				$form_tugas_belajar_berkas_surat_tugas_belajar_name_copy = date('YmdHis') . '-' . $form_tugas_belajar_berkas_surat_tugas_belajar_name;

				rename(FCPATH . 'uploads/tmp/' . $form_tugas_belajar_berkas_surat_tugas_belajar_uuid . '/' . $form_tugas_belajar_berkas_surat_tugas_belajar_name, 
						FCPATH . 'uploads/form_tugas_belajar/' . $form_tugas_belajar_berkas_surat_tugas_belajar_name_copy);

				if (!is_file(FCPATH . '/uploads/form_tugas_belajar/' . $form_tugas_belajar_berkas_surat_tugas_belajar_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_surat_tugas_belajar'] = $form_tugas_belajar_berkas_surat_tugas_belajar_name_copy;
			}
		
			if (!empty($form_tugas_belajar_berkas_laporan_selesai_pendidikan_uuid)) {
				$form_tugas_belajar_berkas_laporan_selesai_pendidikan_name_copy = date('YmdHis') . '-' . $form_tugas_belajar_berkas_laporan_selesai_pendidikan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_tugas_belajar_berkas_laporan_selesai_pendidikan_uuid . '/' . $form_tugas_belajar_berkas_laporan_selesai_pendidikan_name, 
						FCPATH . 'uploads/form_tugas_belajar/' . $form_tugas_belajar_berkas_laporan_selesai_pendidikan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_tugas_belajar/' . $form_tugas_belajar_berkas_laporan_selesai_pendidikan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_laporan_selesai_pendidikan'] = $form_tugas_belajar_berkas_laporan_selesai_pendidikan_name_copy;
			}
		
			
			$save_form_tugas_belajar = $this->model_form_tugas_belajar->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_tugas_belajar;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Tugas Belajar	* 
	* @return JSON
	*/
	public function upload_berkas_surat_tugas_belajar_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_tugas_belajar',
			'allowed_types' => 'pdf',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Tugas Belajar	* 
	* @return JSON
	*/
	public function delete_berkas_surat_tugas_belajar_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_surat_tugas_belajar', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_tugas_belajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugas_belajar/'
        ]);
	}

	/**
	* Get Image Form Tugas Belajar	* 
	* @return JSON
	*/
	public function get_berkas_surat_tugas_belajar_file($id)
	{
		$form_tugas_belajar = $this->model_form_tugas_belajar->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_surat_tugas_belajar', 
            'table_name'        => 'form_tugas_belajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugas_belajar/',
            'delete_endpoint'   => 'administrator/form_tugas_belajar/delete_berkas_surat_tugas_belajar_file'
        ]);
	}
	
	/**
	* Upload Image Form Tugas Belajar	* 
	* @return JSON
	*/
	public function upload_berkas_laporan_selesai_pendidikan_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_tugas_belajar',
			'allowed_types' => 'pdf',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Tugas Belajar	* 
	* @return JSON
	*/
	public function delete_berkas_laporan_selesai_pendidikan_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_laporan_selesai_pendidikan', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_tugas_belajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugas_belajar/'
        ]);
	}

	/**
	* Get Image Form Tugas Belajar	* 
	* @return JSON
	*/
	public function get_berkas_laporan_selesai_pendidikan_file($id)
	{
		$form_tugas_belajar = $this->model_form_tugas_belajar->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_laporan_selesai_pendidikan', 
            'table_name'        => 'form_tugas_belajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugas_belajar/',
            'delete_endpoint'   => 'administrator/form_tugas_belajar/delete_berkas_laporan_selesai_pendidikan_file'
        ]);
	}
	
}


/* End of file form_tugas_belajar.php */
/* Location: ./application/controllers/administrator/Form Tugas Belajar.php */