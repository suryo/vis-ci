<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Lainnya Controller
*| --------------------------------------------------------------------------
*| Form Lainnya site
*|
*/
class Form_lainnya extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_lainnya');
	}

	/**
	* show all Form Lainnyas
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_lainnya_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_lainnyas'] = $this->model_form_lainnya->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_lainnya_counts'] = $this->model_form_lainnya->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_lainnya/index/',
			'total_rows'   => $this->model_form_lainnya->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Lainnya List');
		$this->render('backend/standart/administrator/form_builder/form_lainnya/form_lainnya_list', $this->data);
	}

	/**
	* Update view Form Lainnyas
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_lainnya_update');

		$this->data['form_lainnya'] = $this->model_form_lainnya->find($id);

		$this->template->title('Lainnya Update');
		$this->render('backend/standart/administrator/form_builder/form_lainnya/form_lainnya_update', $this->data);
	}

	/**
	* Update Form Lainnyas
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_lainnya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('id_pegawai', 'Id Pegawai', 'trim|required');
		$this->form_validation->set_rules('form_lainnya_berkas_npwp_name', 'Berkas NPWP', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_ktp_name', 'Berkas KTP', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_taspen_name', 'Berkas TASPEN', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_bpjs_kesehatan_name', 'Berkas BPJS Kesehatan', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_kartu_pegawai_name', 'Berkas Kartu Pegawai', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_idcard_name', 'Berkas IDcard', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_kartu_keluarga_name', 'Berkas Kartu Keluarga', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_akta_nikah_name', 'Berkas Akta Nikah', 'trim');
		$this->form_validation->set_rules('form_lainnya_berkas_akta_anak_name', 'Berkas Akta Anak', 'trim');
		
		if ($this->form_validation->run()) {
			$form_lainnya_berkas_npwp_uuid = $this->input->post('form_lainnya_berkas_npwp_uuid');
			$form_lainnya_berkas_npwp_name = $this->input->post('form_lainnya_berkas_npwp_name');
			$form_lainnya_berkas_ktp_uuid = $this->input->post('form_lainnya_berkas_ktp_uuid');
			$form_lainnya_berkas_ktp_name = $this->input->post('form_lainnya_berkas_ktp_name');
			$form_lainnya_berkas_taspen_uuid = $this->input->post('form_lainnya_berkas_taspen_uuid');
			$form_lainnya_berkas_taspen_name = $this->input->post('form_lainnya_berkas_taspen_name');
			$form_lainnya_berkas_bpjs_kesehatan_uuid = $this->input->post('form_lainnya_berkas_bpjs_kesehatan_uuid');
			$form_lainnya_berkas_bpjs_kesehatan_name = $this->input->post('form_lainnya_berkas_bpjs_kesehatan_name');
			$form_lainnya_berkas_kartu_pegawai_uuid = $this->input->post('form_lainnya_berkas_kartu_pegawai_uuid');
			$form_lainnya_berkas_kartu_pegawai_name = $this->input->post('form_lainnya_berkas_kartu_pegawai_name');
			$form_lainnya_berkas_idcard_uuid = $this->input->post('form_lainnya_berkas_idcard_uuid');
			$form_lainnya_berkas_idcard_name = $this->input->post('form_lainnya_berkas_idcard_name');
			$form_lainnya_berkas_kartu_keluarga_uuid = $this->input->post('form_lainnya_berkas_kartu_keluarga_uuid');
			$form_lainnya_berkas_kartu_keluarga_name = $this->input->post('form_lainnya_berkas_kartu_keluarga_name');
			$form_lainnya_berkas_akta_nikah_uuid = $this->input->post('form_lainnya_berkas_akta_nikah_uuid');
			$form_lainnya_berkas_akta_nikah_name = $this->input->post('form_lainnya_berkas_akta_nikah_name');
			$form_lainnya_berkas_akta_anak_uuid = $this->input->post('form_lainnya_berkas_akta_anak_uuid');
			$form_lainnya_berkas_akta_anak_name = $this->input->post('form_lainnya_berkas_akta_anak_name');
		
			$save_data = [
				'id_pegawai' => $this->input->post('id_pegawai'),
				'no_npwp' => $this->input->post('no_npwp'),
				'nik' => $this->input->post('nik'),
				'no_taspen' => $this->input->post('no_taspen'),
				'no_bpjs_kesehatan' => $this->input->post('no_bpjs_kesehatan'),
				'no_kartu_pegawai' => $this->input->post('no_kartu_pegawai'),
				'no_idcard' => $this->input->post('no_idcard'),
				'no_kartu_keluarga' => $this->input->post('no_kartu_keluarga'),
				'nomor_akta_nikah' => $this->input->post('nomor_akta_nikah'),
				'no_akta_anak' => $this->input->post('no_akta_anak'),
			];

			if (!is_dir(FCPATH . '/uploads/form_lainnya/')) {
				mkdir(FCPATH . '/uploads/form_lainnya/');
			}

			if (!empty($form_lainnya_berkas_npwp_uuid)) {
				$form_lainnya_berkas_npwp_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_npwp_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_npwp_uuid . '/' . $form_lainnya_berkas_npwp_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_npwp_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_npwp_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_npwp'] = $form_lainnya_berkas_npwp_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_ktp_uuid)) {
				$form_lainnya_berkas_ktp_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_ktp_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_ktp_uuid . '/' . $form_lainnya_berkas_ktp_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_ktp_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_ktp_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_ktp'] = $form_lainnya_berkas_ktp_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_taspen_uuid)) {
				$form_lainnya_berkas_taspen_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_taspen_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_taspen_uuid . '/' . $form_lainnya_berkas_taspen_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_taspen_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_taspen_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_taspen'] = $form_lainnya_berkas_taspen_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_bpjs_kesehatan_uuid)) {
				$form_lainnya_berkas_bpjs_kesehatan_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_bpjs_kesehatan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_bpjs_kesehatan_uuid . '/' . $form_lainnya_berkas_bpjs_kesehatan_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_bpjs_kesehatan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_bpjs_kesehatan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_bpjs_kesehatan'] = $form_lainnya_berkas_bpjs_kesehatan_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_kartu_pegawai_uuid)) {
				$form_lainnya_berkas_kartu_pegawai_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_kartu_pegawai_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_kartu_pegawai_uuid . '/' . $form_lainnya_berkas_kartu_pegawai_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_kartu_pegawai_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_kartu_pegawai_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_kartu_pegawai'] = $form_lainnya_berkas_kartu_pegawai_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_idcard_uuid)) {
				$form_lainnya_berkas_idcard_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_idcard_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_idcard_uuid . '/' . $form_lainnya_berkas_idcard_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_idcard_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_idcard_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_idcard'] = $form_lainnya_berkas_idcard_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_kartu_keluarga_uuid)) {
				$form_lainnya_berkas_kartu_keluarga_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_kartu_keluarga_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_kartu_keluarga_uuid . '/' . $form_lainnya_berkas_kartu_keluarga_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_kartu_keluarga_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_kartu_keluarga_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_kartu_keluarga'] = $form_lainnya_berkas_kartu_keluarga_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_akta_nikah_uuid)) {
				$form_lainnya_berkas_akta_nikah_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_akta_nikah_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_akta_nikah_uuid . '/' . $form_lainnya_berkas_akta_nikah_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_akta_nikah_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_akta_nikah_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_akta_nikah'] = $form_lainnya_berkas_akta_nikah_name_copy;
			}
		
			if (!empty($form_lainnya_berkas_akta_anak_uuid)) {
				$form_lainnya_berkas_akta_anak_name_copy = date('YmdHis') . '-' . $form_lainnya_berkas_akta_anak_name;

				rename(FCPATH . 'uploads/tmp/' . $form_lainnya_berkas_akta_anak_uuid . '/' . $form_lainnya_berkas_akta_anak_name, 
						FCPATH . 'uploads/form_lainnya/' . $form_lainnya_berkas_akta_anak_name_copy);

				if (!is_file(FCPATH . '/uploads/form_lainnya/' . $form_lainnya_berkas_akta_anak_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_akta_anak'] = $form_lainnya_berkas_akta_anak_name_copy;
			}
		
			
			$save_form_lainnya = $this->model_form_lainnya->change($id, $save_data);

			if ($save_form_lainnya) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_lainnya', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_lainnya');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_lainnya');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Lainnyas
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_lainnya_delete');

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
            set_message(cclang('has_been_deleted', 'Form Lainnya'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Lainnya'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Lainnyas
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_lainnya_view');

		$this->data['form_lainnya'] = $this->model_form_lainnya->find($id);

		$this->template->title('Lainnya Detail');
		$this->render('backend/standart/administrator/form_builder/form_lainnya/form_lainnya_view', $this->data);
	}

	/**
	* delete Form Lainnyas
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_lainnya = $this->model_form_lainnya->find($id);

		if (!empty($form_lainnya->berkas_npwp)) {
			$path = FCPATH . '/uploads/form_lainnya/' . $form_lainnya->berkas_npwp;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_lainnya->berkas_ktp)) {
			$path = FCPATH . '/uploads/form_lainnya/' . $form_lainnya->berkas_ktp;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_lainnya->berkas_taspen)) {
			$path = FCPATH . '/uploads/form_lainnya/' . $form_lainnya->berkas_taspen;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_lainnya->berkas_bpjs_kesehatan)) {
			$path = FCPATH . '/uploads/form_lainnya/' . $form_lainnya->berkas_bpjs_kesehatan;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_lainnya->berkas_kartu_pegawai)) {
			$path = FCPATH . '/uploads/form_lainnya/' . $form_lainnya->berkas_kartu_pegawai;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_lainnya->berkas_idcard)) {
			$path = FCPATH . '/uploads/form_lainnya/' . $form_lainnya->berkas_idcard;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_lainnya->berkas_kartu_keluarga)) {
			$path = FCPATH . '/uploads/form_lainnya/' . $form_lainnya->berkas_kartu_keluarga;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_lainnya->berkas_akta_nikah)) {
			$path = FCPATH . '/uploads/form_lainnya/' . $form_lainnya->berkas_akta_nikah;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_lainnya->berkas_akta_anak)) {
			$path = FCPATH . '/uploads/form_lainnya/' . $form_lainnya->berkas_akta_anak;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_lainnya->remove($id);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_npwp_file()
	{
		if (!$this->is_allowed('form_lainnya_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 500,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_npwp_file($uuid)
	{
		if (!$this->is_allowed('form_lainnya_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_npwp', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_npwp_file($id)
	{
		if (!$this->is_allowed('form_lainnya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_npwp', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_npwp_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_ktp_file()
	{
		if (!$this->is_allowed('form_lainnya_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 500,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_ktp_file($uuid)
	{
		if (!$this->is_allowed('form_lainnya_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_ktp', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_ktp_file($id)
	{
		if (!$this->is_allowed('form_lainnya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_ktp', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_ktp_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_taspen_file()
	{
		if (!$this->is_allowed('form_lainnya_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 500,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_taspen_file($uuid)
	{
		if (!$this->is_allowed('form_lainnya_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_taspen', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_taspen_file($id)
	{
		if (!$this->is_allowed('form_lainnya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_taspen', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_taspen_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_bpjs_kesehatan_file()
	{
		if (!$this->is_allowed('form_lainnya_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 500,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_bpjs_kesehatan_file($uuid)
	{
		if (!$this->is_allowed('form_lainnya_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_bpjs_kesehatan', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_bpjs_kesehatan_file($id)
	{
		if (!$this->is_allowed('form_lainnya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_bpjs_kesehatan', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_bpjs_kesehatan_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_kartu_pegawai_file()
	{
		if (!$this->is_allowed('form_lainnya_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 500,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_kartu_pegawai_file($uuid)
	{
		if (!$this->is_allowed('form_lainnya_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_kartu_pegawai', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_kartu_pegawai_file($id)
	{
		if (!$this->is_allowed('form_lainnya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_kartu_pegawai', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_kartu_pegawai_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_idcard_file()
	{
		if (!$this->is_allowed('form_lainnya_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_idcard_file($uuid)
	{
		if (!$this->is_allowed('form_lainnya_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_idcard', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_idcard_file($id)
	{
		if (!$this->is_allowed('form_lainnya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_idcard', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_idcard_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_kartu_keluarga_file()
	{
		if (!$this->is_allowed('form_lainnya_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_kartu_keluarga_file($uuid)
	{
		if (!$this->is_allowed('form_lainnya_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_kartu_keluarga', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_kartu_keluarga_file($id)
	{
		if (!$this->is_allowed('form_lainnya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_kartu_keluarga', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_kartu_keluarga_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_akta_nikah_file()
	{
		if (!$this->is_allowed('form_lainnya_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_akta_nikah_file($uuid)
	{
		if (!$this->is_allowed('form_lainnya_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_akta_nikah', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_akta_nikah_file($id)
	{
		if (!$this->is_allowed('form_lainnya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_akta_nikah', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_akta_nikah_file'
        ]);
	}
	
	/**
	* Upload Image Form Lainnya	* 
	* @return JSON
	*/
	public function upload_berkas_akta_anak_file()
	{
		if (!$this->is_allowed('form_lainnya_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_lainnya',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Lainnya	* 
	* @return JSON
	*/
	public function delete_berkas_akta_anak_file($uuid)
	{
		if (!$this->is_allowed('form_lainnya_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_akta_anak', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/'
        ]);
	}

	/**
	* Get Image Form Lainnya	* 
	* @return JSON
	*/
	public function get_berkas_akta_anak_file($id)
	{
		if (!$this->is_allowed('form_lainnya_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_lainnya = $this->model_form_lainnya->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_akta_anak', 
            'table_name'        => 'form_lainnya',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_lainnya/',
            'delete_endpoint'   => 'administrator/form_lainnya/delete_berkas_akta_anak_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_lainnya_export');

		$this->model_form_lainnya->export('form_lainnya', 'form_lainnya');
	}
}


/* End of file form_lainnya.php */
/* Location: ./application/controllers/administrator/Form Lainnya.php */