<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Lainnya Controller
*| --------------------------------------------------------------------------
*| Form Lainnya site
*|
*/
class Form_lainnya extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_lainnya');
	}

	/**
	* Submit Form Lainnyas
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('id_pegawai', 'Id Pegawai', 'trim|required');
		$this->form_validation->set_rules('form_lainnya_berkas_npwp_name', 'Berkas NPWP', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_ktp_name', 'Berkas KTP', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_taspen_name', 'Berkas TASPEN', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_bpjs_kesehatan_name', 'Berkas BPJS Kesehatan', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_kartu_pegawai_name', 'Berkas Kartu Pegawai', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_idcard_name', 'Berkas IDcard', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_kartu_keluarga_name', 'Berkas Kartu Keluarga', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_akta_nikah_name', 'Berkas Akta Nikah', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_akta_anak_name', 'Berkas Akta Anak', 'trim');
		
		if ($this->form_validation->run()) {
			$form_lainnya_berkas_npwp_uuid = $this->input->post('form_lainnya_berkas_npwp_uuid');
			$form_lainnya_berkas_npwp_name = $this->input->post('form_lainnya_berkas_npwp_name');
			$form_lainnya_berkas_ktp_uuid = $this->input->post('form_lainnya_berkas_ktp_uuid');
			$form_lainnya_berkas_ktp_name = $this->input->post('form_lainnya_berkas_ktp_name');
			$form_lainnya_berkas_taspen_uuid = $this->input->post('form_lainnya_berkas_taspen_uuid');
			$form_lainnya_berkas_taspen_name = $this->input->post('form_lainnya_berkas_taspen_name');
			$form_lainnya_berkas_bpjs_kesehatan_uuid = $this->input->post('form_lainnya_berkas_bpjs_kesehatan_uuid');
			$form_lainnya_berkas_bpjs_kesehatan_name = $this->input->post('form_lainnya_berkas_bpjs_kesehatan_name');
			$form_lainnya_berkas_kartu_pegawai_uuid = $this->input->post('form_lainnya_berkas_kartu_pegawai_uuid');
			$form_lainnya_berkas_kartu_pegawai_name = $this->input->post('form_lainnya_berkas_kartu_pegawai_name');
			$form_lainnya_berkas_idcard_uuid = $this->input->post('form_lainnya_berkas_idcard_uuid');
			$form_lainnya_berkas_idcard_name = $this->input->post('form_lainnya_berkas_idcard_name');
			$form_lainnya_berkas_kartu_keluarga_uuid = $this->input->post('form_lainnya_berkas_kartu_keluarga_uuid');
			$form_lainnya_berkas_kartu_keluarga_name = $this->input->post('form_lainnya_berkas_kartu_keluarga_name');
			$form_lainnya_berkas_akta_nikah_uuid = $this->input->post('form_lainnya_berkas_akta_nikah_uuid');
			$form_lainnya_berkas_akta_nikah_name = $this->input->post('form_lainnya_berkas_akta_nikah_name');
			$form_lainnya_berkas_akta_anak_uuid = $this->input->post('form_lainnya_berkas_akta_anak_uuid');
			$form_lainnya_berkas_akta_anak_name = $this->input->post('form_lainnya_berkas_akta_anak_name');
		
			$save_data = [
				'id_pegawai' => $this->input->post('id_pegawai'),
				'no_npwp' => $this->input->post('no_npwp'),
				'berkas_npwp' => $this->input->post('berkas_npwp'),
				'nik' => $this->input->post('nik'),
				'berkas_ktp' => $this->input->post('berkas_ktp'),
				'no_taspen' => $this->input->post('no_taspen'),
				'berkas_taspen' => $this->input->post('berkas_taspen'),
				'no_bpjs_kesehatan' => $this->input->post('no_bpjs_kesehatan'),
				'berkas_bpjs_kesehatan' => $this->input->post('berkas_bpjs_kesehatan'),
				'no_kartu_pegawai' => $this->input->post('no_kartu_pegawai'),
				'berkas_kartu_pegawai' => $this->input->post('berkas_kartu_pegawai'),
				'no_idcard' => $this->input->post('no_idcard'),
				'berkas_idcard' => $this->input->post('berkas_idcard'),
				'no_kartu_keluarga' => $this->input->post('no_kartu_keluarga'),
				'berkas_kartu_keluarga' => $this->input->post('berkas_kartu_keluarga'),
				'nomor_akta_nikah' => $this->input->post('nomor_akta_nikah'),
				'berkas_akta_nikah' => $this->input->post('berkas_akta_nikah'),
				'no_akta_anak' => $this->input->post('no_akta_anak'),
				'berkas_akta_anak' => $this->input->post('berkas_akta_anak'),
			];

			if (!is_dir(FCPATH . '/uploads/form_lainnya/')) {
				mkdir(FCPATH . '/uploads/form_lainnya/');
			}

			if (!empty($form_lainnya_berkas_npwp_uuid)) {
				$form_lainnya_berkas_npwp_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_npwp_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_npwp_uuid . '/' . $form_lainnya_berkas_npwp_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_npwp_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_npwp_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_npwp'] = $form_lainnya_berkas_npwp_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_ktp_uuid)) {
				$form_lainnya_berkas_ktp_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_ktp_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_ktp_uuid . '/' . $form_lainnya_berkas_ktp_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_ktp_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_ktp_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_ktp'] = $form_lainnya_berkas_ktp_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_taspen_uuid)) {
				$form_lainnya_berkas_taspen_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_taspen_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_taspen_uuid . '/' . $form_lainnya_berkas_taspen_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_taspen_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_taspen_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_taspen'] = $form_lainnya_berkas_taspen_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_bpjs_kesehatan_uuid)) {
				$form_lainnya_berkas_bpjs_kesehatan_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_bpjs_kesehatan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_bpjs_kesehatan_uuid . '/' . $form_lainnya_berkas_bpjs_kesehatan_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_bpjs_kesehatan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_bpjs_kesehatan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_bpjs_kesehatan'] = $form_lainnya_berkas_bpjs_kesehatan_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_kartu_pegawai_uuid)) {
				$form_lainnya_berkas_kartu_pegawai_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_kartu_pegawai_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_kartu_pegawai_uuid . '/' . $form_lainnya_berkas_kartu_pegawai_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_kartu_pegawai_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_kartu_pegawai_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_kartu_pegawai'] = $form_lainnya_berkas_kartu_pegawai_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_idcard_uuid)) {
				$form_lainnya_berkas_idcard_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_idcard_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_idcard_uuid . '/' . $form_lainnya_berkas_idcard_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_idcard_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_idcard_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_idcard'] = $form_lainnya_berkas_idcard_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_kartu_keluarga_uuid)) {
				$form_lainnya_berkas_kartu_keluarga_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_kartu_keluarga_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_kartu_keluarga_uuid . '/' . $form_lainnya_berkas_kartu_keluarga_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_kartu_keluarga_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_kartu_keluarga_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_kartu_keluarga'] = $form_lainnya_berkas_kartu_keluarga_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_akta_nikah_uuid)) {
				$form_lainnya_berkas_akta_nikah_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_akta_nikah_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_akta_nikah_uuid . '/' . $form_lainnya_berkas_akta_nikah_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_akta_nikah_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_akta_nikah_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_akta_nikah'] = $form_lainnya_berkas_akta_nikah_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_akta_anak_uuid)) {
				$form_lainnya_berkas_akta_anak_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_akta_anak_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_akta_anak_uuid . '/' . $form_lainnya_berkas_akta_anak_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_akta_anak_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_akta_anak_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_akta_anak'] = $form_lainnya_berkas_akta_anak_name_copy;
			}
		
			
			$save_form_lainnya = $this->model_form_lainnya->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_lainnya;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_npwp_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 500,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_npwp_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_npwp', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_npwp_file($id)
	{
		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_npwp', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_npwp_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_ktp_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 500,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_ktp_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_ktp', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_ktp_file($id)
	{
		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_ktp', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_ktp_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_taspen_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 500,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_taspen_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_taspen', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_taspen_file($id)
	{
		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_taspen', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_taspen_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_bpjs_kesehatan_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 500,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_bpjs_kesehatan_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_bpjs_kesehatan', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_bpjs_kesehatan_file($id)
	{
		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_bpjs_kesehatan', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_bpjs_kesehatan_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_kartu_pegawai_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 500,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_kartu_pegawai_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_kartu_pegawai', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_kartu_pegawai_file($id)
	{
		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_kartu_pegawai', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_kartu_pegawai_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_idcard_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_idcard_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_idcard', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_idcard_file($id)
	{
		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_idcard', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_idcard_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_kartu_keluarga_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_kartu_keluarga_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_kartu_keluarga', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_kartu_keluarga_file($id)
	{
		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_kartu_keluarga', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_kartu_keluarga_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_akta_nikah_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_akta_nikah_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_akta_nikah', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_akta_nikah_file($id)
	{
		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_akta_nikah', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_akta_nikah_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_akta_anak_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_akta_anak_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_akta_anak', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_akta_anak_file($id)
	{
		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_akta_anak', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_akta_anak_file'
        ]);
	}
	
}


/* End of file form_lainnya.php */
/* Location: ./application/controllers/administrator/Form Lainnya.php */