<link rel="stylesheet" href="<?= BASE_ASSET ?>bsselect/bootstrap-select.min.css">
<link rel="stylesheet" href="<?= BASE_ASSET ?>flag-icon/css/flag-icon.css" rel="stylesheet" media="all" />
<link rel="stylesheet" href="<?= BASE_ASSET ?>fine-upload/fine-uploader-gallery.min.css">
<script src="<?= BASE_ASSET ?>bsselect/bootstrap-select.min.js"></script>
<script src="<?= BASE_ASSET ?>fine-upload/jquery.fine-uploader.js"></script>

<?php $this->load->view('core_template/fine_upload_new_skin'); ?>

<section class="content-header">
  <h1>
    Setting
    <small><?= cclang('list_all'); ?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><?= cclang('list_all'); ?></li>
  </ol>
</section>

<section class="content page-setting">
  <div class="row">

    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-body ">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header ">
              <div class="row pull-right">

              </div>
              <div class="widget-user-image">
                <img class="img-circle" src="<?= BASE_ASSET ?>img/list.png" alt="User Avatar">
              </div>

              <h3 class="widget-user-username">Setting</h3>
              <h5 class="widget-user-desc"><?= cclang('web_setting'); ?></h5>
            </div>
          </div>

          <div class="row-fluid">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="<?= empty($this->input->get('tab')) ? 'active' : '' ?>"><a href="#tab_general" class="tab_group" data-toggle="tab"><i class="fa fa-compass text-green"></i> <?= cclang('site_general'); ?></a></li>

                <li><a href="#tab_oauth" class="tab_group" data-toggle="tab"><i class="fa fa-chrome text-green"></i> Oauth</a></li>

                <li><a href="#tab_system" class="tab_group" data-toggle="tab"><i class="fa fa-tv text-green"></i> <?= cclang('system'); ?></a></li>

                <?= cicool()->renderTabSetting() ?>

              </ul>
              <?= form_open('administrator/setting/save', [
                'name'    => 'form_setting',
                'class'   => 'form-horizontal',
                'id'      => 'form_setting',
                'method'  => 'POST'
              ]); ?>
              <div class="tab-content">

                <?= cicool()->renderTabContent() ?>

                <div class="tab-pane <?= empty($this->input->get('tab')) ? 'active' : '' ?>" id="tab_general">
                  <div class="row">
                    <div class="col-md-6">

                      <div class="col-sm-5">
                        <label>Logo <span class="required">*</span></label>
                        <div id="setting_attachment_galery"></div>
                        <input class="data_file data_file_uuid" name="setting_attachment_uuid" id="setting_attachment_uuid" type="hidden" value="<?= set_value('setting_attachment_uuid'); ?>">
                        <input class="data_file" name="setting_attachment_name" id="setting_attachment_name" type="hidden" value="">
                        <br>
                      </div>

                      <div class="col-sm-12">
                        <label><?= cclang('site_name'); ?> <span class="required">*</span></label>
                        <input type="text" class="form-control" name="site_name" id="site_name" value="<?= get_option('site_name'); ?>">
                        <small class="info help-block">The site name.</small>
                      </div>

                      <div class="col-sm-12">
                        <label><?= cclang('site_description'); ?></label>
                        <textarea type="text" class="form-control" name="site_description" id="site_description"><?= get_option('site_description'); ?></textarea>
                        <small class="info help-block"><?= cclang('site_description_help_block'); ?></small>
                      </div>

                      <div class="col-sm-12">
                        <label><?= cclang('default_landing_page'); ?> <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 ">
                            <select class="form-control" name="landing_page_id" id="landing_page_id">
                              <option value="default"><?= cclang('default_theme'); ?></option>
                              <option value="login">Login Page</option>
                              <option value="register">Register Page</option>
                              <?php foreach ($pages as $page) : ?>
                                <option value="<?= $page->id; ?>" <?= $page->id == $landing_page ? 'selected' : ''; ?>>Page : <?= _ent($page->title); ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <small class="info help-block">
                          <?= cclang('default_landing_page_help_block'); ?>
                        </small>
                      </div>


                      <div class="col-sm-12">
                        <label><?= cclang('limit_pagination'); ?> <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 ">
                            <select class="form-control" name="limit_pagination" id="limit_pagination">
                              <?php for ($i = 10; $i <= 200; $i += 5) : ?>
                                <option value="<?= $i ?>" <?= $i == $limit_pagination ? 'selected' : ''; ?>><?= $i; ?></option>
                              <?php endfor; ?>
                            </select>
                          </div>
                        </div>
                        <small class="info help-block">
                          <?= cclang('limit_pagination'); ?>
                        </small>
                      </div>


                      <div class="col-sm-12">
                        <label>Active Theme <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 ">
                            <select class="form-control" name="active_theme" id="active_theme">
                              <?php foreach (get_theme_list() as $theme) : ?>
                                <option value="<?= $theme; ?>" <?= $theme == $active_theme ? 'selected' : ''; ?>><?= _ent($theme); ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <small class="info help-block">
                          <?= cclang('default_landing_page_help_block'); ?>
                        </small>
                      </div>

                      <div class="col-sm-12">
                        <label><?= cclang('select_language'); ?> <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 ">

                            <select class="selectpicker" data-width="100%" name="language">
                              <?php foreach (get_langs() as $lang) : ?>
                                <option <?= $this->config->item('language') == $lang['folder_name'] ? 'selected' : ''; ?> value="<?= $lang['folder_name']; ?>" data-content='<span class="flag-icon <?= $lang['icon_name']; ?>"></span> <?= $lang['name']; ?>'><?= $lang['name']; ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <small class="info help-block">
                          <?= cclang('select_language'); ?>
                        </small>
                      </div>

                      <div class="col-sm-12">
                        <label><?= cclang('keyword'); ?></label>
                        <textarea type="text" class="form-control" name="keywords" id="keywords"><?= get_option('keywords'); ?></textarea>
                        <small class="info help-block">The site meta keywords.</small>
                      </div>

                      <div class="col-sm-12">
                        <label><?= cclang('author'); ?></label>
                        <input type="text" class="form-control" name="author" id="author" value="<?= get_option('author'); ?>">
                        <small class="info help-block">The author name.</small>
                      </div>

                      <div class="col-sm-12">
                        <label><?= cclang('email'); ?> <span class="required">*</span></label>
                        <input type="text" class="form-control" name="email" id="email" value="<?= get_option('email'); ?>">
                        <small class="info help-block">The email of user author.</small>
                      </div>

                      <div class="col-sm-12">
                        <label>Timezone <span class="required">*</span></label>
                        <div class="row">
                          <div class="col-md-6 ">
                            <select class="form-control choosen chosen-select" name="timezone" id="timezone">
                              <?php
                              $timezones = [];
                              foreach (timezone_abbreviations_list() as $abbr => $timezone) {
                                foreach ($timezone as $val) {
                                  if (isset($val['timezone_id'])) {
                                    $timezones[$val['timezone_id']] = $val['timezone_id'];
                                  }
                                }
                              } ?>

                              <?php
                              foreach ($timezones as $tmzid) {
                              ?>
                                <option <?= $timezone_opt == $tmzid ? 'selected' : '' ?> value="<?= $tmzid ?>"><?= $tmzid ?></option>
                              <?php
                              } ?>
                            </select>
                          </div>
                        </div>
                        <small class="info help-block">

                        </small>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="tab-pane " id="tab_system">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                <b class="text-green"><?= cclang('session') ?></b> <?= cclang('configuration') ?></a>
                            </h4>
                          </div>
                          <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body">

                              <div class="row col-md-6">
                                <div class="col-sm-12">
                                  <label><?= cclang('session_cookie_name'); ?> <span class="required">*</span></label>
                                  <input type="text" class="form-control" name="sess_cookie_name" id="sess_cookie_name" value="<?= $this->config->item('sess_cookie_name'); ?>">
                                  <small class="info help-block">
                                    <?= cclang('session_cookie_name_help_block'); ?>
                                  </small>
                                </div>

                                <div class="col-sm-12">
                                  <label> <?= cclang('session_expiration'); ?> <span class="required">*</span></label>
                                  <div class="row">
                                    <div class="col-md-6 ">
                                      <select class="form-control " name="sess_expiration" id="sess_expiration">
                                        <?php foreach ($times as $time) : ?>
                                          <option value="<?= $time['value']; ?>" <?= $time['value'] == $this->config->item('sess_expiration') ? 'selected' : ''; ?>><?= $time['label']; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>
                                  </div>
                                  <small class="info help-block">
                                    <?= cclang('session_expiration_help_block'); ?>
                                  </small>
                                </div>

                                <div class="col-sm-12">
                                  <label><?= cclang('session_time_to_update'); ?> <span class="required">*</span></label>
                                  <div class="row">
                                    <div class="col-md-6 ">
                                      <select class="form-control" name="sess_time_to_update" id="sess_time_to_update">
                                        <?php foreach ($times as $time) : ?>
                                          <option value="<?= $time['value']; ?>" <?= $time['value'] == $this->config->item('sess_time_to_update') ? 'selected' : ''; ?>><?= $time['label']; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>
                                  </div>
                                  <small class="info help-block">
                                    <?= cclang('session_time_to_update_help_block'); ?>
                                  </small>
                                </div>

                                <div class="col-sm-12">
                                  <label><?= cclang('session_cookie_name'); ?> <span class="required">*</span></label>
                                  <input type="text" class="form-control" name="sess_cookie_name" id="sess_cookie_name" value="<?= $this->config->item('sess_cookie_name'); ?>">
                                  <small class="info help-block">
                                    The session cookie name.
                                  </small>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                <b class="text-green">CSRF</b> <?= cclang('configuration') ?></a>
                            </h4>
                          </div>
                          <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">
                              <div class="row col-md-6">
                                <div class="col-sm-12">
                                  <label><?= cclang('csrf_token_name'); ?> <span class="required">*</span></label>
                                  <input type="text" class="form-control" name="csrf_token_name" id="csrf_token_name" value="<?= $this->config->item('csrf_token_name'); ?>">
                                  <small class="info help-block">
                                    The token name.
                                  </small>
                                </div>

                                <div class="col-sm-12">
                                  <label><?= cclang('csrf_cookie_name'); ?> <span class="required">*</span></label>
                                  <input type="text" class="form-control" name="csrf_cookie_name" id="csrf_cookie_name" value="<?= $this->config->item('csrf_cookie_name'); ?>">
                                  <small class="info help-block">
                                    The cookie name.
                                  </small>
                                </div>

                                <div class="col-sm-12">
                                  <label><?= cclang('csrf_expire'); ?> <span class="required">*</span></label>
                                  <div class="row">
                                    <div class="col-md-6 ">
                                      <select class="form-control" name="csrf_expire" id="csrf_expire">
                                        <?php foreach ($times as $time) : ?>
                                          <option value="<?= $time['value']; ?>" <?= $time['value'] == $this->config->item('csrf_expire') ? 'selected' : ''; ?>><?= $time['label']; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>
                                  </div>
                                  <small class="info help-block">
                                    <?= cclang('csrf_expire_help_block'); ?>
                                  </small>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                <b class="text-green"><?= cclang('other') ?></b> <?= cclang('configuration') ?></a>
                            </h4>
                          </div>
                          <div id="collapse3" class="panel-collapse collapse">
                            <div class="panel-body">
                              <div class="row col-md-6">
                                <div class="col-sm-12">
                                  <label><?= cclang('permitted_uri_chars'); ?> </label>
                                  <input type="text" class="form-control" name="permitted_uri_chars" id="permitted_uri_chars" value="<?= $this->config->item('permitted_uri_chars'); ?>">
                                  <small class="info help-block">
                                    <?= cclang('permitted_uri_chars_help_block', '! preg_match(\'/^[<permitted_uri_chars>]+$/i'); ?>
                                  </small>
                                </div>

                                <div class="col-sm-12">
                                  <label><?= cclang('url_suffix'); ?> </label>
                                  <input type="text" class="form-control" name="url_suffix" id="url_suffix" value="<?= $this->config->item('url_suffix'); ?>">
                                  <small class="info help-block">
                                    <?= cclang('url_suffix_help_block', 'http://example.com/blog/article-1<b class="text-danger tip" title=".html is URL Suffix ">.html</b>'); ?>.
                                  </small>
                                </div>

                                <div class="col-sm-12">
                                  <label> <?= cclang('global_xss_filtering'); ?> <i class="required">*</i></label>
                                  <div class="row">
                                    <div class="col-md-6 ">
                                      <select class="form-control" name="global_xss_filtering" id="global_xss_filtering" placeholder="Global XSS Filtering">
                                        <?php
                                        $global_xss_filtering = $this->config->item('global_xss_filtering');
                                        ?>
                                        <option value="TRUE" <?= $global_xss_filtering == TRUE ? 'selected' : ''; ?>>YES</option>
                                        <option value="FALSE" <?= $global_xss_filtering == FALSE ? 'selected' : ''; ?>>NO</option>
                                      </select>
                                    </div>
                                  </div>
                                  <small class="info help-block">
                                    <?= cclang('global_xss_filtering_help_block'); ?>
                                  </small>
                                </div>

                                <div class="col-sm-12">
                                  <label><?= cclang('encryption_key'); ?> <span class="required">*</span></label>
                                  <input type="text" class="form-control" name="encryption_key" id="encryption_key" value="<?= $this->config->item('encryption_key'); ?>">
                                  <small class="info help-block">
                                    <?= cclang('encryption_key_help_block'); ?>.
                                  </small>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane" id="tab_oauth">

                  <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <b class="text-green">Google</b> </a>
                        </h4>
                      </div>
                      <div id="collapse1" class="panel-collapse collapse in">
                        <div class="panel-body">

                          <div class="row">
                            <div class="col-md-6">


                              <div class="col-sm-12">
                                <label>ID</label>
                                <input type="text" class="form-control" name="google_id" id="google_id" value="<?= get_option('google_id'); ?>">
                                <small class="info help-block">The id of google oauth
                                  <br>
                                  You can get this on <?= anchor('https://console.cloud.google.com/apis/credentials'); ?>.</small>
                              </div>

                              <div class="col-sm-12">
                                <label>Secret</label>
                                <textarea type="text" class="form-control" name="google_secret" id="google_secret"><?= get_option('google_secret'); ?></textarea>
                                <small class="info help-block">The secret of google oauth.</small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="message no-message-padding">

            </div>
            <?php is_allowed('setting_update', function () { ?>
              <button class="btn btn-flat btn-default btn_save btn_action" id="btn_save" data-stype='stay' title="save (Ctrl+s)"><i class="fa fa-save"></i> <?= cclang('save_button'); ?></button>
            <?php }) ?>
            <span class="loading loading-hide"><img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg"> <i><?= cclang('loading_data'); ?></i></span>

            <a class="btn btn-flat btn-default btn_undo display-none" data-id="0" id="btn_undo" title="undo (Ctrl+x)"><i class="fa fa-undo"></i> Undo</a>
            <?= form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>

<script src="<?= BASE_ASSET ?>js/page/setting/setting-general.js"></script>