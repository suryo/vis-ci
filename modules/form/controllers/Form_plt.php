<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Plt Controller
*| --------------------------------------------------------------------------
*| Form Plt site
*|
*/
class Form_plt extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_plt');
	}

	/**
	* Submit Form Plts
	*
	*/
	public function submit()
	{
		$this->form_validation->set_rules('no_sk_plt', 'No. SK PLT', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_plt', 'Tanggal SK PLT', 'trim|required');
		$this->form_validation->set_rules('tmt_', 'TMT ', 'trim|required');
		$this->form_validation->set_rules('form_plt_berkas_sk_plt_name', 'Berkas SK PLT', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_plt_berkas_sk_plt_uuid = $this->input->post('form_plt_berkas_sk_plt_uuid');
			$form_plt_berkas_sk_plt_name = $this->input->post('form_plt_berkas_sk_plt_name');
		
			$save_data = [
				'no_sk_plt' => $this->input->post('no_sk_plt'),
				'tanggal_sk_plt' => $this->input->post('tanggal_sk_plt'),
				'tmt_' => $this->input->post('tmt_'),
				'deskripsi_sk_plt' => $this->input->post('deskripsi_sk_plt'),
				'berkas_sk_plt' => $this->input->post('berkas_sk_plt'),
			];

			if (!is_dir(FCPATH . '/uploads/form_plt/')) {
				mkdir(FCPATH . '/uploads/form_plt/');
			}

			if (!empty($form_plt_berkas_sk_plt_uuid)) {
				$form_plt_berkas_sk_plt_name_copy = date('YmdHis') . '-' . $form_plt_berkas_sk_plt_name;

				rename(FCPATH . 'uploads/tmp/' . $form_plt_berkas_sk_plt_uuid . '/' . $form_plt_berkas_sk_plt_name, 
						FCPATH . 'uploads/form_plt/' . $form_plt_berkas_sk_plt_name_copy);

				if (!is_file(FCPATH . '/uploads/form_plt/' . $form_plt_berkas_sk_plt_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_plt'] = $form_plt_berkas_sk_plt_name_copy;
			}
		
			
			$save_form_plt = $this->model_form_plt->store($save_data);

			$this->data['success'] = true;
			$this->data['id'] 	   = $save_form_plt;
			$this->data['message'] = cclang('your_data_has_been_successfully_submitted');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	/**
	* Upload Image Form Plt	* 
	* @return JSON
	*/
	public function upload_berkas_sk_plt_file()
	{
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_plt',
		]);
	}

	/**
	* Delete Image Form Plt	* 
	* @return JSON
	*/
	public function delete_berkas_sk_plt_file($uuid)
	{
		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_plt', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_plt',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_plt/'
        ]);
	}

	/**
	* Get Image Form Plt	* 
	* @return JSON
	*/
	public function get_berkas_sk_plt_file($id)
	{
		$form_plt = $this->model_form_plt->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_plt', 
            'table_name'        => 'form_plt',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_plt/',
            'delete_endpoint'   => 'administrator/form_plt/delete_berkas_sk_plt_file'
        ]);
	}
	
}


/* End of file form_plt.php */
/* Location: ./application/controllers/administrator/Form Plt.php */