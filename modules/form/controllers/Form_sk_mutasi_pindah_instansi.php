<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Sk Mutasi Pindah Instansi Controller
*| --------------------------------------------------------------------------
*| Form Sk Mutasi Pindah Instansi site
*|
*/
class Form_sk_mutasi_pindah_instansi extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_sk_mutasi_pindah_instansi');
	}

	/**
	* Submit Form Sk Mutasi Pindah Instansis
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_sk_mutasi_pindah_instansi', 'No. SK Mutasi Pindah Instansi', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_mutasi_pindah_instansi', 'Tanggal SK Mutasi Pindah Instansi', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('instansi_lama', 'Instansi Lama', 'trim|required');
		$this->form_validation->set_rules('instansi_baru', 'Instansi Baru', 'trim|required');
		$this->form_validation->set_rules('form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name', 'Berkas SK Mutasi Pindah Instansi', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_uuid = $this->input->post('form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_uuid');
			$form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name = $this->input->post('form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name');
		
			$save_data = [
				'no_sk_mutasi_pindah_instansi' => $this->input->post('no_sk_mutasi_pindah_instansi'),
				'tanggal_sk_mutasi_pindah_instansi' => $this->input->post('tanggal_sk_mutasi_pindah_instansi'),
				'tmt' => $this->input->post('tmt'),
				'instansi_lama' => $this->input->post('instansi_lama'),
				'instansi_baru' => $this->input->post('instansi_baru'),
				'deskripsi_sk_mutasi_pindah_instansi' => $this->input->post('deskripsi_sk_mutasi_pindah_instansi'),
				'berkas_sk_mutasi_pindah_instansi' => $this->input->post('berkas_sk_mutasi_pindah_instansi'),
			];

			if (!is_dir(FCPATH . '/uploads/form_sk_mutasi_pindah_instansi/')) {
				mkdir(FCPATH . '/uploads/form_sk_mutasi_pindah_instansi/');
			}

			if (!empty($form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_uuid)) {
				$form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name_copy = date('YmdHis') . '-' . $form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_uuid . '/' . $form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name, 
						FCPATH . 'uploads/form_sk_mutasi_pindah_instansi/' . $form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_mutasi_pindah_instansi/' . $form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_mutasi_pindah_instansi'] = $form_sk_mutasi_pindah_instansi_berkas_sk_mutasi_pindah_instansi_name_copy;
			}
		
			
			$save_form_sk_mutasi_pindah_instansi = $this->model_form_sk_mutasi_pindah_instansi->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_sk_mutasi_pindah_instansi;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Sk Mutasi Pindah Instansi	* 
	* @return JSON
	*/
	public function upload_berkas_sk_mutasi_pindah_instansi_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_mutasi_pindah_instansi',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Sk Mutasi Pindah Instansi	* 
	* @return JSON
	*/
	public function delete_berkas_sk_mutasi_pindah_instansi_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_mutasi_pindah_instansi', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_mutasi_pindah_instansi',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_mutasi_pindah_instansi/'
        ]);
	}

	/**
	* Get Image Form Sk Mutasi Pindah Instansi	* 
	* @return JSON
	*/
	public function get_berkas_sk_mutasi_pindah_instansi_file($id)
	{
		$form_sk_mutasi_pindah_instansi = $this->model_form_sk_mutasi_pindah_instansi->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_mutasi_pindah_instansi', 
            'table_name'        => 'form_sk_mutasi_pindah_instansi',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_mutasi_pindah_instansi/',
            'delete_endpoint'   => 'administrator/form_sk_mutasi_pindah_instansi/delete_berkas_sk_mutasi_pindah_instansi_file'
        ]);
	}
	
}


/* End of file form_sk_mutasi_pindah_instansi.php */
/* Location: ./application/controllers/administrator/Form Sk Mutasi Pindah Instansi.php */