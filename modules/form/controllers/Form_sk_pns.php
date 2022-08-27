<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Sk Pns Controller
*| --------------------------------------------------------------------------
*| Form Sk Pns site
*|
*/
class Form_sk_pns extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_sk_pns');
	}

	/**
	* Submit Form Sk Pnss
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('id_pegawai', 'Id Pegawai', 'trim|required');
		$this->form_validation->set_rules('no_sk_pns', 'No. SK PNS', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_pns', 'Tanggal SK PNS', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('instansi', 'Instansi', 'trim|required');
		$this->form_validation->set_rules('deskripsi_sk_pns', 'Deskripsi SK PNS', 'trim|required');
		$this->form_validation->set_rules('form_sk_pns_berkas_sk_pns_name', 'Berkas SK PNS', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_sk_pns_berkas_sk_pns_uuid = $this->input->post('form_sk_pns_berkas_sk_pns_uuid');
			$form_sk_pns_berkas_sk_pns_name = $this->input->post('form_sk_pns_berkas_sk_pns_name');
		
			$save_data = [
				'id_pegawai' => $this->input->post('id_pegawai'),
				'no_sk_pns' => $this->input->post('no_sk_pns'),
				'tanggal_sk_pns' => $this->input->post('tanggal_sk_pns'),
				'tmt' => $this->input->post('tmt'),
				'instansi' => $this->input->post('instansi'),
				'deskripsi_sk_pns' => $this->input->post('deskripsi_sk_pns'),
				'berkas_sk_pns' => $this->input->post('berkas_sk_pns'),
			];

			if (!is_dir(FCPATH . '/uploads/form_sk_pns/')) {
				mkdir(FCPATH . '/uploads/form_sk_pns/');
			}

			if (!empty($form_sk_pns_berkas_sk_pns_uuid)) {
				$form_sk_pns_berkas_sk_pns_name_copy = date('YmdHis') . '-' . $form_sk_pns_berkas_sk_pns_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_pns_berkas_sk_pns_uuid . '/' . $form_sk_pns_berkas_sk_pns_name, 
						FCPATH . 'uploads/form_sk_pns/' . $form_sk_pns_berkas_sk_pns_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_pns/' . $form_sk_pns_berkas_sk_pns_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_pns'] = $form_sk_pns_berkas_sk_pns_name_copy;
			}
		
			
			$save_form_sk_pns = $this->model_form_sk_pns->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_sk_pns;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Sk Pns	* 
	* @return JSON
	*/
	public function upload_berkas_sk_pns_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_pns',
		]);
	}

	/**
	* Delete Image Form Sk Pns	* 
	* @return JSON
	*/
	public function delete_berkas_sk_pns_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_pns', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_pns',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_pns/'
        ]);
	}

	/**
	* Get Image Form Sk Pns	* 
	* @return JSON
	*/
	public function get_berkas_sk_pns_file($id)
	{
		$form_sk_pns = $this->model_form_sk_pns->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_pns', 
            'table_name'        => 'form_sk_pns',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_pns/',
            'delete_endpoint'   => 'administrator/form_sk_pns/delete_berkas_sk_pns_file'
        ]);
	}
	
}


/* End of file form_sk_pns.php */
/* Location: ./application/controllers/administrator/Form Sk Pns.php */