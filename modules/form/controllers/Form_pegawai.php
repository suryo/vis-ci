<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Pegawai Controller
*| --------------------------------------------------------------------------
*| Form Pegawai site
*|
*/
class Form_pegawai extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_pegawai');
	}

	/**
	* Submit Form Pegawais
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('nama_pegawai', 'Nama Pegawai', 'trim|required');
		$this->form_validation->set_rules('nip', 'NIP', 'trim|required');
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
		$this->form_validation->set_rules('unit_kerja', 'Unit Kerja', 'trim|required');
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('nomor_telepon', 'Nomor Telepon', 'trim|required');
		$this->form_validation->set_rules('nomor_dosir', 'Nomor Dosir', 'trim|required');
		$this->form_validation->set_rules('form_pegawai_pas_foto_terbaru_name', 'Pas Foto Terbaru', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_pegawai_pas_foto_terbaru_uuid = $this->input->post('form_pegawai_pas_foto_terbaru_uuid');
			$form_pegawai_pas_foto_terbaru_name = $this->input->post('form_pegawai_pas_foto_terbaru_name');
		
			$save_data = [
				'nama_pegawai' => $this->input->post('nama_pegawai'),
				'nip' => $this->input->post('nip'),
				'jabatan' => $this->input->post('jabatan'),
				'unit_kerja' => $this->input->post('unit_kerja'),
				'tempat_lahir' => $this->input->post('tempat_lahir'),
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'email' => $this->input->post('email'),
				'nomor_telepon' => $this->input->post('nomor_telepon'),
				'nomor_dosir' => $this->input->post('nomor_dosir'),
				'pas_foto_terbaru' => $this->input->post('pas_foto_terbaru'),
			];

			if (!is_dir(FCPATH . '/uploads/form_pegawai/')) {
				mkdir(FCPATH . '/uploads/form_pegawai/');
			}

			if (!empty($form_pegawai_pas_foto_terbaru_uuid)) {
				$form_pegawai_pas_foto_terbaru_name_copy = date('YmdHis') . '-' . $form_pegawai_pas_foto_terbaru_name;

				rename(FCPATH . 'uploads/tmp/' . $form_pegawai_pas_foto_terbaru_uuid . '/' . $form_pegawai_pas_foto_terbaru_name, 
						FCPATH . 'uploads/form_pegawai/' . $form_pegawai_pas_foto_terbaru_name_copy);

				if (!is_file(FCPATH . '/uploads/form_pegawai/' . $form_pegawai_pas_foto_terbaru_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['pas_foto_terbaru'] = $form_pegawai_pas_foto_terbaru_name_copy;
			}
		
			
			$save_form_pegawai = $this->model_form_pegawai->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_pegawai;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Pegawai	* 
	* @return JSON
	*/
	public function upload_pas_foto_terbaru_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_pegawai',
		]);
	}

	/**
	* Delete Image Form Pegawai	* 
	* @return JSON
	*/
	public function delete_pas_foto_terbaru_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'pas_foto_terbaru', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_pegawai',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pegawai/'
        ]);
	}

	/**
	* Get Image Form Pegawai	* 
	* @return JSON
	*/
	public function get_pas_foto_terbaru_file($id)
	{
		$form_pegawai = $this->model_form_pegawai->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'pas_foto_terbaru', 
            'table_name'        => 'form_pegawai',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pegawai/',
            'delete_endpoint'   => 'administrator/form_pegawai/delete_pas_foto_terbaru_file'
        ]);
	}
	
}


/* End of file form_pegawai.php */
/* Location: ./application/controllers/administrator/Form Pegawai.php */