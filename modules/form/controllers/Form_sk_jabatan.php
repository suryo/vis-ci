<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Sk Jabatan Controller
*| --------------------------------------------------------------------------
*| Form Sk Jabatan site
*|
*/
class Form_sk_jabatan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_sk_jabatan');
	}

	/**
	* Submit Form Sk Jabatans
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_sk_jabatan', 'No. SK Jabatan', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_jabatan', 'Tanggal SK Jabatan', 'trim|required');
		$this->form_validation->set_rules('jenis_jabatan', 'Jenis Jabatan', 'trim|required');
		$this->form_validation->set_rules('nama_jabatan_baru', 'Nama Jabatan Baru', 'trim|required');
		$this->form_validation->set_rules('nama_unit_kerja_baru', 'Nama Unit Kerja Baru', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_sk_jabatan_berkas_sk_jabatan_name', 'Berkas SK Jabatan', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_sk_jabatan_berkas_sk_jabatan_uuid = $this->input->post('form_sk_jabatan_berkas_sk_jabatan_uuid');
			$form_sk_jabatan_berkas_sk_jabatan_name = $this->input->post('form_sk_jabatan_berkas_sk_jabatan_name');
			$form_sk_jabatan_berkas_spp_uuid = $this->input->post('form_sk_jabatan_berkas_spp_uuid');
			$form_sk_jabatan_berkas_spp_name = $this->input->post('form_sk_jabatan_berkas_spp_name');
			$form_sk_jabatan_berkas_spmt_uuid = $this->input->post('form_sk_jabatan_berkas_spmt_uuid');
			$form_sk_jabatan_berkas_spmt_name = $this->input->post('form_sk_jabatan_berkas_spmt_name');
			$form_sk_jabatan_berkas_berita_acara_uuid = $this->input->post('form_sk_jabatan_berkas_berita_acara_uuid');
			$form_sk_jabatan_berkas_berita_acara_name = $this->input->post('form_sk_jabatan_berkas_berita_acara_name');
		
			$save_data = [
				'no_sk_jabatan' => $this->input->post('no_sk_jabatan'),
				'tanggal_sk_jabatan' => $this->input->post('tanggal_sk_jabatan'),
				'jenis_jabatan' => $this->input->post('jenis_jabatan'),
				'nama_jabatan_baru' => $this->input->post('nama_jabatan_baru'),
				'nama_unit_kerja_baru' => $this->input->post('nama_unit_kerja_baru'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_sk_jabatan' => $this->input->post('deskripsi_sk_jabatan'),
				'berkas_sk_jabatan' => $this->input->post('berkas_sk_jabatan'),
				'berkas_spp' => $this->input->post('berkas_spp'),
				'berkas_spmt' => $this->input->post('berkas_spmt'),
				'berkas_berita_acara' => $this->input->post('berkas_berita_acara'),
			];

			if (!is_dir(FCPATH . '/uploads/form_sk_jabatan/')) {
				mkdir(FCPATH . '/uploads/form_sk_jabatan/');
			}

			if (!empty($form_sk_jabatan_berkas_sk_jabatan_uuid)) {
				$form_sk_jabatan_berkas_sk_jabatan_name_copy = date('YmdHis') . '-' . $form_sk_jabatan_berkas_sk_jabatan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_jabatan_berkas_sk_jabatan_uuid . '/' . $form_sk_jabatan_berkas_sk_jabatan_name, 
						FCPATH . 'uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_sk_jabatan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_sk_jabatan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_jabatan'] = $form_sk_jabatan_berkas_sk_jabatan_name_copy;
			}
		
			if (!empty($form_sk_jabatan_berkas_spp_uuid)) {
				$form_sk_jabatan_berkas_spp_name_copy = date('YmdHis') . '-' . $form_sk_jabatan_berkas_spp_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_jabatan_berkas_spp_uuid . '/' . $form_sk_jabatan_berkas_spp_name, 
						FCPATH . 'uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_spp_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_spp_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_spp'] = $form_sk_jabatan_berkas_spp_name_copy;
			}
		
			if (!empty($form_sk_jabatan_berkas_spmt_uuid)) {
				$form_sk_jabatan_berkas_spmt_name_copy = date('YmdHis') . '-' . $form_sk_jabatan_berkas_spmt_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_jabatan_berkas_spmt_uuid . '/' . $form_sk_jabatan_berkas_spmt_name, 
						FCPATH . 'uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_spmt_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_spmt_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_spmt'] = $form_sk_jabatan_berkas_spmt_name_copy;
			}
		
			if (!empty($form_sk_jabatan_berkas_berita_acara_uuid)) {
				$form_sk_jabatan_berkas_berita_acara_name_copy = date('YmdHis') . '-' . $form_sk_jabatan_berkas_berita_acara_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_jabatan_berkas_berita_acara_uuid . '/' . $form_sk_jabatan_berkas_berita_acara_name, 
						FCPATH . 'uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_berita_acara_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_berita_acara_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_berita_acara'] = $form_sk_jabatan_berkas_berita_acara_name_copy;
			}
		
			
			$save_form_sk_jabatan = $this->model_form_sk_jabatan->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_sk_jabatan;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function upload_berkas_sk_jabatan_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_jabatan',
		]);
	}

	/**
	* Delete Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function delete_berkas_sk_jabatan_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_jabatan', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/'
        ]);
	}

	/**
	* Get Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function get_berkas_sk_jabatan_file($id)
	{
		$form_sk_jabatan = $this->model_form_sk_jabatan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_jabatan', 
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/',
            'delete_endpoint'   => 'administrator/form_sk_jabatan/delete_berkas_sk_jabatan_file'
        ]);
	}
	
	/**
	* Upload Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function upload_berkas_spp_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_jabatan',
		]);
	}

	/**
	* Delete Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function delete_berkas_spp_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_spp', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/'
        ]);
	}

	/**
	* Get Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function get_berkas_spp_file($id)
	{
		$form_sk_jabatan = $this->model_form_sk_jabatan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_spp', 
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/',
            'delete_endpoint'   => 'administrator/form_sk_jabatan/delete_berkas_spp_file'
        ]);
	}
	
	/**
	* Upload Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function upload_berkas_spmt_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_jabatan',
		]);
	}

	/**
	* Delete Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function delete_berkas_spmt_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_spmt', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/'
        ]);
	}

	/**
	* Get Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function get_berkas_spmt_file($id)
	{
		$form_sk_jabatan = $this->model_form_sk_jabatan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_spmt', 
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/',
            'delete_endpoint'   => 'administrator/form_sk_jabatan/delete_berkas_spmt_file'
        ]);
	}
	
	/**
	* Upload Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function upload_berkas_berita_acara_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_jabatan',
		]);
	}

	/**
	* Delete Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function delete_berkas_berita_acara_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_berita_acara', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/'
        ]);
	}

	/**
	* Get Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function get_berkas_berita_acara_file($id)
	{
		$form_sk_jabatan = $this->model_form_sk_jabatan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_berita_acara', 
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/',
            'delete_endpoint'   => 'administrator/form_sk_jabatan/delete_berkas_berita_acara_file'
        ]);
	}
	
}


/* End of file form_sk_jabatan.php */
/* Location: ./application/controllers/administrator/Form Sk Jabatan.php */