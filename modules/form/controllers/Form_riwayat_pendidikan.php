<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Riwayat Pendidikan Controller
*| --------------------------------------------------------------------------
*| Form Riwayat Pendidikan site
*|
*/
class Form_riwayat_pendidikan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_riwayat_pendidikan');
	}

	/**
	* Submit Form Riwayat Pendidikans
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('tingkat_pendidikan', 'Tingkat Pendidikan', 'trim|required');
		$this->form_validation->set_rules('sekolah_perguruan_tinggi', 'Sekolah Perguruan Tinggi', 'trim|required');
		$this->form_validation->set_rules('jurusan_prodi', 'Jurusan Prodi', 'trim|required');
		$this->form_validation->set_rules('form_riwayat_pendidikan_berkas_ijazah_name', 'Berkas Ijazah', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_riwayat_pendidikan_berkas_ijazah_uuid = $this->input->post('form_riwayat_pendidikan_berkas_ijazah_uuid');
			$form_riwayat_pendidikan_berkas_ijazah_name = $this->input->post('form_riwayat_pendidikan_berkas_ijazah_name');
			$form_riwayat_pendidikan_berkas_pernyataan_dikti_uuid = $this->input->post('form_riwayat_pendidikan_berkas_pernyataan_dikti_uuid');
			$form_riwayat_pendidikan_berkas_pernyataan_dikti_name = $this->input->post('form_riwayat_pendidikan_berkas_pernyataan_dikti_name');
		
			$save_data = [
				'tingkat_pendidikan' => $this->input->post('tingkat_pendidikan'),
				'sekolah_perguruan_tinggi' => $this->input->post('sekolah_perguruan_tinggi'),
				'jurusan_prodi' => $this->input->post('jurusan_prodi'),
				'berkas_ijazah' => $this->input->post('berkas_ijazah'),
				'berkas_pernyataan_dikti' => $this->input->post('berkas_pernyataan_dikti'),
			];

			if (!is_dir(FCPATH . '/uploads/form_riwayat_pendidikan/')) {
				mkdir(FCPATH . '/uploads/form_riwayat_pendidikan/');
			}

			if (!empty($form_riwayat_pendidikan_berkas_ijazah_uuid)) {
				$form_riwayat_pendidikan_berkas_ijazah_name_copy = date('YmdHis') . '-' . $form_riwayat_pendidikan_berkas_ijazah_name;

				rename(FCPATH . 'uploads/tmp/' . $form_riwayat_pendidikan_berkas_ijazah_uuid . '/' . $form_riwayat_pendidikan_berkas_ijazah_name, 
						FCPATH . 'uploads/form_riwayat_pendidikan/' . $form_riwayat_pendidikan_berkas_ijazah_name_copy);

				if (!is_file(FCPATH . '/uploads/form_riwayat_pendidikan/' . $form_riwayat_pendidikan_berkas_ijazah_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_ijazah'] = $form_riwayat_pendidikan_berkas_ijazah_name_copy;
			}
		
			if (!empty($form_riwayat_pendidikan_berkas_pernyataan_dikti_uuid)) {
				$form_riwayat_pendidikan_berkas_pernyataan_dikti_name_copy = date('YmdHis') . '-' . $form_riwayat_pendidikan_berkas_pernyataan_dikti_name;

				rename(FCPATH . 'uploads/tmp/' . $form_riwayat_pendidikan_berkas_pernyataan_dikti_uuid . '/' . $form_riwayat_pendidikan_berkas_pernyataan_dikti_name, 
						FCPATH . 'uploads/form_riwayat_pendidikan/' . $form_riwayat_pendidikan_berkas_pernyataan_dikti_name_copy);

				if (!is_file(FCPATH . '/uploads/form_riwayat_pendidikan/' . $form_riwayat_pendidikan_berkas_pernyataan_dikti_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_pernyataan_dikti'] = $form_riwayat_pendidikan_berkas_pernyataan_dikti_name_copy;
			}
		
			
			$save_form_riwayat_pendidikan = $this->model_form_riwayat_pendidikan->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_riwayat_pendidikan;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Riwayat Pendidikan	* 
	* @return JSON
	*/
	public function upload_berkas_ijazah_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_riwayat_pendidikan',
		]);
	}

	/**
	* Delete Image Form Riwayat Pendidikan	* 
	* @return JSON
	*/
	public function delete_berkas_ijazah_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_ijazah', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_riwayat_pendidikan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_riwayat_pendidikan/'
        ]);
	}

	/**
	* Get Image Form Riwayat Pendidikan	* 
	* @return JSON
	*/
	public function get_berkas_ijazah_file($id)
	{
		$form_riwayat_pendidikan = $this->model_form_riwayat_pendidikan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_ijazah', 
            'table_name'        => 'form_riwayat_pendidikan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_riwayat_pendidikan/',
            'delete_endpoint'   => 'administrator/form_riwayat_pendidikan/delete_berkas_ijazah_file'
        ]);
	}
	
	/**
	* Upload Image Form Riwayat Pendidikan	* 
	* @return JSON
	*/
	public function upload_berkas_pernyataan_dikti_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_riwayat_pendidikan',
		]);
	}

	/**
	* Delete Image Form Riwayat Pendidikan	* 
	* @return JSON
	*/
	public function delete_berkas_pernyataan_dikti_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_pernyataan_dikti', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_riwayat_pendidikan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_riwayat_pendidikan/'
        ]);
	}

	/**
	* Get Image Form Riwayat Pendidikan	* 
	* @return JSON
	*/
	public function get_berkas_pernyataan_dikti_file($id)
	{
		$form_riwayat_pendidikan = $this->model_form_riwayat_pendidikan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_pernyataan_dikti', 
            'table_name'        => 'form_riwayat_pendidikan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_riwayat_pendidikan/',
            'delete_endpoint'   => 'administrator/form_riwayat_pendidikan/delete_berkas_pernyataan_dikti_file'
        ]);
	}
	
}


/* End of file form_riwayat_pendidikan.php */
/* Location: ./application/controllers/administrator/Form Riwayat Pendidikan.php */