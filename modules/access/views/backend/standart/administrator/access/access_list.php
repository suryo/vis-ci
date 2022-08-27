<section class="content-header">
    <h1>
        Access
        <small><?= cclang('list_all', 'Access'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Access</li>
    </ol>
</section>

<section class="content access-page">
    <div class="row">

        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-body ">

                    <div class="box box-widget widget-user-2">

                        <div class="widget-user-header ">
                            <div class="row pull-right">
                                <?php is_allowed('permission_add', function () { ?>
                                    <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="add new permission (Ctrl+a)" href="<?= site_url('administrator/permission/add'); ?>"><i class="fa fa-plus-square-o"></i> <?= cclang('add_new_button', 'Permission'); ?></a>
                                <?php }) ?>
                            </div>
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?= BASE_ASSET ?>img/list.png" alt="User Avatar">
                            </div>

                            <h3 class="widget-user-username">Access</h3>
                            <h5 class="widget-user-desc"><?= cclang('list_all', 'Access'); ?></h5>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <?php $i = 1;
                                foreach ($groups as $group) : ?>
                                    <li class="<?= $i++ == 1 ? 'active' : ''; ?>"><a href="#tab_<?= $i; ?>" class="tab_group" data-toggle="tab" data-id="<?= $group->id; ?>"><?= _ent($group->name); ?></a></li>
                                <?php endforeach; ?>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        <b>Groups</b> <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if ($this->aauth->is_allowed('group_add')) : ?>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= site_url('administrator/group/add'); ?>"><?= cclang('add_new_button', 'Group'); ?></a></li>
                                        <?php endif; ?>
                                        <?php if ($this->aauth->is_allowed('group_list')) : ?>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= site_url('administrator/group'); ?>"><?= cclang('view_all_button', 'Group'); ?></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <li class="pull-right"><a href="<?= site_url('administrator/permission'); ?>" class="text-muted"><i class="fa fa-gear"></i></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <label><input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all"> <?= cclang('check_all'); ?></label> <input type="text" id="search" name="search" placeholder="<?= cclang('filter'); ?> access">

                                    <hr>

                                    <?= form_open('administrator/access/save', [
                                        'name'    => 'form_access',
                                        'class'   => 'form-horizontal',
                                        'id'      => 'form_access',
                                        'method'  => 'POST'
                                    ]); ?>

                                    <input type="hidden" name="group_id" id="group_id" value="<?= isset($groups[0]->id) ? $groups[0]->id : 0; ?>">
                                    <div class="multi-column">
                                        <ul id="container_permission">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="message">

                        </div>
                        <?php is_allowed('access_update', function () { ?>
                            <button class="btn btn-flat btn-default btn_save btn_action" id="btn_save" data-stype='stay' title="save (Ctrl+s)"><i class="fa fa-save"></i> <?= cclang('save_button'); ?></button>
                        <?php }) ?>
                        <span class="loading loading-hide"><img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg"> <i><?= cclang('loading_data'); ?></i></span>

                        <a class="btn btn-flat btn-default btn_undo display-none" data-id="0" id="btn_undo" title="undo (Ctrl+x)"><i class="fa fa-undo"></i> <?= cclang('undo_button'); ?></a>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<script>
    "use strict";

    var id_group = "<?= isset($groups[0]->id) ? $groups[0]->id : 0; ?>";
</script>

<script src="<?= BASE_ASSET ?>js/page/access/access-list.js"></script>