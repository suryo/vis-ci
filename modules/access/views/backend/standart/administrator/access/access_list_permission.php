<?php foreach ($group_perms_groupping as $group_name => $childs) { ?>
    <li>
        <div class="box box-danger box-solid">
            <div class="box-header with-border">
                <label class=" text-white toggle-select-all-access" data-target=".<?= $group_name; ?>">
                    <h3 class="box-title"><i class="fa fa-check-square"></i> <?= ucwords($group_name); ?></h3>
                </label>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="box-body display-block">
                <ul>
                    <?php foreach ($childs as $perms) { ?>
                        <li>
                            <label>
                                <input type="checkbox" class="flat-red check <?= $group_name; ?>" name="id[]" value="<?= $perms->id; ?>" <?= array_search($perms->id, $group_perms) ? 'checked' : ''; ?>>
                                <?= _ent(ucwords(clean_snake_case($perms->name))); ?>
                            </label>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </li>
<?php     } ?>