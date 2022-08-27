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
	* show all Form Plts
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_plt_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_plts'] = $this->model_form_plt->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_plt_counts'] = $this->model_form_plt->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_plt/index/',
			'total_rows'   => $this->model_form_plt->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('SK PLT List');
		$this->render('backend/standart/administrator/form_builder/form_plt/form_plt_list', $this->data);
	}

	/**
	* Update view Form Plts
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_plt_update');

		$this->data['form_plt'] = $this->model_form_plt->find($id);

		$this->template->title('SK PLT Update');
		$this->render('backend/standart/administrator/form_builder/form_plt/form_plt_update', $this->data);
	}

	/**
	* Update Form Plts
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_plt_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
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
		
			
			$save_form_plt = $this->model_form_plt->change($id, $save_data);

			if ($save_form_plt) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_plt', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_plt');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_plt');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Plts
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_plt_delete');

		$this->load->helper('file');

		$arr_id = $this->input->get('id');
		$remove = false;

		if (!empty($id)) {
			$remove = $this->_remove($id);
		} elseif (count($arr_id) >0) {
			foreach ($arr_id as $id) {
				$remove = $this->_remove($id);
			}
		}

		if ($remove) {
            set_message(cclang('has_been_deleted', 'Form Plt'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Plt'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Plts
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_plt_view');

		$this->data['form_plt'] = $this->model_form_plt->find($id);

		$this->template->title('SK PLT Detail');
		$this->render('backend/standart/administrator/form_builder/form_plt/form_plt_view', $this->data);
	}

	/**
	* delete Form Plts
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_plt = $this->model_form_plt->find($id);

		if (!empty($form_plt->berkas_sk_plt)) {
			$path = FCPATH . '/uploads/form_plt/' . $form_plt->berkas_sk_plt;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_plt->remove($id);
	}
	
	/**
	* Upload Image Form Plt	* 
	* @return JSON
	*/
	public function upload_berkas_sk_plt_file()
	{
		if (!$this->is_allowed('form_plt_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

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
		if (!$this->is_allowed('form_plt_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

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
		if (!$this->is_allowed('form_plt_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

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
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_plt_export');

		$this->model_form_plt->export('form_plt', 'form_plt');
	}
}


/* End of file form_plt.php */
/* Location: ./application/controllers/administrator/Form Plt.php */