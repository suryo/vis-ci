<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Pemberhentian Jabatan Controller
*| --------------------------------------------------------------------------
*| Form Pemberhentian Jabatan site
*|
*/
class Form_pemberhentian_jabatan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_pemberhentian_jabatan');
	}

	/**
	* Submit Form Pemberhentian Jabatans
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_sk_pemberhentian_jabatan', 'No. SK Pemberhentian Jabatan', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_pemberhentian_jabatan', 'Tanggal SK Pemberhentian Jabatan', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name', 'Berkas SK Pemberhentian Jabatan', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_uuid = $this->input->post('form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_uuid');
			$form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name = $this->input->post('form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name');
		
			$save_data = [
				'no_sk_pemberhentian_jabatan' => $this->input->post('no_sk_pemberhentian_jabatan'),
				'tanggal_sk_pemberhentian_jabatan' => $this->input->post('tanggal_sk_pemberhentian_jabatan'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_sk_pemberhentian_jabatan' => $this->input->post('deskripsi_sk_pemberhentian_jabatan'),
				'berkas_sk_pemberhentian_jabatan' => $this->input->post('berkas_sk_pemberhentian_jabatan'),
			];

			if (!is_dir(FCPATH . '/uploads/form_pemberhentian_jabatan/')) {
				mkdir(FCPATH . '/uploads/form_pemberhentian_jabatan/');
			}

			if (!empty($form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_uuid)) {
				$form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name_copy = date('YmdHis') . '-' . $form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_uuid . '/' . $form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name, 
						FCPATH . 'uploads/form_pemberhentian_jabatan/' . $form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_pemberhentian_jabatan/' . $form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_pemberhentian_jabatan'] = $form_pemberhentian_jabatan_berkas_sk_pemberhentian_jabatan_name_copy;
			}
		
			
			$save_form_pemberhentian_jabatan = $this->model_form_pemberhentian_jabatan->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_pemberhentian_jabatan;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Pemberhentian Jabatan	* 
	* @return JSON
	*/
	public function upload_berkas_sk_pemberhentian_jabatan_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_pemberhentian_jabatan',
		]);
	}

	/**
	* Delete Image Form Pemberhentian Jabatan	* 
	* @return JSON
	*/
	public function delete_berkas_sk_pemberhentian_jabatan_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_pemberhentian_jabatan', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_pemberhentian_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pemberhentian_jabatan/'
        ]);
	}

	/**
	* Get Image Form Pemberhentian Jabatan	* 
	* @return JSON
	*/
	public function get_berkas_sk_pemberhentian_jabatan_file($id)
	{
		$form_pemberhentian_jabatan = $this->model_form_pemberhentian_jabatan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_pemberhentian_jabatan', 
            'table_name'        => 'form_pemberhentian_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pemberhentian_jabatan/',
            'delete_endpoint'   => 'administrator/form_pemberhentian_jabatan/delete_berkas_sk_pemberhentian_jabatan_file'
        ]);
	}
	
}


/* End of file form_pemberhentian_jabatan.php */
/* Location: ./application/controllers/administrator/Form Pemberhentian Jabatan.php */