<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Access Controller
 *| --------------------------------------------------------------------------
 *| access site
 *|
 */
class Access extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model([
			'model_access',
			'group/model_group'
		]);
	}

	/**
	 * show all access
	 *
	 * @var $offset String
	 */
	public function index($offset = 0)
	{
		$this->is_allowed('access_list');

		$this->data['groups'] = $this->model_group->find_all();

		$this->template->title('Access List');
		$this->render('backend/standart/administrator/access/access_list', $this->data);
	}

	/**
	 * Update accesss
	 *
	 * @var String $id 
	 */
	public function save()
	{
		if (!$this->is_allowed('access_update', false)) {
			return $this->response([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
			]);
		}

		$permissions = $this->input->post('id');
		$group_id = $this->input->post('group_id');

		$this->db->delete('aauth_perm_to_group', ['group_id' => $group_id]);
		if (count($permissions)) {
			$data = [];
			foreach ($permissions as $perms) {
				$data[] = [
					'perm_id' => $perms,
					'group_id' => $group_id,
				];
			}
			$save_access = $this->db->insert_batch('aauth_perm_to_group', $data);
		} else {
			$save_access = true;
		}

		if ($save_access) {
			$this->data = [
				'success' => true,
				'message' => cclang('success_save_data_stay', []),
			];
		} else {
			$this->data = [
				'success' => false,
				'message' => cclang('data_not_change'),
			];
		}

		return $this->response($this->data);
	}

	/**
	 * Get Access group
	 *
	 * @var String $group_id 
	 */
	public function get_access_group($group_id)
	{
		if (!$this->is_allowed('access_list', false)) {
			echo '<center>Sorry you do not have permission to access</center>';
			exit;
		}
		$group_perms_groupping = [];

		$group_perms = $this->model_group->get_permission_group($group_id);
		foreach (db_get_all_data('aauth_perms') as $perms) {

			$group_name = 'other';
			$perm_tmp_arr = explode('_', $perms->name);

			if (isset($perm_tmp_arr[0]) and !empty($perm_tmp_arr[0])) {
				$group_name =  strtolower($perm_tmp_arr[0]);
			}
			$group_perms_groupping[$group_name][] = $perms;
		}

		$this->data['group_perms_groupping'] = $group_perms_groupping;
		$this->data['group_perms'] = $group_perms;

		return $this->response([
			'success' => true,
			'html' => $this->load->view('backend/standart/administrator/access/access_list_permission', $this->data, true)
		]);
	}
}


/* End of file Access.php */
/* Location: ./application/controllers/administrator/Access.php */