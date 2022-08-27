<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Sk Jabatan Controller
*| --------------------------------------------------------------------------
*| Form Sk Jabatan site
*|
*/
class Form_sk_jabatan extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_sk_jabatan');
	}

	/**
	* show all Form Sk Jabatans
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_sk_jabatan_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_sk_jabatans'] = $this->model_form_sk_jabatan->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_sk_jabatan_counts'] = $this->model_form_sk_jabatan->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_sk_jabatan/index/',
			'total_rows'   => $this->model_form_sk_jabatan->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('SK Jabatan List');
		$this->render('backend/standart/administrator/form_builder/form_sk_jabatan/form_sk_jabatan_list', $this->data);
	}

	/**
	* Update view Form Sk Jabatans
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_sk_jabatan_update');

		$this->data['form_sk_jabatan'] = $this->model_form_sk_jabatan->find($id);

		$this->template->title('SK Jabatan Update');
		$this->render('backend/standart/administrator/form_builder/form_sk_jabatan/form_sk_jabatan_update', $this->data);
	}

	/**
	* Update Form Sk Jabatans
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_sk_jabatan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('no_sk_jabatan', 'No. SK Jabatan', 'trim|required');
		$this->form_validation->set_rules('tanggal_sk_jabatan', 'Tanggal SK Jabatan', 'trim|required');
		$this->form_validation->set_rules('jenis_jabatan', 'Jenis Jabatan', 'trim|required');
		$this->form_validation->set_rules('nama_jabatan_baru', 'Nama Jabatan Baru', 'trim|required');
		$this->form_validation->set_rules('nama_unit_kerja_baru', 'Nama Unit Kerja Baru', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_sk_jabatan_berkas_sk_jabatan_name', 'Berkas SK Jabatan', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_sk_jabatan_berkas_sk_jabatan_uuid = $this->input->post('form_sk_jabatan_berkas_sk_jabatan_uuid');
			$form_sk_jabatan_berkas_sk_jabatan_name = $this->input->post('form_sk_jabatan_berkas_sk_jabatan_name');
			$form_sk_jabatan_berkas_spp_uuid = $this->input->post('form_sk_jabatan_berkas_spp_uuid');
			$form_sk_jabatan_berkas_spp_name = $this->input->post('form_sk_jabatan_berkas_spp_name');
			$form_sk_jabatan_berkas_spmt_uuid = $this->input->post('form_sk_jabatan_berkas_spmt_uuid');
			$form_sk_jabatan_berkas_spmt_name = $this->input->post('form_sk_jabatan_berkas_spmt_name');
			$form_sk_jabatan_berkas_berita_acara_uuid = $this->input->post('form_sk_jabatan_berkas_berita_acara_uuid');
			$form_sk_jabatan_berkas_berita_acara_name = $this->input->post('form_sk_jabatan_berkas_berita_acara_name');
		
			$save_data = [
				'no_sk_jabatan' => $this->input->post('no_sk_jabatan'),
				'tanggal_sk_jabatan' => $this->input->post('tanggal_sk_jabatan'),
				'jenis_jabatan' => $this->input->post('jenis_jabatan'),
				'nama_jabatan_baru' => $this->input->post('nama_jabatan_baru'),
				'nama_unit_kerja_baru' => $this->input->post('nama_unit_kerja_baru'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_sk_jabatan' => $this->input->post('deskripsi_sk_jabatan'),
			];

			if (!is_dir(FCPATH . '/uploads/form_sk_jabatan/')) {
				mkdir(FCPATH . '/uploads/form_sk_jabatan/');
			}

			if (!empty($form_sk_jabatan_berkas_sk_jabatan_uuid)) {
				$form_sk_jabatan_berkas_sk_jabatan_name_copy = date('YmdHis') . '-' . $form_sk_jabatan_berkas_sk_jabatan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_jabatan_berkas_sk_jabatan_uuid . '/' . $form_sk_jabatan_berkas_sk_jabatan_name, 
						FCPATH . 'uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_sk_jabatan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_sk_jabatan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_sk_jabatan'] = $form_sk_jabatan_berkas_sk_jabatan_name_copy;
			}
		
			if (!empty($form_sk_jabatan_berkas_spp_uuid)) {
				$form_sk_jabatan_berkas_spp_name_copy = date('YmdHis') . '-' . $form_sk_jabatan_berkas_spp_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_jabatan_berkas_spp_uuid . '/' . $form_sk_jabatan_berkas_spp_name, 
						FCPATH . 'uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_spp_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_spp_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_spp'] = $form_sk_jabatan_berkas_spp_name_copy;
			}
		
			if (!empty($form_sk_jabatan_berkas_spmt_uuid)) {
				$form_sk_jabatan_berkas_spmt_name_copy = date('YmdHis') . '-' . $form_sk_jabatan_berkas_spmt_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_jabatan_berkas_spmt_uuid . '/' . $form_sk_jabatan_berkas_spmt_name, 
						FCPATH . 'uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_spmt_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_spmt_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_spmt'] = $form_sk_jabatan_berkas_spmt_name_copy;
			}
		
			if (!empty($form_sk_jabatan_berkas_berita_acara_uuid)) {
				$form_sk_jabatan_berkas_berita_acara_name_copy = date('YmdHis') . '-' . $form_sk_jabatan_berkas_berita_acara_name;

				rename(FCPATH . 'uploads/tmp/' . $form_sk_jabatan_berkas_berita_acara_uuid . '/' . $form_sk_jabatan_berkas_berita_acara_name, 
						FCPATH . 'uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_berita_acara_name_copy);

				if (!is_file(FCPATH . '/uploads/form_sk_jabatan/' . $form_sk_jabatan_berkas_berita_acara_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_berita_acara'] = $form_sk_jabatan_berkas_berita_acara_name_copy;
			}
		
			
			$save_form_sk_jabatan = $this->model_form_sk_jabatan->change($id, $save_data);

			if ($save_form_sk_jabatan) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_sk_jabatan', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_sk_jabatan');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_sk_jabatan');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Sk Jabatans
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_sk_jabatan_delete');

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
            set_message(cclang('has_been_deleted', 'Form Sk Jabatan'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Sk Jabatan'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Sk Jabatans
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_sk_jabatan_view');

		$this->data['form_sk_jabatan'] = $this->model_form_sk_jabatan->find($id);

		$this->template->title('SK Jabatan Detail');
		$this->render('backend/standart/administrator/form_builder/form_sk_jabatan/form_sk_jabatan_view', $this->data);
	}

	/**
	* delete Form Sk Jabatans
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_sk_jabatan = $this->model_form_sk_jabatan->find($id);

		if (!empty($form_sk_jabatan->berkas_sk_jabatan)) {
			$path = FCPATH . '/uploads/form_sk_jabatan/' . $form_sk_jabatan->berkas_sk_jabatan;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_sk_jabatan->berkas_spp)) {
			$path = FCPATH . '/uploads/form_sk_jabatan/' . $form_sk_jabatan->berkas_spp;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_sk_jabatan->berkas_spmt)) {
			$path = FCPATH . '/uploads/form_sk_jabatan/' . $form_sk_jabatan->berkas_spmt;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_sk_jabatan->berkas_berita_acara)) {
			$path = FCPATH . '/uploads/form_sk_jabatan/' . $form_sk_jabatan->berkas_berita_acara;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_sk_jabatan->remove($id);
	}
	
	/**
	* Upload Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function upload_berkas_sk_jabatan_file()
	{
		if (!$this->is_allowed('form_sk_jabatan_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_jabatan',
		]);
	}

	/**
	* Delete Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function delete_berkas_sk_jabatan_file($uuid)
	{
		if (!$this->is_allowed('form_sk_jabatan_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_sk_jabatan', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/'
        ]);
	}

	/**
	* Get Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function get_berkas_sk_jabatan_file($id)
	{
		if (!$this->is_allowed('form_sk_jabatan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_sk_jabatan = $this->model_form_sk_jabatan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_sk_jabatan', 
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/',
            'delete_endpoint'   => 'administrator/form_sk_jabatan/delete_berkas_sk_jabatan_file'
        ]);
	}
	
	/**
	* Upload Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function upload_berkas_spp_file()
	{
		if (!$this->is_allowed('form_sk_jabatan_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_jabatan',
		]);
	}

	/**
	* Delete Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function delete_berkas_spp_file($uuid)
	{
		if (!$this->is_allowed('form_sk_jabatan_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_spp', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/'
        ]);
	}

	/**
	* Get Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function get_berkas_spp_file($id)
	{
		if (!$this->is_allowed('form_sk_jabatan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_sk_jabatan = $this->model_form_sk_jabatan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_spp', 
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/',
            'delete_endpoint'   => 'administrator/form_sk_jabatan/delete_berkas_spp_file'
        ]);
	}
	
	/**
	* Upload Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function upload_berkas_spmt_file()
	{
		if (!$this->is_allowed('form_sk_jabatan_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_jabatan',
		]);
	}

	/**
	* Delete Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function delete_berkas_spmt_file($uuid)
	{
		if (!$this->is_allowed('form_sk_jabatan_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_spmt', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/'
        ]);
	}

	/**
	* Get Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function get_berkas_spmt_file($id)
	{
		if (!$this->is_allowed('form_sk_jabatan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_sk_jabatan = $this->model_form_sk_jabatan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_spmt', 
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/',
            'delete_endpoint'   => 'administrator/form_sk_jabatan/delete_berkas_spmt_file'
        ]);
	}
	
	/**
	* Upload Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function upload_berkas_berita_acara_file()
	{
		if (!$this->is_allowed('form_sk_jabatan_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_sk_jabatan',
		]);
	}

	/**
	* Delete Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function delete_berkas_berita_acara_file($uuid)
	{
		if (!$this->is_allowed('form_sk_jabatan_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_berita_acara', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/'
        ]);
	}

	/**
	* Get Image Form Sk Jabatan	* 
	* @return JSON
	*/
	public function get_berkas_berita_acara_file($id)
	{
		if (!$this->is_allowed('form_sk_jabatan_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_sk_jabatan = $this->model_form_sk_jabatan->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_berita_acara', 
            'table_name'        => 'form_sk_jabatan',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_sk_jabatan/',
            'delete_endpoint'   => 'administrator/form_sk_jabatan/delete_berkas_berita_acara_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_sk_jabatan_export');

		$this->model_form_sk_jabatan->export('form_sk_jabatan', 'form_sk_jabatan');
	}
}


/* End of file form_sk_jabatan.php */
/* Location: ./application/controllers/administrator/Form Sk Jabatan.php */