<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Pangkat Controller
*| --------------------------------------------------------------------------
*| Form Pangkat site
*|
*/
class Form_pangkat extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_pangkat');
	}

	/**
	* Submit Form Pangkats
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('id_pegawai', 'Id Pegawai', 'trim|required');
		$this->form_validation->set_rules('jenis_kenaikan_pangkat', 'Jenis Kenaikan Pangkat', 'trim|required');
		$this->form_validation->set_rules('no_sk_pangkat', 'No. SK Pangkat', 'trim|required');
		$this->form_validation->set_rules('_tanggal_sk_pangkat', 'Tanggal SK Pangkat', 'trim|required');
		$this->form_validation->set_rules('pangkat_golongan', 'Pangkat/Golongan', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_pangkat_berkas_sk_pangkat_name', 'Berkas SK Pangkat', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_pangkat_berkas_sk_pangkat_uuid = $this->input->post('form_pangkat_berkas_sk_pangkat_uuid');
			$form_pangkat_berkas_sk_pangkat_name = $this->input->post('form_pangkat_berkas_sk_pangkat_name');
		
			$save_data = [
				'id_pegawai' => $this->input->post('id_pegawai'),
				'jenis_kenaikan_pangkat' => $this->input->post('jenis_kenaikan_pangkat'),
				'no_sk_pangkat' => $this->input->post('no_sk_pangkat'),
				'_tanggal_sk_pangkat' => $this->input->post('_tanggal_sk_pangkat'),
				'pangkat_golongan' => $this->input->post('pangkat_golongan'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_sk_pangkat' => $this->input->post('deskripsi_sk_pangkat'),
				'berkas_sk_pangkat' => $this->input->post('berkas_sk_pangkat'),
			];

			if (!is_dir(FCPATH . '/uploads/form_pangkat/')) {
				mkdir(FCPATH . '/uploads/form_pangkat/');
			}

			if (!empty($form_pangkat_berkas_sk_pangkat_uuid)) {
				$form_pangkat_berkas_sk_pangkat_name_copy = date('YmdHis') . '-' . $form_pangkat_berkas_sk_pangkat_name;

				rename(FCPATH . 'uploads/tmp/' . $form_pangkat_berkas_sk_pangkat_uuid . '/' . $form_pangkat_berkas_sk_pangkat_name, 
						FCPATH . 'uploads/form_pangkat/' . $form_pangkat_berkas_sk_pangkat_name_copy);

				if (!is_file(FCPATH . '/uploads/form_pangkat/' . $form_pangkat_berkas_sk_pangkat_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_pangkat'] = $form_pangkat_berkas_sk_pangkat_name_copy;
			}
		
			
			$save_form_pangkat = $this->model_form_pangkat->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_pangkat;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Pangkat	* 
	* @return JSON
	*/
	public function upload_berkas_sk_pangkat_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_pangkat',
		]);
	}

	/**
	* Delete Image Form Pangkat	* 
	* @return JSON
	*/
	public function delete_berkas_sk_pangkat_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_pangkat', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_pangkat',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pangkat/'
        ]);
	}

	/**
	* Get Image Form Pangkat	* 
	* @return JSON
	*/
	public function get_berkas_sk_pangkat_file($id)
	{
		$form_pangkat = $this->model_form_pangkat->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_pangkat', 
            'table_name'        => 'form_pangkat',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pangkat/',
            'delete_endpoint'   => 'administrator/form_pangkat/delete_berkas_sk_pangkat_file'
        ]);
	}
	
}


/* End of file form_pangkat.php */
/* Location: ./application/controllers/administrator/Form Pangkat.php */