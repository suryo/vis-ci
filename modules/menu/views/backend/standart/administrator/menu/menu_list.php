<link rel="stylesheet" href="<?= BASE_ASSET ?>nestable/nesteable.css">
<link rel="stylesheet" href="<?= BASE_ASSET ?>m-switch/css/style.css">

<section class="content-header">
    <h1>
        <?= cclang('menu') ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?= cclang('home') ?></a></li>
        <li class="active"><?= cclang('menu') ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title "><?= cclang('menu_type'); ?></h3>
                </div>
                <div class="box-body ">

                    <div class="menu-type-wrapper <?= $this->uri->segment(4) == 'side-menu' ? 'active' : ''; ?>">
                        <div data-href="<?= site_url('administrator/menu/index/' . url_title('side menu')); ?>" class="clickable btn-block menu-type btn-group "> <?= cclang('side_menu'); ?>
                        </div>
                        <a class="menu-type-action">
                            &nbsp;
                        </a>
                    </div>
                    <?php foreach (db_get_all_data('menu_type', 'name!= "side menu"') as $row) : ?>
                        <div class="menu-type-wrapper  <?= $this->uri->segment(4) == url_title($row->name) ? 'active' : ''; ?>">
                            <span data-href="<?= site_url('administrator/menu/index/' . url_title($row->name)); ?>" class="clickable btn-block menu-type btn-group">
                                <?= _ent(ucwords($row->name)); ?>

                            </span>
                            <a class="menu-type-action remove-data" data-href="<?= base_url('administrator/menu_type/delete/' . $row->id); ?>" href="javascript:void()">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <br>
                    <a href="<?= site_url('administrator/menu_type/add'); ?>" class="btn btn-block btn-add btn-add-menu btn-flat" title="add menu type (Ctrl+r)"><i class="fa fa-plus-square-o"></i> <?= cclang('add_menu_type'); ?></a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title pull-left"><?= cclang('menu') ?> <?= ucwords(str_replace('-', ' ', $this->uri->segment(4))); ?></h3>
                </div>
                <div class="box-body ">
                    <div class="message">
                        <div class="callout callout-info btn-flat">
                            # double click menu to active or inactive
                        </div>
                    </div>
                    <div class="menu-loading-wrap">
                        <?php is_allowed('menu_add', function () { ?>
                            <a class="btn btn-flat btn-default btn_add_new" id="btn_add_new" title="add new menu (Ctrl+a)" href="<?= site_url('administrator/menu/add/' . $this->uri->segment(4)); ?>"><i class="fa fa-plus-square-o"></i> <?= cclang('add_new_button', cclang('menu')); ?></a>
                        <?php }) ?>
                        <span class="loading loading-hide"><img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg"> <i><?= cclang('loading_saving_data'); ?></i></span>
                    </div>
                    <div class="dd" id="nestable">
                        <?php
                        $menu = display_menu_module(0, 1, $this->uri->segment(4), true);
                        if (empty($menu)) : ?>
                            <div class="box-no-data">No data menu</div>
                        <?php else :
                            echo $menu;
                        endif; ?>
                    </div>
                    <div class="nestable-output"></div>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>


<script src="<?= BASE_ASSET ?>m-switch/js/jquery.mswitch.js" type="text/javascript"></script>
<script src="<?= BASE_ASSET ?>nestable/jquery.nestable.js"></script>
<script src="<?= BASE_ASSET ?>js/page/menu/menu-list.js"></script>