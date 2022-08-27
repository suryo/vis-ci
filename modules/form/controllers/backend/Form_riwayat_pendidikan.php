<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Riwayat Pendidikan Controller
*| --------------------------------------------------------------------------
*| Form Riwayat Pendidikan site
*|
*/
class Form_riwayat_pendidikan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_riwayat_pendidikan');
	}

	/**
	* show all Form Riwayat Pendidikans
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_riwayat_pendidikan_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_riwayat_pendidikans'] = $this->model_form_riwayat_pendidikan->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_riwayat_pendidikan_counts'] = $this->model_form_riwayat_pendidikan->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_riwayat_pendidikan/index/',
			'total_rows'   => $this->model_form_riwayat_pendidikan->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Form Riwayat Pendidikan List');
		$this->render('backend/standart/administrator/form_builder/form_riwayat_pendidikan/form_riwayat_pendidikan_list', $this->data);
	}

	/**
	* Update view Form Riwayat Pendidikans
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_riwayat_pendidikan_update');

		$this->data['form_riwayat_pendidikan'] = $this->model_form_riwayat_pendidikan->find($id);

		$this->template->title('Form Riwayat Pendidikan Update');
		$this->render('backend/standart/administrator/form_builder/form_riwayat_pendidikan/form_riwayat_pendidikan_update', $this->data);
	}

	/**
	* Update Form Riwayat Pendidikans
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_riwayat_pendidikan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('tingkat_pendidikan', 'Tingkat Pendidikan', 'trim|required');
		$this->form_validation->set_rules('sekolah_perguruan_tinggi', 'Sekolah Perguruan Tinggi', 'trim|required');
		$this->form_validation->set_rules('jurusan_prodi', 'Jurusan Prodi', 'trim|required');
		$this->form_validation->set_rules('form_riwayat_pendidikan_berkas_ijazah_name', 'Berkas Ijazah', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_riwayat_pendidikan_berkas_ijazah_uuid = $this->input->post('form_riwayat_pendidikan_berkas_ijazah_uuid');
			$form_riwayat_pendidikan_berkas_ijazah_name = $this->input->post('form_riwayat_pendidikan_berkas_ijazah_name');
			$form_riwayat_pendidikan_berkas_pernyataan_dikti_uuid = $this->input->post('form_riwayat_pendidikan_berkas_pernyataan_dikti_uuid');
			$form_riwayat_pendidikan_berkas_pernyataan_dikti_name = $this->input->post('form_riwayat_pendidikan_berkas_pernyataan_dikti_name');
		
			$save_data = [
				'tingkat_pendidikan' => $this->input->post('tingkat_pendidikan'),
				'sekolah_perguruan_tinggi' => $this->input->post('sekolah_perguruan_tinggi'),
				'jurusan_prodi' => $this->input->post('jurusan_prodi'),
			];

			if (!is_dir(FCPATH . '/uploads/form_riwayat_pendidikan/')) {
				mkdir(FCPATH . '/uploads/form_riwayat_pendidikan/');
			}

			if (!empty($form_riwayat_pendidikan_berkas_ijazah_uuid)) {
				$form_riwayat_pendidikan_berkas_ijazah_name_copy = date('YmdHis') . '-' . $form_riwayat_pendidikan_berkas_ijazah_name;

				rename(FCPATH . 'uploads/tmp/' . $form_riwayat_pendidikan_berkas_ijazah_uuid . '/' . $form_riwayat_pendidikan_berkas_ijazah_name, 
						FCPATH . 'uploads/form_riwayat_pendidikan/' . $form_riwayat_pendidikan_berkas_ijazah_name_copy);

				if (!is_file(FCPATH . '/uploads/form_riwayat_pendidikan/' . $form_riwayat_pendidikan_berkas_ijazah_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_ijazah'] = $form_riwayat_pendidikan_berkas_ijazah_name_copy;
			}
		
			if (!empty($form_riwayat_pendidikan_berkas_pernyataan_dikti_uuid)) {
				$form_riwayat_pendidikan_berkas_pernyataan_dikti_name_copy = date('YmdHis') . '-' . $form_riwayat_pendidikan_berkas_pernyataan_dikti_name;

				rename(FCPATH . 'uploads/tmp/' . $form_riwayat_pendidikan_berkas_pernyataan_dikti_uuid . '/' . $form_riwayat_pendidikan_berkas_pernyataan_dikti_name, 
						FCPATH . 'uploads/form_riwayat_pendidikan/' . $form_riwayat_pendidikan_berkas_pernyataan_dikti_name_copy);

				if (!is_file(FCPATH . '/uploads/form_riwayat_pendidikan/' . $form_riwayat_pendidikan_berkas_pernyataan_dikti_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_pernyataan_dikti'] = $form_riwayat_pendidikan_berkas_pernyataan_dikti_name_copy;
			}
		
			
			$save_form_riwayat_pendidikan = $this->model_form_riwayat_pendidikan->change($id, $save_data);

			if ($save_form_riwayat_pendidikan) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_riwayat_pendidikan', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_riwayat_pendidikan');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_riwayat_pendidikan');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Riwayat Pendidikans
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_riwayat_pendidikan_delete');

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
            set_message(cclang('has_been_deleted', 'Form Riwayat Pendidikan'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Riwayat Pendidikan'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Riwayat Pendidikans
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_riwayat_pendidikan_view');

		$this->data['form_riwayat_pendidikan'] = $this->model_form_riwayat_pendidikan->find($id);

		$this->template->title('Form Riwayat Pendidikan Detail');
		$this->render('backend/standart/administrator/form_builder/form_riwayat_pendidikan/form_riwayat_pendidikan_view', $this->data);
	}

	/**
	* delete Form Riwayat Pendidikans
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_riwayat_pendidikan = $this->model_form_riwayat_pendidikan->find($id);

		if (!empty($form_riwayat_pendidikan->berkas_ijazah)) {
			$path = FCPATH . '/uploads/form_riwayat_pendidikan/' . $form_riwayat_pendidikan->berkas_ijazah;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_riwayat_pendidikan->berkas_pernyataan_dikti)) {
			$path = FCPATH . '/uploads/form_riwayat_pendidikan/' . $form_riwayat_pendidikan->berkas_pernyataan_dikti;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_riwayat_pendidikan->remove($id);
	}
	
	/**
	* Upload Image Form Riwayat Pendidikan	* 
	* @return JSON
	*/
	public function upload_berkas_ijazah_file()
	{
		if (!$this->is_allowed('form_riwayat_pendidikan_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_riwayat_pendidikan',
		]);
	}

	/**
	* Delete Image Form Riwayat Pendidikan	* 
	* @return JSON
	*/
	public function delete_berkas_ijazah_file($uuid)
	{
		if (!$this->is_allowed('form_riwayat_pendidikan_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_ijazah', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_riwayat_pendidikan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_riwayat_pendidikan/'
        ]);
	}

	/**
	* Get Image Form Riwayat Pendidikan	* 
	* @return JSON
	*/
	public function get_berkas_ijazah_file($id)
	{
		if (!$this->is_allowed('form_riwayat_pendidikan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_riwayat_pendidikan = $this->model_form_riwayat_pendidikan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_ijazah', 
            'table_name'        => 'form_riwayat_pendidikan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_riwayat_pendidikan/',
            'delete_endpoint'   => 'administrator/form_riwayat_pendidikan/delete_berkas_ijazah_file'
        ]);
	}
	
	/**
	* Upload Image Form Riwayat Pendidikan	* 
	* @return JSON
	*/
	public function upload_berkas_pernyataan_dikti_file()
	{
		if (!$this->is_allowed('form_riwayat_pendidikan_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_riwayat_pendidikan',
		]);
	}

	/**
	* Delete Image Form Riwayat Pendidikan	* 
	* @return JSON
	*/
	public function delete_berkas_pernyataan_dikti_file($uuid)
	{
		if (!$this->is_allowed('form_riwayat_pendidikan_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_pernyataan_dikti', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_riwayat_pendidikan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_riwayat_pendidikan/'
        ]);
	}

	/**
	* Get Image Form Riwayat Pendidikan	* 
	* @return JSON
	*/
	public function get_berkas_pernyataan_dikti_file($id)
	{
		if (!$this->is_allowed('form_riwayat_pendidikan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_riwayat_pendidikan = $this->model_form_riwayat_pendidikan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_pernyataan_dikti', 
            'table_name'        => 'form_riwayat_pendidikan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_riwayat_pendidikan/',
            'delete_endpoint'   => 'administrator/form_riwayat_pendidikan/delete_berkas_pernyataan_dikti_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_riwayat_pendidikan_export');

		$this->model_form_riwayat_pendidikan->export('form_riwayat_pendidikan', 'form_riwayat_pendidikan');
	}
}


/* End of file form_riwayat_pendidikan.php */
/* Location: ./application/controllers/administrator/Form Riwayat Pendidikan.php */