<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Peninjauan Masa Kerja Controller
*| --------------------------------------------------------------------------
*| Form Peninjauan Masa Kerja site
*|
*/
class Form_peninjauan_masa_kerja extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_peninjauan_masa_kerja');
	}

	/**
	* show all Form Peninjauan Masa Kerjas
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_peninjauan_masa_kerja_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_peninjauan_masa_kerjas'] = $this->model_form_peninjauan_masa_kerja->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_peninjauan_masa_kerja_counts'] = $this->model_form_peninjauan_masa_kerja->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_peninjauan_masa_kerja/index/',
			'total_rows'   => $this->model_form_peninjauan_masa_kerja->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Surat Peninjauan Masa Kerja List');
		$this->render('backend/standart/administrator/form_builder/form_peninjauan_masa_kerja/form_peninjauan_masa_kerja_list', $this->data);
	}

	/**
	* Update view Form Peninjauan Masa Kerjas
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_peninjauan_masa_kerja_update');

		$this->data['form_peninjauan_masa_kerja'] = $this->model_form_peninjauan_masa_kerja->find($id);

		$this->template->title('Surat Peninjauan Masa Kerja Update');
		$this->render('backend/standart/administrator/form_builder/form_peninjauan_masa_kerja/form_peninjauan_masa_kerja_update', $this->data);
	}

	/**
	* Update Form Peninjauan Masa Kerjas
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_peninjauan_masa_kerja_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('no_surat_pmk', 'No. Surat PMK', 'trim|required');
		$this->form_validation->set_rules('tanggal_surat_pmk', 'Tanggal Surat PMK', 'trim|required');
		$this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
		$this->form_validation->set_rules('form_peninjauan_masa_kerja_berkas_surat_pmk_name', 'Berkas Surat PMK', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_peninjauan_masa_kerja_berkas_surat_pmk_uuid = $this->input->post('form_peninjauan_masa_kerja_berkas_surat_pmk_uuid');
			$form_peninjauan_masa_kerja_berkas_surat_pmk_name = $this->input->post('form_peninjauan_masa_kerja_berkas_surat_pmk_name');
		
			$save_data = [
				'no_surat_pmk' => $this->input->post('no_surat_pmk'),
				'tanggal_surat_pmk' => $this->input->post('tanggal_surat_pmk'),
				'tmt' => $this->input->post('tmt'),
				'deskripsi_surat_pmk' => $this->input->post('deskripsi_surat_pmk'),
			];

			if (!is_dir(FCPATH . '/uploads/form_peninjauan_masa_kerja/')) {
				mkdir(FCPATH . '/uploads/form_peninjauan_masa_kerja/');
			}

			if (!empty($form_peninjauan_masa_kerja_berkas_surat_pmk_uuid)) {
				$form_peninjauan_masa_kerja_berkas_surat_pmk_name_copy = date('YmdHis') . '-' . $form_peninjauan_masa_kerja_berkas_surat_pmk_name;

				rename(FCPATH . 'uploads/tmp/' . $form_peninjauan_masa_kerja_berkas_surat_pmk_uuid . '/' . $form_peninjauan_masa_kerja_berkas_surat_pmk_name, 
						FCPATH . 'uploads/form_peninjauan_masa_kerja/' . $form_peninjauan_masa_kerja_berkas_surat_pmk_name_copy);

				if (!is_file(FCPATH . '/uploads/form_peninjauan_masa_kerja/' . $form_peninjauan_masa_kerja_berkas_surat_pmk_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_surat_pmk'] = $form_peninjauan_masa_kerja_berkas_surat_pmk_name_copy;
			}
		
			
			$save_form_peninjauan_masa_kerja = $this->model_form_peninjauan_masa_kerja->change($id, $save_data);

			if ($save_form_peninjauan_masa_kerja) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_peninjauan_masa_kerja', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_peninjauan_masa_kerja');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_peninjauan_masa_kerja');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Peninjauan Masa Kerjas
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_peninjauan_masa_kerja_delete');

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
            set_message(cclang('has_been_deleted', 'Form Peninjauan Masa Kerja'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Peninjauan Masa Kerja'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Peninjauan Masa Kerjas
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_peninjauan_masa_kerja_view');

		$this->data['form_peninjauan_masa_kerja'] = $this->model_form_peninjauan_masa_kerja->find($id);

		$this->template->title('Surat Peninjauan Masa Kerja Detail');
		$this->render('backend/standart/administrator/form_builder/form_peninjauan_masa_kerja/form_peninjauan_masa_kerja_view', $this->data);
	}

	/**
	* delete Form Peninjauan Masa Kerjas
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_peninjauan_masa_kerja = $this->model_form_peninjauan_masa_kerja->find($id);

		if (!empty($form_peninjauan_masa_kerja->berkas_surat_pmk)) {
			$path = FCPATH . '/uploads/form_peninjauan_masa_kerja/' . $form_peninjauan_masa_kerja->berkas_surat_pmk;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_peninjauan_masa_kerja->remove($id);
	}
	
	/**
	* Upload Image Form Peninjauan Masa Kerja	* 
	* @return JSON
	*/
	public function upload_berkas_surat_pmk_file()
	{
		if (!$this->is_allowed('form_peninjauan_masa_kerja_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_peninjauan_masa_kerja',
		]);
	}

	/**
	* Delete Image Form Peninjauan Masa Kerja	* 
	* @return JSON
	*/
	public function delete_berkas_surat_pmk_file($uuid)
	{
		if (!$this->is_allowed('form_peninjauan_masa_kerja_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_surat_pmk', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_peninjauan_masa_kerja',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_peninjauan_masa_kerja/'
        ]);
	}

	/**
	* Get Image Form Peninjauan Masa Kerja	* 
	* @return JSON
	*/
	public function get_berkas_surat_pmk_file($id)
	{
		if (!$this->is_allowed('form_peninjauan_masa_kerja_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_peninjauan_masa_kerja = $this->model_form_peninjauan_masa_kerja->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_surat_pmk', 
            'table_name'        => 'form_peninjauan_masa_kerja',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_peninjauan_masa_kerja/',
            'delete_endpoint'   => 'administrator/form_peninjauan_masa_kerja/delete_berkas_surat_pmk_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_peninjauan_masa_kerja_export');

		$this->model_form_peninjauan_masa_kerja->export('form_peninjauan_masa_kerja', 'form_peninjauan_masa_kerja');
	}
}


/* End of file form_peninjauan_masa_kerja.php */
/* Location: ./application/controllers/administrator/Form Peninjauan Masa Kerja.php */