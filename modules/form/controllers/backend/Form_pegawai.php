<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Pegawai Controller
*| --------------------------------------------------------------------------
*| Form Pegawai site
*|
*/
class Form_pegawai extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_pegawai');
	}

	/**
	* show all Form Pegawais
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_pegawai_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_pegawais'] = $this->model_form_pegawai->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_pegawai_counts'] = $this->model_form_pegawai->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_pegawai/index/',
			'total_rows'   => $this->model_form_pegawai->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Data Pegawai List');
		$this->render('backend/standart/administrator/form_builder/form_pegawai/form_pegawai_list', $this->data);
	}

	/**
	* Update view Form Pegawais
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_pegawai_update');

		$this->data['form_pegawai'] = $this->model_form_pegawai->find($id);

		$this->template->title('Data Pegawai Update');
		$this->render('backend/standart/administrator/form_builder/form_pegawai/form_pegawai_update', $this->data);
	}

	/**
	* Update Form Pegawais
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_pegawai_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('nama_pegawai', 'Nama Pegawai', 'trim|required');
		$this->form_validation->set_rules('nip', 'NIP', 'trim|required');
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
		$this->form_validation->set_rules('unit_kerja', 'Unit Kerja', 'trim|required');
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('nomor_telepon', 'Nomor Telepon', 'trim|required');
		$this->form_validation->set_rules('nomor_dosir', 'Nomor Dosir', 'trim|required');
		$this->form_validation->set_rules('form_pegawai_pas_foto_terbaru_name', 'Pas Foto Terbaru', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_pegawai_pas_foto_terbaru_uuid = $this->input->post('form_pegawai_pas_foto_terbaru_uuid');
			$form_pegawai_pas_foto_terbaru_name = $this->input->post('form_pegawai_pas_foto_terbaru_name');
		
			$save_data = [
				'nama_pegawai' => $this->input->post('nama_pegawai'),
				'nip' => $this->input->post('nip'),
				'jabatan' => $this->input->post('jabatan'),
				'unit_kerja' => $this->input->post('unit_kerja'),
				'tempat_lahir' => $this->input->post('tempat_lahir'),
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'email' => $this->input->post('email'),
				'nomor_telepon' => $this->input->post('nomor_telepon'),
				'nomor_dosir' => $this->input->post('nomor_dosir'),
			];

			if (!is_dir(FCPATH . '/uploads/form_pegawai/')) {
				mkdir(FCPATH . '/uploads/form_pegawai/');
			}

			if (!empty($form_pegawai_pas_foto_terbaru_uuid)) {
				$form_pegawai_pas_foto_terbaru_name_copy = date('YmdHis') . '-' . $form_pegawai_pas_foto_terbaru_name;

				rename(FCPATH . 'uploads/tmp/' . $form_pegawai_pas_foto_terbaru_uuid . '/' . $form_pegawai_pas_foto_terbaru_name, 
						FCPATH . 'uploads/form_pegawai/' . $form_pegawai_pas_foto_terbaru_name_copy);

				if (!is_file(FCPATH . '/uploads/form_pegawai/' . $form_pegawai_pas_foto_terbaru_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['pas_foto_terbaru'] = $form_pegawai_pas_foto_terbaru_name_copy;
			}
		
			
			$save_form_pegawai = $this->model_form_pegawai->change($id, $save_data);

			if ($save_form_pegawai) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_pegawai', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_pegawai');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_pegawai');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Pegawais
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_pegawai_delete');

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
            set_message(cclang('has_been_deleted', 'Form Pegawai'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Pegawai'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Pegawais
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_pegawai_view');

		$this->data['form_pegawai'] = $this->model_form_pegawai->find($id);

		$this->template->title('Data Pegawai Detail');
		$this->render('backend/standart/administrator/form_builder/form_pegawai/form_pegawai_view', $this->data);
	}

	/**
	* delete Form Pegawais
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_pegawai = $this->model_form_pegawai->find($id);

		if (!empty($form_pegawai->pas_foto_terbaru)) {
			$path = FCPATH . '/uploads/form_pegawai/' . $form_pegawai->pas_foto_terbaru;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_pegawai->remove($id);
	}
	
	/**
	* Upload Image Form Pegawai	* 
	* @return JSON
	*/
	public function upload_pas_foto_terbaru_file()
	{
		if (!$this->is_allowed('form_pegawai_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_pegawai',
		]);
	}

	/**
	* Delete Image Form Pegawai	* 
	* @return JSON
	*/
	public function delete_pas_foto_terbaru_file($uuid)
	{
		if (!$this->is_allowed('form_pegawai_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'pas_foto_terbaru', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_pegawai',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pegawai/'
        ]);
	}

	/**
	* Get Image Form Pegawai	* 
	* @return JSON
	*/
	public function get_pas_foto_terbaru_file($id)
	{
		if (!$this->is_allowed('form_pegawai_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_pegawai = $this->model_form_pegawai->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'pas_foto_terbaru', 
            'table_name'        => 'form_pegawai',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_pegawai/',
            'delete_endpoint'   => 'administrator/form_pegawai/delete_pas_foto_terbaru_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_pegawai_export');

		$this->model_form_pegawai->export('form_pegawai', 'form_pegawai');
	}
}


/* End of file form_pegawai.php */
/* Location: ./application/controllers/administrator/Form Pegawai.php */