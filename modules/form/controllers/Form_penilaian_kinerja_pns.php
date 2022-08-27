<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Penilaian Kinerja Pns Controller
*| --------------------------------------------------------------------------
*| Form Penilaian Kinerja Pns site
*|
*/
class Form_penilaian_kinerja_pns extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_penilaian_kinerja_pns');
	}

	/**
	* Submit Form Penilaian Kinerja Pnss
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('periode_tanggal_mulai_penilaian_kinerja', 'Periode Tanggal Mulai Penilaian Kinerja', 'trim|required');
		$this->form_validation->set_rules('periode_tanggal_akhir_penilaian_kinerja', 'Periode Tanggal Akhir Penilaian Kinerja', 'trim|required');
		$this->form_validation->set_rules('form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name', 'Berkas Penilaian Kinerja PNS', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_uuid = $this->input->post('form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_uuid');
			$form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name = $this->input->post('form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name');
		
			$save_data = [
				'periode_tanggal_mulai_penilaian_kinerja' => $this->input->post('periode_tanggal_mulai_penilaian_kinerja'),
				'periode_tanggal_akhir_penilaian_kinerja' => $this->input->post('periode_tanggal_akhir_penilaian_kinerja'),
				'berkas_penilaian_kinerja_pns' => $this->input->post('berkas_penilaian_kinerja_pns'),
			];

			if (!is_dir(FCPATH . '/uploads/form_penilaian_kinerja_pns/')) {
				mkdir(FCPATH . '/uploads/form_penilaian_kinerja_pns/');
			}

			if (!empty($form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_uuid)) {
				$form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name_copy = date('YmdHis') . '-' . $form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name;

				rename(FCPATH . 'uploads/tmp/' . $form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_uuid . '/' . $form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name, 
						FCPATH . 'uploads/form_penilaian_kinerja_pns/' . $form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name_copy);

				if (!is_file(FCPATH . '/uploads/form_penilaian_kinerja_pns/' . $form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_penilaian_kinerja_pns'] = $form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name_copy;
			}
		
			
			$save_form_penilaian_kinerja_pns = $this->model_form_penilaian_kinerja_pns->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_penilaian_kinerja_pns;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Penilaian Kinerja Pns	* 
	* @return JSON
	*/
	public function upload_berkas_penilaian_kinerja_pns_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_penilaian_kinerja_pns',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Penilaian Kinerja Pns	* 
	* @return JSON
	*/
	public function delete_berkas_penilaian_kinerja_pns_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_penilaian_kinerja_pns', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_penilaian_kinerja_pns',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penilaian_kinerja_pns/'
        ]);
	}

	/**
	* Get Image Form Penilaian Kinerja Pns	* 
	* @return JSON
	*/
	public function get_berkas_penilaian_kinerja_pns_file($id)
	{
		$form_penilaian_kinerja_pns = $this->model_form_penilaian_kinerja_pns->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_penilaian_kinerja_pns', 
            'table_name'        => 'form_penilaian_kinerja_pns',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penilaian_kinerja_pns/',
            'delete_endpoint'   => 'administrator/form_penilaian_kinerja_pns/delete_berkas_penilaian_kinerja_pns_file'
        ]);
	}
	
}


/* End of file form_penilaian_kinerja_pns.php */
/* Location: ./application/controllers/administrator/Form Penilaian Kinerja Pns.php */