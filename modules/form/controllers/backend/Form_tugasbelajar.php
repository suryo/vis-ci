<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Tugasbelajar Controller
*| --------------------------------------------------------------------------
*| Form Tugasbelajar site
*|
*/
class Form_tugasbelajar extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_tugasbelajar');
	}

	/**
	* show all Form Tugasbelajars
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_tugasbelajar_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_tugasbelajars'] = $this->model_form_tugasbelajar->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_tugasbelajar_counts'] = $this->model_form_tugasbelajar->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_tugasbelajar/index/',
			'total_rows'   => $this->model_form_tugasbelajar->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Tugas Belajar List');
		$this->render('backend/standart/administrator/form_builder/form_tugasbelajar/form_tugasbelajar_list', $this->data);
	}

	/**
	* Update view Form Tugasbelajars
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_tugasbelajar_update');

		$this->data['form_tugasbelajar'] = $this->model_form_tugasbelajar->find($id);

		$this->template->title('Tugas Belajar Update');
		$this->render('backend/standart/administrator/form_builder/form_tugasbelajar/form_tugasbelajar_update', $this->data);
	}

	/**
	* Update Form Tugasbelajars
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_tugasbelajar_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('tingkat_pendidikan', 'Tingkat Pendidikan', 'trim|required');
		$this->form_validation->set_rules('form_tugasbelajar_berkas_surat_tugas_belajar_name', 'Berkas Surat Tugas Belajar', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_tugasbelajar_berkas_surat_tugas_belajar_uuid = $this->input->post('form_tugasbelajar_berkas_surat_tugas_belajar_uuid');
			$form_tugasbelajar_berkas_surat_tugas_belajar_name = $this->input->post('form_tugasbelajar_berkas_surat_tugas_belajar_name');
			$form_tugasbelajar_berkas_laporan_selesai_pendidikan_uuid = $this->input->post('form_tugasbelajar_berkas_laporan_selesai_pendidikan_uuid');
			$form_tugasbelajar_berkas_laporan_selesai_pendidikan_name = $this->input->post('form_tugasbelajar_berkas_laporan_selesai_pendidikan_name');
		
			$save_data = [
				'tingkat_pendidikan' => $this->input->post('tingkat_pendidikan'),
				'tanggal_lulus_pendidikan' => $this->input->post('tanggal_lulus_pendidikan'),
				'no_ijazah' => $this->input->post('no_ijazah'),
				'sekolah_perguruan_tinggi' => $this->input->post('sekolah_perguruan_tinggi'),
			];

			if (!is_dir(FCPATH . '/uploads/form_tugasbelajar/')) {
				mkdir(FCPATH . '/uploads/form_tugasbelajar/');
			}

			if (!empty($form_tugasbelajar_berkas_surat_tugas_belajar_uuid)) {
				$form_tugasbelajar_berkas_surat_tugas_belajar_name_copy = date('YmdHis') . '-' . $form_tugasbelajar_berkas_surat_tugas_belajar_name;

				rename(FCPATH . 'uploads/tmp/' . $form_tugasbelajar_berkas_surat_tugas_belajar_uuid . '/' . $form_tugasbelajar_berkas_surat_tugas_belajar_name, 
						FCPATH . 'uploads/form_tugasbelajar/' . $form_tugasbelajar_berkas_surat_tugas_belajar_name_copy);

				if (!is_file(FCPATH . '/uploads/form_tugasbelajar/' . $form_tugasbelajar_berkas_surat_tugas_belajar_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_surat_tugas_belajar'] = $form_tugasbelajar_berkas_surat_tugas_belajar_name_copy;
			}
		
			if (!empty($form_tugasbelajar_berkas_laporan_selesai_pendidikan_uuid)) {
				$form_tugasbelajar_berkas_laporan_selesai_pendidikan_name_copy = date('YmdHis') . '-' . $form_tugasbelajar_berkas_laporan_selesai_pendidikan_name;

				rename(FCPATH . 'uploads/tmp/' . $form_tugasbelajar_berkas_laporan_selesai_pendidikan_uuid . '/' . $form_tugasbelajar_berkas_laporan_selesai_pendidikan_name, 
						FCPATH . 'uploads/form_tugasbelajar/' . $form_tugasbelajar_berkas_laporan_selesai_pendidikan_name_copy);

				if (!is_file(FCPATH . '/uploads/form_tugasbelajar/' . $form_tugasbelajar_berkas_laporan_selesai_pendidikan_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_laporan_selesai_pendidikan'] = $form_tugasbelajar_berkas_laporan_selesai_pendidikan_name_copy;
			}
		
			
			$save_form_tugasbelajar = $this->model_form_tugasbelajar->change($id, $save_data);

			if ($save_form_tugasbelajar) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_tugasbelajar', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_tugasbelajar');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_tugasbelajar');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Tugasbelajars
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_tugasbelajar_delete');

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
            set_message(cclang('has_been_deleted', 'Form Tugasbelajar'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Tugasbelajar'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Tugasbelajars
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_tugasbelajar_view');

		$this->data['form_tugasbelajar'] = $this->model_form_tugasbelajar->find($id);

		$this->template->title('Tugas Belajar Detail');
		$this->render('backend/standart/administrator/form_builder/form_tugasbelajar/form_tugasbelajar_view', $this->data);
	}

	/**
	* delete Form Tugasbelajars
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_tugasbelajar = $this->model_form_tugasbelajar->find($id);

		if (!empty($form_tugasbelajar->berkas_surat_tugas_belajar)) {
			$path = FCPATH . '/uploads/form_tugasbelajar/' . $form_tugasbelajar->berkas_surat_tugas_belajar;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		if (!empty($form_tugasbelajar->berkas_laporan_selesai_pendidikan)) {
			$path = FCPATH . '/uploads/form_tugasbelajar/' . $form_tugasbelajar->berkas_laporan_selesai_pendidikan;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_tugasbelajar->remove($id);
	}
	
	/**
	* Upload Image Form Tugasbelajar	* 
	* @return JSON
	*/
	public function upload_berkas_surat_tugas_belajar_file()
	{
		if (!$this->is_allowed('form_tugasbelajar_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_tugasbelajar',
		]);
	}

	/**
	* Delete Image Form Tugasbelajar	* 
	* @return JSON
	*/
	public function delete_berkas_surat_tugas_belajar_file($uuid)
	{
		if (!$this->is_allowed('form_tugasbelajar_delete', false)) {
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
            'table_name'        => 'form_tugasbelajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugasbelajar/'
        ]);
	}

	/**
	* Get Image Form Tugasbelajar	* 
	* @return JSON
	*/
	public function get_berkas_surat_tugas_belajar_file($id)
	{
		if (!$this->is_allowed('form_tugasbelajar_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_tugasbelajar = $this->model_form_tugasbelajar->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_surat_tugas_belajar', 
            'table_name'        => 'form_tugasbelajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugasbelajar/',
            'delete_endpoint'   => 'administrator/form_tugasbelajar/delete_berkas_surat_tugas_belajar_file'
        ]);
	}
	
	/**
	* Upload Image Form Tugasbelajar	* 
	* @return JSON
	*/
	public function upload_berkas_laporan_selesai_pendidikan_file()
	{
		if (!$this->is_allowed('form_tugasbelajar_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_tugasbelajar',
		]);
	}

	/**
	* Delete Image Form Tugasbelajar	* 
	* @return JSON
	*/
	public function delete_berkas_laporan_selesai_pendidikan_file($uuid)
	{
		if (!$this->is_allowed('form_tugasbelajar_delete', false)) {
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
            'table_name'        => 'form_tugasbelajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugasbelajar/'
        ]);
	}

	/**
	* Get Image Form Tugasbelajar	* 
	* @return JSON
	*/
	public function get_berkas_laporan_selesai_pendidikan_file($id)
	{
		if (!$this->is_allowed('form_tugasbelajar_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_tugasbelajar = $this->model_form_tugasbelajar->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_laporan_selesai_pendidikan', 
            'table_name'        => 'form_tugasbelajar',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_tugasbelajar/',
            'delete_endpoint'   => 'administrator/form_tugasbelajar/delete_berkas_laporan_selesai_pendidikan_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_tugasbelajar_export');

		$this->model_form_tugasbelajar->export('form_tugasbelajar', 'form_tugasbelajar');
	}
}


/* End of file form_tugasbelajar.php */
/* Location: ./application/controllers/administrator/Form Tugasbelajar.php */