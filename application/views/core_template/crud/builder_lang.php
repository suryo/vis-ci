{php_open_tag}
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['{table_name}'] = '<?=$subject ?>';
<?php foreach ($this->crud_builder->getFieldShowInDetailPage(true) as $input => $option): ?>$lang['<?= $input ?>'] = '<?= ucwords(clean_snake_case($option['label'])) ?>';
<?php endforeach ?>