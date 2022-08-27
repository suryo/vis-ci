<?php 
$landing_page_id = $this->input->post('landing_page_id');
?>
{php_tag_open}
<?php if ($landing_page_id == 'default'): ?>
$route['default_controller'] = 'web';
<?php elseif ($landing_page_id == 'login'): ?>
$route['default_controller'] = 'auth/backend/auth/login';
<?php elseif ($landing_page_id == 'register'): ?>
$route['default_controller'] = 'auth/backend/auth/register';
<?php else: ?>
$route['default_controller'] = 'page/landing';
<?php endif; ?>