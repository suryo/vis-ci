<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Tugas Belajar Controller
*| --------------------------------------------------------------------------
*| Form Tugas Belajar site
*|
*/
class Form_tugas_belajar extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_tugas_belajar');
	}

	/**
	* show all Form Tugas Belajars
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_tugas_belajar_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_tugas_belajars'] = $this->model_form_tugas_belajar->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_tugas_belajar_counts'] = $this->model_form_tugas_belajar->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_tugas_belajar/index/',
			'total_rows'   => $this->model_form_tugas_belajar->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Tugas Belajar List');
		$this->render('backend/standart/administrator/form_builder/form_tugas_belajar/form_tugas_belajar_list', $this->data);
	}

	/**
	* Update view Form Tugas Belajars
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_tugas_belajar_update');

		$this->data['form_tugas_belajar'] = $this->model_form_tugas_belajar->find($id);

		$this->template->title('Tugas Belajar Update');
		$this->render('backend/standart/administrator/form_builder/form_tugas_belajar/form_tugas_belajar_update', $this->data);
	}

	/**
	* Update Form Tugas Belajars
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_tugas_belajar_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('id_pegawai', 'Id Pegawai', 'trim|required');
		$this->form_validation->set_rules('tingkat_pendidikan', 'Tingkat Pendidikan', 'trim|required');
		$this->form_validation->set_rules('sekolah_perguruan_tinggi', 'Sekolah/Perguruan Tinggi', 'trim|required');
		$this->form_validation->set_rules('form_tugas_belajar_berkas_surat_tugas_belajar_name', 'Berkas Surat Tugas Belajar', 'trim|required');
		$this->form_validation->set_rules('form_tugas_belajar_berkas_laporan_selesai_pendidikan_name', 'Berkas Laporan Selesai Pendidikan', 'trim');
		
		if ($this->form_validation->run()) {
			$form_tugas_belajar_berkas_surat_tugas_belajar_uuid = $this->input->post('form_tugas_belajar_berkas_surat_tugas_belajar_uuid');
			$form_tugas_belajar_berkas_surat_tugas_belajar_name = $this->input->post('form_tugas_belajar_berkas_surat_tugas_belajar_name');
			$form_tugas_belajar_berkas_laporan_selesai_pendidikan_uuid = $this->input->post('form_tugas_belajar_berkas_laporan_selesai_pendidikan_uuid');
			$form_tugas_belajar_berkas_laporan_selesai_pendidikan_name = $this->input->post('form_tugas_belajar_berkas_laporan_selesai_pendidikan_name');
		
			$save_data = [
				'id_pegawai' => $this->input->post('id_pegawai'),
				'tingkat_pendidikan' => $this->input->post('tingkat_pendidikan'),
				'tanggal_lulus_pendidikan' => $this->input->post('tanggal_lulus_pendidikan'),
				'no_ijazah' => $this->input->post('no_ijazah'),
				'sekolah_perguruan_tinggi' => $this->input->post('sekolah_perguruan_tinggi'),
			];

			if (!is_dir(FCPATH . '/uploads/form_tugas_belajar/')) {
				mkdir(FCPATH . '/uploads/form_tugas_belajar/');
			}

			if (!empty($form_tugas_belajar_berkas_surat_tugas_belajar_uuid)) {
				$form_tugas_belajar_berkas_surat_tugas_belajar_name_copy = date('YmdHis') . '-' . $form_tugas_belajar_berkas_surat_tugas_belajar_name;

				rename(FCPATH . 'uploads/tmp/' . $form_tugas_belajar_berkas_surat_tugas_belajar_uuid . '/' . $form_tugas_belajar_berkas_surat_tugas_belajar_name, 
						FCPATH . 'uploads/form_tugas_belajar/' . $form_tugas_belajar_berkas_surat_tugas_belajar_name_copy);

				if (!is_file(FCPATH . '/uploads/form_tugas_belajar/' . $form_tugas_belajar_berkas_surat_tugas_belajar_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_surat_tugas_belajar'] = $form_tugas_belajar_berkas_surat_tugas_belajar_name_copy;
			}
		
			if (!empty($form_tugas_belajar_berkas_laporan_selesai_pendidikan_uuid)) {
				$form_tugas_belajar_berkas_laporan_selesai_pendidikan_name_copy = date('YmdHis') . '-' . $form_tugas_belajar_berkas_laporan_selesai_pendidikan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_tugas_belajar_berkas_laporan_selesai_pendidikan_uuid . '/' . $form_tugas_belajar_berkas_laporan_selesai_pendidikan_name, 
						FCPATH . 'uploads/form_tugas_belajar/' . $form_tugas_belajar_berkas_laporan_selesai_pendidikan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_tugas_belajar/' . $form_tugas_belajar_berkas_laporan_selesai_pendidikan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_laporan_selesai_pendidikan'] = $form_tugas_belajar_berkas_laporan_selesai_pendidikan_name_copy;
			}
		
			
			$save_form_tugas_belajar = $this->model_form_tugas_belajar->change($id, $save_data);

			if ($save_form_tugas_belajar) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_tugas_belajar', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_tugas_belajar');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_tugas_belajar');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Tugas Belajars
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_tugas_belajar_delete');

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
            set_message(cclang('has_been_deleted', 'Form Tugas Belajar'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Tugas Belajar'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Tugas Belajars
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_tugas_belajar_view');

		$this->data['form_tugas_belajar'] = $this->model_form_tugas_belajar->find($id);

		$this->template->title('Tugas Belajar Detail');
		$this->render('backend/standart/administrator/form_builder/form_tugas_belajar/form_tugas_belajar_view', $this->data);
	}

	/**
	* delete Form Tugas Belajars
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_tugas_belajar = $this->model_form_tugas_belajar->find($id);

		if (!empty($form_tugas_belajar->berkas_surat_tugas_belajar)) {
			$path = FCPATH . '/uploads/form_tugas_belajar/' . $form_tugas_belajar->berkas_surat_tugas_belajar;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_tugas_belajar->berkas_laporan_selesai_pendidikan)) {
			$path = FCPATH . '/uploads/form_tugas_belajar/' . $form_tugas_belajar->berkas_laporan_selesai_pendidikan;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_tugas_belajar->remove($id);
	}
	
	/**
	* Upload Image Form Tugas Belajar	* 
	* @return JSON
	*/
	public function upload_berkas_surat_tugas_belajar_file()
	{
		if (!$this->is_allowed('form_tugas_belajar_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_tugas_belajar',
			'allowed_types' => 'pdf',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Tugas Belajar	* 
	* @return JSON
	*/
	public function delete_berkas_surat_tugas_belajar_file($uuid)
	{
		if (!$this->is_allowed('form_tugas_belajar_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_surat_tugas_belajar', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_tugas_belajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugas_belajar/'
        ]);
	}

	/**
	* Get Image Form Tugas Belajar	* 
	* @return JSON
	*/
	public function get_berkas_surat_tugas_belajar_file($id)
	{
		if (!$this->is_allowed('form_tugas_belajar_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_tugas_belajar = $this->model_form_tugas_belajar->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_surat_tugas_belajar', 
            'table_name'        => 'form_tugas_belajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugas_belajar/',
            'delete_endpoint'   => 'administrator/form_tugas_belajar/delete_berkas_surat_tugas_belajar_file'
        ]);
	}
	
	/**
	* Upload Image Form Tugas Belajar	* 
	* @return JSON
	*/
	public function upload_berkas_laporan_selesai_pendidikan_file()
	{
		if (!$this->is_allowed('form_tugas_belajar_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_tugas_belajar',
			'allowed_types' => 'pdf',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Tugas Belajar	* 
	* @return JSON
	*/
	public function delete_berkas_laporan_selesai_pendidikan_file($uuid)
	{
		if (!$this->is_allowed('form_tugas_belajar_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_laporan_selesai_pendidikan', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_tugas_belajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugas_belajar/'
        ]);
	}

	/**
	* Get Image Form Tugas Belajar	* 
	* @return JSON
	*/
	public function get_berkas_laporan_selesai_pendidikan_file($id)
	{
		if (!$this->is_allowed('form_tugas_belajar_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_tugas_belajar = $this->model_form_tugas_belajar->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_laporan_selesai_pendidikan', 
            'table_name'        => 'form_tugas_belajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugas_belajar/',
            'delete_endpoint'   => 'administrator/form_tugas_belajar/delete_berkas_laporan_selesai_pendidikan_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_tugas_belajar_export');

		$this->model_form_tugas_belajar->export('form_tugas_belajar', 'form_tugas_belajar');
	}
}


/* End of file form_tugas_belajar.php */
/* Location: ./application/controllers/administrator/Form Tugas Belajar.php */