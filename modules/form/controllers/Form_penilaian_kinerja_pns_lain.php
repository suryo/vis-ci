<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Penilaian Kinerja Pns Lain Controller
*| --------------------------------------------------------------------------
*| Form Penilaian Kinerja Pns Lain site
*|
*/
class Form_penilaian_kinerja_pns_lain extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_penilaian_kinerja_pns_lain');
	}

	/**
	* Submit Form Penilaian Kinerja Pns Lains
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('nama_berkas', 'Nama Berkas', 'trim|required');
		$this->form_validation->set_rules('form_penilaian_kinerja_pns_lain_berkas_penilaian_kinerja_pns_lain_name', 'Berkas Penilaian Kinerja PNS Lain', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_penilaian_kinerja_pns_lain_berkas_penilaian_kinerja_pns_lain_uuid = $this->input->post('form_penilaian_kinerja_pns_lain_berkas_penilaian_kinerja_pns_lain_uuid');
			$form_penilaian_kinerja_pns_lain_berkas_penilaian_kinerja_pns_lain_name = $this->input->post('form_penilaian_kinerja_pns_lain_berkas_penilaian_kinerja_pns_lain_name');
		
			$save_data = [
				'nama_berkas' => $this->input->post('nama_berkas'),
				'deskripsi_arsip' => $this->input->post('deskripsi_arsip'),
				'berkas_penilaian_kinerja_pns_lain' => $this->input->post('berkas_penilaian_kinerja_pns_lain'),
			];

			if (!is_dir(FCPATH . '/uploads/form_penilaian_kinerja_pns_lain/')) {
				mkdir(FCPATH . '/uploads/form_penilaian_kinerja_pns_lain/');
			}

			if (!empty($form_penilaian_kinerja_pns_lain_berkas_penilaian_kinerja_pns_lain_uuid)) {
				$form_penilaian_kinerja_pns_lain_berkas_penilaian_kinerja_pns_lain_name_copy = date('YmdHis') . '-' . $form_penilaian_kinerja_pns_lain_berkas_penilaian_kinerja_pns_lain_name;

				rename(FCPATH . 'uploads/tmp/' . $form_penilaian_kinerja_pns_lain_berkas_penilaian_kinerja_pns_lain_uuid . '/' . $form_penilaian_kinerja_pns_lain_berkas_penilaian_kinerja_pns_lain_name, 
						FCPATH . 'uploads/form_penilaian_kinerja_pns_lain/' . $form_penilaian_kinerja_pns_lain_berkas_penilaian_kinerja_pns_lain_name_copy);

				if (!is_file(FCPATH . '/uploads/form_penilaian_kinerja_pns_lain/' . $form_penilaian_kinerja_pns_lain_berkas_penilaian_kinerja_pns_lain_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_penilaian_kinerja_pns_lain'] = $form_penilaian_kinerja_pns_lain_berkas_penilaian_kinerja_pns_lain_name_copy;
			}
		
			
			$save_form_penilaian_kinerja_pns_lain = $this->model_form_penilaian_kinerja_pns_lain->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_penilaian_kinerja_pns_lain;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Penilaian Kinerja Pns Lain	* 
	* @return JSON
	*/
	public function upload_berkas_penilaian_kinerja_pns_lain_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_penilaian_kinerja_pns_lain',
		]);
	}

	/**
	* Delete Image Form Penilaian Kinerja Pns Lain	* 
	* @return JSON
	*/
	public function delete_berkas_penilaian_kinerja_pns_lain_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_penilaian_kinerja_pns_lain', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_penilaian_kinerja_pns_lain',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penilaian_kinerja_pns_lain/'
        ]);
	}

	/**
	* Get Image Form Penilaian Kinerja Pns Lain	* 
	* @return JSON
	*/
	public function get_berkas_penilaian_kinerja_pns_lain_file($id)
	{
		$form_penilaian_kinerja_pns_lain = $this->model_form_penilaian_kinerja_pns_lain->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_penilaian_kinerja_pns_lain', 
            'table_name'        => 'form_penilaian_kinerja_pns_lain',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penilaian_kinerja_pns_lain/',
            'delete_endpoint'   => 'administrator/form_penilaian_kinerja_pns_lain/delete_berkas_penilaian_kinerja_pns_lain_file'
        ]);
	}
	
}


/* End of file form_penilaian_kinerja_pns_lain.php */
/* Location: ./application/controllers/administrator/Form Penilaian Kinerja Pns Lain.php */