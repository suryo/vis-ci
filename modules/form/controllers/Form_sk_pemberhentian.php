<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Sk Pemberhentian Controller
*| --------------------------------------------------------------------------
*| Form Sk Pemberhentian site
*|
*/
class Form_sk_pemberhentian extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_sk_pemberhentian');
	}

	/**
	* Submit Form Sk Pemberhentians
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_sk_pemberhentian', 'No. Sk Pemberhentian', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_pemberhentian', 'Tanggal SK Pemberhentian', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_sk_pemberhentian_berkas_sk_pemberhentian_name', 'Berkas SK Pemberhentian', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_sk_pemberhentian_berkas_sk_pemberhentian_uuid = $this->input->post('form_sk_pemberhentian_berkas_sk_pemberhentian_uuid');
			$form_sk_pemberhentian_berkas_sk_pemberhentian_name = $this->input->post('form_sk_pemberhentian_berkas_sk_pemberhentian_name');
		
			$save_data = [
				'no_sk_pemberhentian' => $this->input->post('no_sk_pemberhentian'),
				'tanggal_sk_pemberhentian' => $this->input->post('tanggal_sk_pemberhentian'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_sk_pemberhentian' => $this->input->post('deskripsi_sk_pemberhentian'),
				'berkas_sk_pemberhentian' => $this->input->post('berkas_sk_pemberhentian'),
			];

			if (!is_dir(FCPATH . '/uploads/form_sk_pemberhentian/')) {
				mkdir(FCPATH . '/uploads/form_sk_pemberhentian/');
			}

			if (!empty($form_sk_pemberhentian_berkas_sk_pemberhentian_uuid)) {
				$form_sk_pemberhentian_berkas_sk_pemberhentian_name_copy = date('YmdHis') . '-' . $form_sk_pemberhentian_berkas_sk_pemberhentian_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_pemberhentian_berkas_sk_pemberhentian_uuid . '/' . $form_sk_pemberhentian_berkas_sk_pemberhentian_name, 
						FCPATH . 'uploads/form_sk_pemberhentian/' . $form_sk_pemberhentian_berkas_sk_pemberhentian_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_pemberhentian/' . $form_sk_pemberhentian_berkas_sk_pemberhentian_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_pemberhentian'] = $form_sk_pemberhentian_berkas_sk_pemberhentian_name_copy;
			}
		
			
			$save_form_sk_pemberhentian = $this->model_form_sk_pemberhentian->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_sk_pemberhentian;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Sk Pemberhentian	* 
	* @return JSON
	*/
	public function upload_berkas_sk_pemberhentian_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_pemberhentian',
		]);
	}

	/**
	* Delete Image Form Sk Pemberhentian	* 
	* @return JSON
	*/
	public function delete_berkas_sk_pemberhentian_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_pemberhentian', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_pemberhentian',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_pemberhentian/'
        ]);
	}

	/**
	* Get Image Form Sk Pemberhentian	* 
	* @return JSON
	*/
	public function get_berkas_sk_pemberhentian_file($id)
	{
		$form_sk_pemberhentian = $this->model_form_sk_pemberhentian->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_pemberhentian', 
            'table_name'        => 'form_sk_pemberhentian',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_pemberhentian/',
            'delete_endpoint'   => 'administrator/form_sk_pemberhentian/delete_berkas_sk_pemberhentian_file'
        ]);
	}
	
}


/* End of file form_sk_pemberhentian.php */
/* Location: ./application/controllers/administrator/Form Sk Pemberhentian.php */