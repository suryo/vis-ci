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
	* show all Form Pangkats
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_pangkat_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_pangkats'] = $this->model_form_pangkat->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_pangkat_counts'] = $this->model_form_pangkat->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_pangkat/index/',
			'total_rows'   => $this->model_form_pangkat->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('SK Pangkat List');
		$this->render('backend/standart/administrator/form_builder/form_pangkat/form_pangkat_list', $this->data);
	}

	/**
	* Update view Form Pangkats
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_pangkat_update');

		$this->data['form_pangkat'] = $this->model_form_pangkat->find($id);

		$this->template->title('SK Pangkat Update');
		$this->render('backend/standart/administrator/form_builder/form_pangkat/form_pangkat_update', $this->data);
	}

	/**
	* Update Form Pangkats
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_pangkat_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
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
		
			
			$save_form_pangkat = $this->model_form_pangkat->change($id, $save_data);

			if ($save_form_pangkat) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_pangkat', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_pangkat');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_pangkat');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Pangkats
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_pangkat_delete');

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
            set_message(cclang('has_been_deleted', 'Form Pangkat'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Pangkat'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Pangkats
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_pangkat_view');

		$this->data['form_pangkat'] = $this->model_form_pangkat->find($id);

		$this->template->title('SK Pangkat Detail');
		$this->render('backend/standart/administrator/form_builder/form_pangkat/form_pangkat_view', $this->data);
	}

	/**
	* delete Form Pangkats
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_pangkat = $this->model_form_pangkat->find($id);

		if (!empty($form_pangkat->berkas_sk_pangkat)) {
			$path = FCPATH . '/uploads/form_pangkat/' . $form_pangkat->berkas_sk_pangkat;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_pangkat->remove($id);
	}
	
	/**
	* Upload Image Form Pangkat	* 
	* @return JSON
	*/
	public function upload_berkas_sk_pangkat_file()
	{
		if (!$this->is_allowed('form_pangkat_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

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
		if (!$this->is_allowed('form_pangkat_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

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
		if (!$this->is_allowed('form_pangkat_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

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
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_pangkat_export');

		$this->model_form_pangkat->export('form_pangkat', 'form_pangkat');
	}
}


/* End of file form_pangkat.php */
/* Location: ./application/controllers/administrator/Form Pangkat.php */