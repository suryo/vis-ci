<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Peninjauan Masa Kerja Controller
*| --------------------------------------------------------------------------
*| Form Peninjauan Masa Kerja site
*|
*/
class Form_peninjauan_masa_kerja extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_peninjauan_masa_kerja');
	}

	/**
	* Submit Form Peninjauan Masa Kerjas
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_surat_pmk', 'No. Surat PMK', 'trim|required');
		$this->form_validation->set_rules('tanggal_surat_pmk', 'Tanggal Surat PMK', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_peninjauan_masa_kerja_berkas_surat_pmk_name', 'Berkas Surat PMK', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_peninjauan_masa_kerja_berkas_surat_pmk_uuid = $this->input->post('form_peninjauan_masa_kerja_berkas_surat_pmk_uuid');
			$form_peninjauan_masa_kerja_berkas_surat_pmk_name = $this->input->post('form_peninjauan_masa_kerja_berkas_surat_pmk_name');
		
			$save_data = [
				'no_surat_pmk' => $this->input->post('no_surat_pmk'),
				'tanggal_surat_pmk' => $this->input->post('tanggal_surat_pmk'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_surat_pmk' => $this->input->post('deskripsi_surat_pmk'),
				'berkas_surat_pmk' => $this->input->post('berkas_surat_pmk'),
			];

			if (!is_dir(FCPATH . '/uploads/form_peninjauan_masa_kerja/')) {
				mkdir(FCPATH . '/uploads/form_peninjauan_masa_kerja/');
			}

			if (!empty($form_peninjauan_masa_kerja_berkas_surat_pmk_uuid)) {
				$form_peninjauan_masa_kerja_berkas_surat_pmk_name_copy = date('YmdHis') . '-' . $form_peninjauan_masa_kerja_berkas_surat_pmk_name;

				rename(FCPATH . 'uploads/tmp/' . $form_peninjauan_masa_kerja_berkas_surat_pmk_uuid . '/' . $form_peninjauan_masa_kerja_berkas_surat_pmk_name, 
						FCPATH . 'uploads/form_peninjauan_masa_kerja/' . $form_peninjauan_masa_kerja_berkas_surat_pmk_name_copy);

				if (!is_file(FCPATH . '/uploads/form_peninjauan_masa_kerja/' . $form_peninjauan_masa_kerja_berkas_surat_pmk_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_surat_pmk'] = $form_peninjauan_masa_kerja_berkas_surat_pmk_name_copy;
			}
		
			
			$save_form_peninjauan_masa_kerja = $this->model_form_peninjauan_masa_kerja->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_peninjauan_masa_kerja;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Peninjauan Masa Kerja	* 
	* @return JSON
	*/
	public function upload_berkas_surat_pmk_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_peninjauan_masa_kerja',
		]);
	}

	/**
	* Delete Image Form Peninjauan Masa Kerja	* 
	* @return JSON
	*/
	public function delete_berkas_surat_pmk_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_surat_pmk', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_peninjauan_masa_kerja',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_peninjauan_masa_kerja/'
        ]);
	}

	/**
	* Get Image Form Peninjauan Masa Kerja	* 
	* @return JSON
	*/
	public function get_berkas_surat_pmk_file($id)
	{
		$form_peninjauan_masa_kerja = $this->model_form_peninjauan_masa_kerja->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_surat_pmk', 
            'table_name'        => 'form_peninjauan_masa_kerja',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_peninjauan_masa_kerja/',
            'delete_endpoint'   => 'administrator/form_peninjauan_masa_kerja/delete_berkas_surat_pmk_file'
        ]);
	}
	
}


/* End of file form_peninjauan_masa_kerja.php */
/* Location: ./application/controllers/administrator/Form Peninjauan Masa Kerja.php */