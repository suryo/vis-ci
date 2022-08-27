<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Vis Data Penduduks Controller
*| --------------------------------------------------------------------------
*| Vis Data Penduduks site
*|
*/
class Vis_data_penduduks extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_vis_data_penduduks');
		$this->load->model('group/model_group');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* show all Vis Data Pendudukss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('vis_data_penduduks_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['vis_data_pendudukss'] = $this->model_vis_data_penduduks->get($filter, $field, $this->limit_page, $offset);
		$this->data['vis_data_penduduks_counts'] = $this->model_vis_data_penduduks->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/vis_data_penduduks/index/',
			'total_rows'   => $this->data['vis_data_penduduks_counts'],
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Vis Data Penduduks List');
		$this->render('backend/standart/administrator/vis_data_penduduks/vis_data_penduduks_list', $this->data);
	}
	
	/**
	* Add new vis_data_pendudukss
	*
	*/
	public function add()
	{
		$this->is_allowed('vis_data_penduduks_add');

		$this->template->title('Vis Data Penduduks New');
		$this->render('backend/standart/administrator/vis_data_penduduks/vis_data_penduduks_add', $this->data);
	}

	/**
	* Add New Vis Data Pendudukss
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('vis_data_penduduks_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('jk', 'Jenis Kelamin', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('nik', 'NIK', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
		

		$this->form_validation->set_rules('agama', 'Agama', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('status_perkawinan', 'Status Perkawinan', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('kewarganegaraan', 'Kewarganegaraan', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('id_provinsi', 'Provinsi', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('id_kabupaten', 'Kabupaten', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('id_kecamatan', 'Kecamatan', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('id_desa', 'Desa', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('id_dusun', 'Dusun', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('id_rw', 'RW', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('id_rt', 'RT', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('telp', 'Telp 1', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('telp2', 'Telp 2', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('vis_data_penduduks_file_name', 'File', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('id_kk', 'No KK', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('created_at', 'Created At', 'trim|required');
		

		$this->form_validation->set_rules('updated_at', 'Updated At', 'trim|required');
		

		

		if ($this->form_validation->run()) {
			$vis_data_penduduks_file_uuid = $this->input->post('vis_data_penduduks_file_uuid');
			$vis_data_penduduks_file_name = $this->input->post('vis_data_penduduks_file_name');
		
			$save_data = [
				'nama' => $this->input->post('nama'),
				'jk' => $this->input->post('jk'),
				'nik' => $this->input->post('nik'),
				'tempat_lahir' => $this->input->post('tempat_lahir'),
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'agama' => $this->input->post('agama'),
				'status_perkawinan' => $this->input->post('status_perkawinan'),
				'kewarganegaraan' => $this->input->post('kewarganegaraan'),
				'pekerjaan' => $this->input->post('pekerjaan'),
				'id_provinsi' => $this->input->post('id_provinsi'),
				'id_kabupaten' => $this->input->post('id_kabupaten'),
				'id_kecamatan' => $this->input->post('id_kecamatan'),
				'id_desa' => $this->input->post('id_desa'),
				'id_dusun' => $this->input->post('id_dusun'),
				'id_rw' => $this->input->post('id_rw'),
				'id_rt' => $this->input->post('id_rt'),
				'telp' => $this->input->post('telp'),
				'telp2' => $this->input->post('telp2'),
				'id_kk' => $this->input->post('id_kk'),
				'created_at' => $this->input->post('created_at'),
				'updated_at' => $this->input->post('updated_at'),
			];

			
			



			
			if (!is_dir(FCPATH . '/uploads/vis_data_penduduks/')) {
				mkdir(FCPATH . '/uploads/vis_data_penduduks/');
			}

			if (!empty($vis_data_penduduks_file_name)) {
				$vis_data_penduduks_file_name_copy = date('YmdHis') . '-' . $vis_data_penduduks_file_name;

				rename(FCPATH . 'uploads/tmp/' . $vis_data_penduduks_file_uuid . '/' . $vis_data_penduduks_file_name, 
						FCPATH . 'uploads/vis_data_penduduks/' . $vis_data_penduduks_file_name_copy);

				if (!is_file(FCPATH . '/uploads/vis_data_penduduks/' . $vis_data_penduduks_file_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['file'] = $vis_data_penduduks_file_name_copy;
			}
		
			
			$save_vis_data_penduduks = $id = $this->model_vis_data_penduduks->store($save_data);
            

			if ($save_vis_data_penduduks) {
				
				
					
				
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_vis_data_penduduks;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/vis_data_penduduks/edit/' . $save_vis_data_penduduks, 'Edit Vis Data Penduduks'),
						anchor('administrator/vis_data_penduduks', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/vis_data_penduduks/edit/' . $save_vis_data_penduduks, 'Edit Vis Data Penduduks')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/vis_data_penduduks');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/vis_data_penduduks');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = 'Opss validation failed';
			$this->data['errors'] = $this->form_validation->error_array();
		}

		$this->response($this->data);
	}
	
		/**
	* Update view Vis Data Pendudukss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('vis_data_penduduks_update');

		$this->data['vis_data_penduduks'] = $this->model_vis_data_penduduks->find($id);

		$this->template->title('Vis Data Penduduks Update');
		$this->render('backend/standart/administrator/vis_data_penduduks/vis_data_penduduks_update', $this->data);
	}

	/**
	* Update Vis Data Pendudukss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('vis_data_penduduks_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
				$this->form_validation->set_rules('nama', 'Nama', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('jk', 'Jenis Kelamin', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('nik', 'NIK', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required');
		

		$this->form_validation->set_rules('agama', 'Agama', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('status_perkawinan', 'Status Perkawinan', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('kewarganegaraan', 'Kewarganegaraan', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('id_provinsi', 'Provinsi', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('id_kabupaten', 'Kabupaten', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('id_kecamatan', 'Kecamatan', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('id_desa', 'Desa', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('id_dusun', 'Dusun', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('id_rw', 'RW', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('id_rt', 'RT', 'trim|required|max_length[11]');
		

		$this->form_validation->set_rules('telp', 'Telp 1', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('telp2', 'Telp 2', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('vis_data_penduduks_file_name', 'File', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('id_kk', 'No KK', 'trim|required|max_length[255]');
		

		$this->form_validation->set_rules('created_at', 'Created At', 'trim|required');
		

		$this->form_validation->set_rules('updated_at', 'Updated At', 'trim|required');
		

		
		if ($this->form_validation->run()) {
			$vis_data_penduduks_file_uuid = $this->input->post('vis_data_penduduks_file_uuid');
			$vis_data_penduduks_file_name = $this->input->post('vis_data_penduduks_file_name');
		
			$save_data = [
				'nama' => $this->input->post('nama'),
				'jk' => $this->input->post('jk'),
				'nik' => $this->input->post('nik'),
				'tempat_lahir' => $this->input->post('tempat_lahir'),
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'agama' => $this->input->post('agama'),
				'status_perkawinan' => $this->input->post('status_perkawinan'),
				'kewarganegaraan' => $this->input->post('kewarganegaraan'),
				'pekerjaan' => $this->input->post('pekerjaan'),
				'id_provinsi' => $this->input->post('id_provinsi'),
				'id_kabupaten' => $this->input->post('id_kabupaten'),
				'id_kecamatan' => $this->input->post('id_kecamatan'),
				'id_desa' => $this->input->post('id_desa'),
				'id_dusun' => $this->input->post('id_dusun'),
				'id_rw' => $this->input->post('id_rw'),
				'id_rt' => $this->input->post('id_rt'),
				'telp' => $this->input->post('telp'),
				'telp2' => $this->input->post('telp2'),
				'id_kk' => $this->input->post('id_kk'),
				'created_at' => $this->input->post('created_at'),
				'updated_at' => $this->input->post('updated_at'),
			];

			

			


			
			if (!is_dir(FCPATH . '/uploads/vis_data_penduduks/')) {
				mkdir(FCPATH . '/uploads/vis_data_penduduks/');
			}

			if (!empty($vis_data_penduduks_file_uuid)) {
				$vis_data_penduduks_file_name_copy = date('YmdHis') . '-' . $vis_data_penduduks_file_name;

				rename(FCPATH . 'uploads/tmp/' . $vis_data_penduduks_file_uuid . '/' . $vis_data_penduduks_file_name, 
						FCPATH . 'uploads/vis_data_penduduks/' . $vis_data_penduduks_file_name_copy);

				if (!is_file(FCPATH . '/uploads/vis_data_penduduks/' . $vis_data_penduduks_file_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['file'] = $vis_data_penduduks_file_name_copy;
			}
		
			
			$save_vis_data_penduduks = $this->model_vis_data_penduduks->change($id, $save_data);

			if ($save_vis_data_penduduks) {

				

				
				
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/vis_data_penduduks', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/vis_data_penduduks');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/vis_data_penduduks');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = 'Opss validation failed';
			$this->data['errors'] = $this->form_validation->error_array();
		}

		$this->response($this->data);
	}
	
	/**
	* delete Vis Data Pendudukss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('vis_data_penduduks_delete');

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
            set_message(cclang('has_been_deleted', 'vis_data_penduduks'), 'success');
        } else {
            set_message(cclang('error_delete', 'vis_data_penduduks'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Vis Data Pendudukss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('vis_data_penduduks_view');

		$this->data['vis_data_penduduks'] = $this->model_vis_data_penduduks->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('Vis Data Penduduks Detail');
		$this->render('backend/standart/administrator/vis_data_penduduks/vis_data_penduduks_view', $this->data);
	}
	
	/**
	* delete Vis Data Pendudukss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$vis_data_penduduks = $this->model_vis_data_penduduks->find($id);

		if (!empty($vis_data_penduduks->file)) {
			$path = FCPATH . '/uploads/vis_data_penduduks/' . $vis_data_penduduks->file;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_vis_data_penduduks->remove($id);
	}
	
	/**
	* Upload Image Vis Data Penduduks	* 
	* @return JSON
	*/
	public function upload_file_file()
	{
		if (!$this->is_allowed('vis_data_penduduks_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'vis_data_penduduks',
		]);
	}

	/**
	* Delete Image Vis Data Penduduks	* 
	* @return JSON
	*/
	public function delete_file_file($uuid)
	{
		if (!$this->is_allowed('vis_data_penduduks_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'file', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'vis_data_penduduks',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/vis_data_penduduks/'
        ]);
	}

	/**
	* Get Image Vis Data Penduduks	* 
	* @return JSON
	*/
	public function get_file_file($id)
	{
		if (!$this->is_allowed('vis_data_penduduks_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$vis_data_penduduks = $this->model_vis_data_penduduks->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'file', 
            'table_name'        => 'vis_data_penduduks',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/vis_data_penduduks/',
            'delete_endpoint'   => 'administrator/vis_data_penduduks/delete_file_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('vis_data_penduduks_export');

		$this->model_vis_data_penduduks->export(
			'vis_data_penduduks', 
			'vis_data_penduduks',
			$this->model_vis_data_penduduks->field_search
		);
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('vis_data_penduduks_export');

		$this->model_vis_data_penduduks->pdf('vis_data_penduduks', 'vis_data_penduduks');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('vis_data_penduduks_export');

		$table = $title = 'vis_data_penduduks';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_vis_data_penduduks->find($id);
        $fields = $result->list_fields();

        $content = $this->pdf->loadHtmlPdf('core_template/pdf/pdf_single', [
            'data' => $data,
            'fields' => $fields,
            'title' => $title
        ], TRUE);

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table.'.pdf', 'H');
	}

	
}


/* End of file vis_data_penduduks.php */
/* Location: ./application/controllers/administrator/Vis Data Penduduks.php */