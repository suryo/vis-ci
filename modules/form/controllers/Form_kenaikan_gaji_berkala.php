<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Kenaikan Gaji Berkala Controller
*| --------------------------------------------------------------------------
*| Form Kenaikan Gaji Berkala site
*|
*/
class Form_kenaikan_gaji_berkala extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_kenaikan_gaji_berkala');
	}

	/**
	* Submit Form Kenaikan Gaji Berkalas
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_surat_kenaikan_gaji_berkala', 'No. Surat Kenaikan Gaji Berkala', 'trim|required');
		$this->form_validation->set_rules('tanggal_surat_kenaikan_gaji_berkala', 'Tanggal Surat Kenaikan Gaji Berkala', 'trim|required');
		$this->form_validation->set_rules('form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name', 'Berkas Surat Kenaikan Gaji Berkala', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_uuid = $this->input->post('form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_uuid');
			$form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name = $this->input->post('form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name');
		
			$save_data = [
				'no_surat_kenaikan_gaji_berkala' => $this->input->post('no_surat_kenaikan_gaji_berkala'),
				'tanggal_surat_kenaikan_gaji_berkala' => $this->input->post('tanggal_surat_kenaikan_gaji_berkala'),
				'deskripsi_surat_kenaikan_gaji_berkala' => $this->input->post('deskripsi_surat_kenaikan_gaji_berkala'),
				'berkas_surat_kenaikan_gaji_berkala' => $this->input->post('berkas_surat_kenaikan_gaji_berkala'),
			];

			if (!is_dir(FCPATH . '/uploads/form_kenaikan_gaji_berkala/')) {
				mkdir(FCPATH . '/uploads/form_kenaikan_gaji_berkala/');
			}

			if (!empty($form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_uuid)) {
				$form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name_copy = date('YmdHis') . '-' . $form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name;

				rename(FCPATH . 'uploads/tmp/' . $form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_uuid . '/' . $form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name, 
						FCPATH . 'uploads/form_kenaikan_gaji_berkala/' . $form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name_copy);

				if (!is_file(FCPATH . '/uploads/form_kenaikan_gaji_berkala/' . $form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_surat_kenaikan_gaji_berkala'] = $form_kenaikan_gaji_berkala_berkas_surat_kenaikan_gaji_berkala_name_copy;
			}
		
			
			$save_form_kenaikan_gaji_berkala = $this->model_form_kenaikan_gaji_berkala->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_kenaikan_gaji_berkala;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Kenaikan Gaji Berkala	* 
	* @return JSON
	*/
	public function upload_berkas_surat_kenaikan_gaji_berkala_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_kenaikan_gaji_berkala',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Kenaikan Gaji Berkala	* 
	* @return JSON
	*/
	public function delete_berkas_surat_kenaikan_gaji_berkala_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_surat_kenaikan_gaji_berkala', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_kenaikan_gaji_berkala',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_kenaikan_gaji_berkala/'
        ]);
	}

	/**
	* Get Image Form Kenaikan Gaji Berkala	* 
	* @return JSON
	*/
	public function get_berkas_surat_kenaikan_gaji_berkala_file($id)
	{
		$form_kenaikan_gaji_berkala = $this->model_form_kenaikan_gaji_berkala->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_surat_kenaikan_gaji_berkala', 
            'table_name'        => 'form_kenaikan_gaji_berkala',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_kenaikan_gaji_berkala/',
            'delete_endpoint'   => 'administrator/form_kenaikan_gaji_berkala/delete_berkas_surat_kenaikan_gaji_berkala_file'
        ]);
	}
	
}


/* End of file form_kenaikan_gaji_berkala.php */
/* Location: ./application/controllers/administrator/Form Kenaikan Gaji Berkala.php */