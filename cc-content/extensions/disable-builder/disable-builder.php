<?php 
namespace DisableBuilder;

app()->load->library('cc_html');


app()->cc_html->registerScriptFileBottom("
    
    $(function(){
        $('.switch-button').switchButton({
            labels_placement: 'right'
        });
    });

 ", 'script');

app()->cc_html->registerCssFile(BASE_ASSET . "/jquery-switch-button/jquery.switchButton.css");

cicool()->addTabSetting([
    'id' => 'builder_enabled',
    'label' => 'Disable Builder',
    'icon' => 'fa fa-code',
])->addTabContent([
    'content' => ' 
    <div class="col-md-6">
        <div class="col-sm-12">
            <label>Disable CRUD Builder</label><br>
            <input type="checkbox" class="switch-button" name="enable_crud_builder" '.(get_option('enable_crud_builder') == 1 ? 'checked' : '').' id="enable_crud_builder" value="1">
            <small class="info help-block">Disable CRUD module.</small>
        </div>

        <div class="col-sm-12">
            <label>Disable API Builder </label><br>
            <input type="checkbox" class="switch-button" name="enable_api_builder" '.(get_option('enable_api_builder') == 1 ? 'checked' : '').' id="enable_api_builder" value="1">
            <small class="info help-block">Disable API module.</small>
        </div>

        <div class="col-sm-12">
            <label>Disable Form Builder </label><br>
            <input type="checkbox" class="switch-button" name="enable_form_builder" '.(get_option('enable_form_builder') == 1 ? 'checked' : '').' id="enable_form_builder" value="1">
            <small class="info help-block">Disable FORM module.</small>
        </div>

        <div class="col-sm-12">
            <label>Disable Page Builder </label><br>
            <input type="checkbox" class="switch-button" name="enable_page_builder" '.(get_option('enable_page_builder') == 1 ? 'checked' : '').' id="enable_page_builder" value="1">
            <small class="info help-block">Disable Page module.</small>
        </div>

    </div>
    '
])
->settingBeforeSave(function($form){
})
->settingOnSave(function($ci){
    set_option('enable_api_builder', $ci->input->post('enable_api_builder'));
    set_option('enable_crud_builder', $ci->input->post('enable_crud_builder'));
    set_option('enable_form_builder', $ci->input->post('enable_form_builder'));
    set_option('enable_page_builder', $ci->input->post('enable_page_builder'));
});


$perm = [];

if (get_option('enable_api_builder')) {
    $perm = array_merge($perm, [
            ['perm' => 'rest_add', 'method' => 'get'],
            ['perm' => 'rest_add', 'method' => 'post'],
            ['perm' => 'rest_list', 'method' => 'get'],
            ['perm' => 'rest_update', 'method' => 'get'],
            ['perm' => 'rest_update', 'method' => 'post'],
            ['perm' => 'rest_delete', 'method' => 'get'],
        ]
    );
}

if (get_option('enable_crud_builder')) {
    $perm = array_merge($perm, [
            ['perm' => 'crud_add', 'method' => 'get'],
            ['perm' => 'crud_add', 'method' => 'post'],
            ['perm' => 'crud_list', 'method' => 'get'],
            ['perm' => 'crud_update', 'method' => 'get'],
            ['perm' => 'crud_update', 'method' => 'post'],
            ['perm' => 'crud_delete', 'method' => 'get'],
        ]
    );
}

if (get_option('enable_form_builder')) {
    $perm = array_merge($perm, [
            ['perm' => 'form_add', 'method' => 'get'],
            ['perm' => 'form_add', 'method' => 'post'],
            ['perm' => 'form_list', 'method' => 'get'],
            ['perm' => 'form_update', 'method' => 'get'],
            ['perm' => 'form_update', 'method' => 'post'],
            ['perm' => 'form_delete', 'method' => 'get'],
        ]
    );
}

if (get_option('enable_page_builder')) {
    $perm = array_merge($perm, [
            ['perm' => 'page_add', 'method' => 'get'],
            ['perm' => 'page_add', 'method' => 'post'],
            ['perm' => 'page_list', 'method' => 'get'],
            ['perm' => 'page_update', 'method' => 'get'],
            ['perm' => 'page_update', 'method' => 'post'],
            ['perm' => 'page_delete', 'method' => 'get'],
        ]
    );
}

if (!defined('PERM_BUILDER_DISABLED')) {
    define('PERM_BUILDER_DISABLED', serialize($perm));
}


app()->cc_app->onEvent('auth_allowed_permission', function ($perm) {
    $perm_denied = unserialize(PERM_BUILDER_DISABLED);

    foreach ((array) $perm_denied as $mod) {
        if (in_array($mod['perm'], $perm)) {
            if (in_array(app()->input->method(), explode(',', $mod['method']))) {
                if (app()->input->is_ajax_request()) {
                    return app()->response([
                        'success' => false,
                        'message' => 'Sorry this feature disabled'
                        ]);
                } else {
                    app()->session->set_flashdata('f_message', 'Sorry this feature disabled');
                    app()->session->set_flashdata('f_type', 'warning');
                    redirect('administrator/dashboard','refresh');
                }
            }
        }
    }
});

if (!defined('EXNAME')) {
    define('EXNAME', basename(__DIR__));
}
if ($ccExtension->actived()) {
   app()->cc_app->onEvent('extension_info_'.EXNAME, function(){
    echo '<div class="callout callout-warning-cc ">go to page '.anchor('administrator/setting/?tab=tab_builder_enabled', 'setting', ['class' => 'btn btn-xs btn-info btn-flat']).' for configuration</div>';
    });
}
