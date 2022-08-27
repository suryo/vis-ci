<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Form Penilaian Kinerja Pns Controller
*| --------------------------------------------------------------------------
*| Form Penilaian Kinerja Pns site
*|
*/
class Form_penilaian_kinerja_pns extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_form_penilaian_kinerja_pns');
	}

	/**
	* show all Form Penilaian Kinerja Pnss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('form_penilaian_kinerja_pns_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['form_penilaian_kinerja_pnss'] = $this->model_form_penilaian_kinerja_pns->get($filter, $field, $this->limit_page, $offset);
		$this->data['form_penilaian_kinerja_pns_counts'] = $this->model_form_penilaian_kinerja_pns->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/manage-form/form_penilaian_kinerja_pns/index/',
			'total_rows'   => $this->model_form_penilaian_kinerja_pns->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 5,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Penilaian Kinerja PNS List');
		$this->render('backend/standart/administrator/form_builder/form_penilaian_kinerja_pns/form_penilaian_kinerja_pns_list', $this->data);
	}

	/**
	* Update view Form Penilaian Kinerja Pnss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('form_penilaian_kinerja_pns_update');

		$this->data['form_penilaian_kinerja_pns'] = $this->model_form_penilaian_kinerja_pns->find($id);

		$this->template->title('Penilaian Kinerja PNS Update');
		$this->render('backend/standart/administrator/form_builder/form_penilaian_kinerja_pns/form_penilaian_kinerja_pns_update', $this->data);
	}

	/**
	* Update Form Penilaian Kinerja Pnss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('form_penilaian_kinerja_pns_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('periode_tanggal_mulai_penilaian_kinerja', 'Periode Tanggal Mulai Penilaian Kinerja', 'trim|required');
		$this->form_validation->set_rules('periode_tanggal_akhir_penilaian_kinerja', 'Periode Tanggal Akhir Penilaian Kinerja', 'trim|required');
		$this->form_validation->set_rules('form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name', 'Berkas Penilaian Kinerja PNS', 'trim|required');
		
		if ($this->form_validation->run()) {
			$form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_uuid = $this->input->post('form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_uuid');
			$form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name = $this->input->post('form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name');
		
			$save_data = [
				'periode_tanggal_mulai_penilaian_kinerja' => $this->input->post('periode_tanggal_mulai_penilaian_kinerja'),
				'periode_tanggal_akhir_penilaian_kinerja' => $this->input->post('periode_tanggal_akhir_penilaian_kinerja'),
			];

			if (!is_dir(FCPATH . '/uploads/form_penilaian_kinerja_pns/')) {
				mkdir(FCPATH . '/uploads/form_penilaian_kinerja_pns/');
			}

			if (!empty($form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_uuid)) {
				$form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name_copy = date('YmdHis') . '-' . $form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name;

				rename(FCPATH . 'uploads/tmp/' . $form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_uuid . '/' . $form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name, 
						FCPATH . 'uploads/form_penilaian_kinerja_pns/' . $form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name_copy);

				if (!is_file(FCPATH . '/uploads/form_penilaian_kinerja_pns/' . $form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['berkas_penilaian_kinerja_pns'] = $form_penilaian_kinerja_pns_berkas_penilaian_kinerja_pns_name_copy;
			}
		
			
			$save_form_penilaian_kinerja_pns = $this->model_form_penilaian_kinerja_pns->change($id, $save_data);

			if ($save_form_penilaian_kinerja_pns) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/form_penilaian_kinerja_pns', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/form_penilaian_kinerja_pns');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					set_message('Your data not change.', 'error');
					
            		$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/form_penilaian_kinerja_pns');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* delete Form Penilaian Kinerja Pnss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('form_penilaian_kinerja_pns_delete');

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
            set_message(cclang('has_been_deleted', 'Form Penilaian Kinerja Pns'), 'success');
        } else {
            set_message(cclang('error_delete', 'Form Penilaian Kinerja Pns'), 'error');
        }

		redirect_back();
	}

	/**
	* View view Form Penilaian Kinerja Pnss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('form_penilaian_kinerja_pns_view');

		$this->data['form_penilaian_kinerja_pns'] = $this->model_form_penilaian_kinerja_pns->find($id);

		$this->template->title('Penilaian Kinerja PNS Detail');
		$this->render('backend/standart/administrator/form_builder/form_penilaian_kinerja_pns/form_penilaian_kinerja_pns_view', $this->data);
	}

	/**
	* delete Form Penilaian Kinerja Pnss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$form_penilaian_kinerja_pns = $this->model_form_penilaian_kinerja_pns->find($id);

		if (!empty($form_penilaian_kinerja_pns->berkas_penilaian_kinerja_pns)) {
			$path = FCPATH . '/uploads/form_penilaian_kinerja_pns/' . $form_penilaian_kinerja_pns->berkas_penilaian_kinerja_pns;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}

		
		return $this->model_form_penilaian_kinerja_pns->remove($id);
	}
	
	/**
	* Upload Image Form Penilaian Kinerja Pns	* 
	* @return JSON
	*/
	public function upload_berkas_penilaian_kinerja_pns_file()
	{
		if (!$this->is_allowed('form_penilaian_kinerja_pns_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'form_penilaian_kinerja_pns',
			'max_size' 	 	=> 1000,
		]);
	}

	/**
	* Delete Image Form Penilaian Kinerja Pns	* 
	* @return JSON
	*/
	public function delete_berkas_penilaian_kinerja_pns_file($uuid)
	{
		if (!$this->is_allowed('form_penilaian_kinerja_pns_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'berkas_penilaian_kinerja_pns', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'form_penilaian_kinerja_pns',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penilaian_kinerja_pns/'
        ]);
	}

	/**
	* Get Image Form Penilaian Kinerja Pns	* 
	* @return JSON
	*/
	public function get_berkas_penilaian_kinerja_pns_file($id)
	{
		if (!$this->is_allowed('form_penilaian_kinerja_pns_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$form_penilaian_kinerja_pns = $this->model_form_penilaian_kinerja_pns->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'berkas_penilaian_kinerja_pns', 
            'table_name'        => 'form_penilaian_kinerja_pns',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/form_penilaian_kinerja_pns/',
            'delete_endpoint'   => 'administrator/form_penilaian_kinerja_pns/delete_berkas_penilaian_kinerja_pns_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('form_penilaian_kinerja_pns_export');

		$this->model_form_penilaian_kinerja_pns->export('form_penilaian_kinerja_pns', 'form_penilaian_kinerja_pns');
	}
}


/* End of file form_penilaian_kinerja_pns.php */
/* Location: ./application/controllers/administrator/Form Penilaian Kinerja Pns.php */