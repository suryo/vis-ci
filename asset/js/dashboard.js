'use strict';

function Dashboard() {
    this.intervalGetDataList = {};
    this.listIntervalGetData = [];
    this.listEachWidged = [];
    this.intervalDurationGetData = 5000;
}
Dashboard.prototype.registerIntervalGetData = function(id, func) {
    var _this = this;
    this.intervalGetDataList[id] = func;
}
Dashboard.prototype.registerEachWidged = function(type, func) {
    this.listEachWidged.push({
        type: type,
        func: func
    })
}
Dashboard.prototype.doIntervalGetData = function() {
    var _this = this;
    $.each(this.intervalGetDataList, function(index, func) {
        func();
        if (editMode == 0) {
            _this.listIntervalGetData[index] = setInterval(function() {
                func();
            }, _this.intervalDurationGetData);
        }
    });
}
Dashboard.prototype.doEachWidged = function() {
    var _this = this;
    console.log('each instance', this.listEachWidged)
    $.each(this.listEachWidged, function(type, obj) {
        var widged = new Widged;
        widged.type(obj.type).setup(function(item) {
            obj.func(item);
        });
    });
    return this;
}
Dashboard.prototype.createSidebar = function(configs) {
    var defaults = {
        name: "",
        title: "Setting",
        width: "300px",
        left: "",
        parent: "no-parent"
    }
    configs = $.extend(true, defaults, configs);
    var sidebar = `
        <div class="sidebar-component ` + configs.name + ` sidebar-page-setting sidebar-child cc-sidebar-wrapper"
       
          data-class=".` + configs.name + `"
          data-parent=".` + configs.parent + `"
          data-width="` + configs.width + `"
          data-left="` + configs.left + `"
        >
            <div class="header-page  ` + (configs.parent == "no-parent" ? 'header-page-parent' : 'header-page-setting') + `">
                <div class="cc-page-title">
                    ` + configs.title + `
                    <a class="pull-right btn-close-page btn-close-side-page" href="#" data-parent=".sidebar-widged-setting" >
                        ✕
                    </a>
                </div>
            </div>
            <div class="cc-scroller-page-setting">
                <div class="cc-overlay-page-setting">
                    <img class="cc-img-loader" src="` + BASE_URL + `asset/img/rolling-loader.svg">
                    </img>
                </div>
               
                <div class="sidebar-body">
                </div>
            </div>
        </div>
    `;
    $('.sidebar-wrapper').prepend(sidebar);
    this.sidebarPos();
    var obj = $('.sidebar-component.' + configs.name);
    obj.withScroll = function() {
        obj.find('.sidebar-body').slimScroll({
            height: obj.height() - 190
        });
        return obj;
    }
    obj.showLoader = function() {
        obj.find('.cc-img-loader').show();
        return obj;
    }
    obj.hideLoader = function() {
        obj.find('.cc-img-loader').hide();
        return obj;
    }
    return obj;
}
Dashboard.prototype.initChosen = function() {
    var config = {
        '.chosen-select': {
            search_contains: true,
            search_contains: true,
            parser_config: {
                copy_data_attributes: true
            }
        },
        '.chosen-select-deselect': {
            allow_single_deselect: true,
            search_contains: true,
            parser_config: {
                copy_data_attributes: true
            }
        },
        '.chosen-select-no-single': {
            disable_search_threshold: 10
        },
        '.chosen-select-no-results': {
            no_results_text: 'Oops, nothing found!'
        },
        '.chosen-select-width': {
            width: "95%"
        }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
}
Dashboard.prototype.closeSidePage = function(el) {
    var parent = el.find('.btn-close-page').attr('data-parent');
    var className = el.attr('data-class');
    if (parent != 'undefined') {}
    if (className != undefined) {
        $('.sidebar-component[data-parent="' + className + '"]').hide("slide", {
            direction: "left",
            easing: 'easeOutQuad'
        }, 500);
    }
    el.hide("slide", {
        direction: "left",
        easing: 'easeOutQuad'
    }, 500);
}
Dashboard.prototype.showSidePage = function(el, close, sidebarParent) {
    var _this = this;
    var currentIndex = 9999;
    var indexIncrement = 6;
    if (typeof close == 'undefined') {
        close == true;
    }
    if (typeof sidebarParent != 'undefined') {
        close == true;
    }
    $('.sidebar-component').each(function(index, el) {
        currentIndex = currentIndex + indexIncrement;
        $(this).css('z-index', currentIndex);
        if (close) {
            _this.closeSidePage($(this))
        }
    });
    currentIndex = currentIndex + indexIncrement;
    el.css('z-index', currentIndex);
    if (typeof sidebarParent != 'undefined') {
        sidebarParent.css('z-index', currentIndex + indexIncrement);
    }
    if (el.css('display') == 'none') {
        el.show("slide", {
            direction: "left"
        }, 500);
    } else {
        if (close) {
            _this.closeSidePage(el)
        }
    }
}
Dashboard.prototype._init = function() {
    this.widged();
}
Dashboard.prototype.addNewWidged = function(type) {
    var _this = this;
    var grid = $('.grid-stack').data('gridstack');
    this.showLoaderComponent($('.sidebar-widged'));
    $.ajax({
        url: BASE_URL + 'administrator/widged/add',
        type: 'GET',
        dataType: 'JSON',
        data: {
            type: type,
            dashboard: dashboardData.slug
        },
    }).done(function(res) {
        var obj = grid.addWidget(res.data.view);
        var widged = new Widged;
        widged.target(obj).instance.setting()
        _this.closeSidePage($('.sidebar-component'));
        _this.showSidePage($('.sidebar-widged-setting'));
    }).fail(function() {}).always(function() {
        _this.hideLoaderComponent($('.sidebar-widged'));
    });
    return this;
}
Dashboard.prototype.seriesSetting = function() {
    var _this = this;
    var $container = $('.sidebar-series-setting');
    this.showLoaderComponent($container);
    $.ajax({
        url: BASE_URL + 'administrator/widged/series_setting',
        type: 'GET',
        dataType: 'JSON',
    }).done(function(res) {
        if (res.success) {
            $container.find('.sidebar-body').html(res.contents)
        }
    }).fail(function() {}).always(function() {
        _this.hideLoaderComponent($container);
    });
    return this;
}
Dashboard.prototype.showLoaderComponent = function(el) {
    el.find('.cc-img-loader').show();
}
Dashboard.prototype.hideLoaderComponent = function(el) {
    el.find('.cc-img-loader').hide();
}
Dashboard.prototype.sidebarPos = function() {
    $('.sidebar-child').each(function(index, el) {
        var width = $(this).data('width');
        var left = $(this).data('left');
        var parent = $(this).data('parent');
        if (width) {
            $(this).width(width)
        }
        if (parent) {
            var parentWidth = $(parent).width();
            $(this).css('margin-left', parentWidth + 80)
        }
        if (left) {
            $(this).css('margin-left', left)
        }
    });
}
Dashboard.prototype.widged = function() {
    var _this = this;
    $('.widged-option').on('click', function(event) {
        var linked = $(this).data('type');
        _this.addNewWidged(linked);
    });
    $('.btn-round-element').on('click', function(event) {
        $('#modalAddWidged').modal('show')
    });
    var options = {
        disableDrag: false,
        disableResize: false,
        cellHeight: 65,
        cellWidth: 65,
        animate: true
    };
    $('.grid-stack-item').each(function(index, el) {
        var height = $(this).data('gs-height');
        if (height == 0) {
            height = $(this).data('gs-min-height');
        }
        $(this).find('.box-body').height(height * 55);
    });
    $('.grid-stack').gridstack(options);
}

function CTabs() {
    this.element;
    this.clases;
}
   
CTabs.prototype.setActive = function(tab) {
    if (typeof tab == 'object') {
        var tabItem = $(tab);
    } 
    else {
        var tabItem = this.getElement().find('input[name="mode"][value="'+tab+'"]').parents('.tab-top-nav-btn')
    }
    $(this.clases).find('.tab-top-nav-btn').removeClass('active')
    tabItem.addClass('active')
    tabItem.find('input[type="radio"]').prop('checked', true)

    return this;
}

CTabs.prototype.setElement = function(element) {
    element = (typeof element != 'undefined' ? element :  '');
    this.clases = element;
    this.element = $(element);

    return this;
}

CTabs.prototype.getElement = function() {
    return $(this.clases);
}

CTabs.prototype.init = function(element) {
    this.setElement(element);
    var _this = this;
    $(document).on('click', _this.clases+' a.tab-top-nav-btn', function(event) {
        _this.setActive(this);
    });
}


var $dashboard = new Dashboard();
$(function() {
    $dashboard._init();
    $dashboard.sidebarPos();
    $(document).on('click', '.sidebar-component .btn-close-page', function(event) {
        event.preventDefault();
        var sideParent = $(this).data('parent');
        var sideName = $(this).parents('.sidebar-component').attr('data-class');
        console.log(sideParent)
        if (sideParent == undefined) {
            $('.btn-close-page[data-parent="' + sideName + '"]').each(function(index, el) {
                $(this).trigger('click')
            });
        }
        $dashboard.closeSidePage($(this).parents('.sidebar-component'));
    });
    $('.btn-add-widged').on('click', function(event) {
        event.preventDefault();
        $dashboard.showSidePage($('.sidebar-widged'))
    });
    $('.sidebar-component').each(function(index, el) {
        var width = $(this).data('width');
        if (width) {
            $(this).width(width)
        }
    });
    $('.btn-new-dashboard').on('click', function(event) {
        event.preventDefault();
        swal({
            title: "New Dashboard",
            text: "Fill Dashboard Name:",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            animation: "slide-from-top",
            inputPlaceholder: "Name",
            animation: false
        }, function(inputValue) {
            if (inputValue === false) return false;
            if (inputValue === "") {
                swal.showInputError("Dashboard Name is Required!");
                return false
            }
            document.location.href = BASE_URL + 'administrator/dashboard/create?name=' + inputValue;
        });
    });
})

function Widged() {
    var type;
    this.object = null;
}

function WidgedMeta(object) {
    this.object = object;
    this.metas = {};
    return this;
}

function WidgedUrl(object) {
    this.object = object;
    this.meta = new WidgedMeta(object);
}
WidgedMeta.prototype.get = function(name, defaultVal) {
    if (typeof defaultVal == 'undefined') {
        var defaultVal = '';
    }
    var val = $(this.object).find('[name="meta_' + name + '"]').val();
    return val ? val : defaultVal;
}
WidgedMeta.prototype.all = function() {
    var _this = this;
    $(this.object).find('.widged-meta-data').each(function(index, el) {
        var key = $(this).attr('data-field')
        _this.metas[key] = $(this).val();
    });
    return this.metas;
}
WidgedMeta.prototype.set = function(name, value) {
    this.metas[name] = value;
    $(this.object).find('[name="meta_' + name + '"]').val(value);
    return this;
}
WidgedUrl.prototype.getData = function(handle) {
    var _this = this;
    var params = {
        success: function() {},
        fail: function() {},
        always: function() {}
    };
    handle = $.extend(true, params, handle);
    $.ajax({
        url: BASE_URL + 'administrator/widged/get_data',
        type: 'GET',
        dataType: 'JSON',
        data: _this.meta.all(),
    }).done(function(res) {
        handle.success(res);
    }).fail(function(res) {
        handle.fail(res);
    }).always(function() {
        handle.always();
    });
}
WidgedUrl.prototype.parseData = function(jqueryArray) {
    var _this = this;
    var params = {};
    $.each(jqueryArray, function(index, val) {
        params[val.name] = val.value;
    });
    return params;
}
WidgedUrl.prototype.get = function(handle) {
    var _this = this;
    var params = {
        params: {},
        widged_type: null,
        resource: null,
        success: function() {},
        fail: function() {},
        always: function() {}
    };
    handle = $.extend(true, params, handle);
    handle.params['_widged_type'] = this.meta.get('widged_type', handle.widged_type);
    handle.params['_widged_id'] = this.meta.get('id');
    handle.params['_resource'] = handle.resource;
    $.ajax({
        url: BASE_URL + 'administrator/widged/resource',
        type: 'GET',
        dataType: 'JSON',
        data: handle.params,
    }).done(function(res) {
        if (res.status == false) {
            handle.success(res);
            toastr['error']('Server error')
        } else {
            handle.success(res);
        }
    }).fail(function() {
        handle.fail();
    }).always(function() {
        handle.always();
    });
}
Widged.prototype.type = function(type) {
    this.type = type;
    return this;
}
Widged.prototype.target = function(object) {
    var _this = this;
    _this.object = object;
    return {
        meta: new WidgedMeta(object),
        url: new WidgedUrl(object),
        $: $(object),
        widgedBody: function(key) {
            return object.find('.widged-body');
        },
        instance: _this,
        object: object,
    };
}
Widged.prototype.targetByID = function(ID) {
    var object = $('.grid-stack-item[data-widged-id="' + ID + '"]');
    console.log(object);
    return this.target(object);
}
Widged.prototype.loading = function(show) {
    if (this.object.find('.loading-widged-wrapper').length == 0 && show == 1) {
        this.object.find('.box').prepend(`
            <div class="loading-widged-wrapper"><img src="` + BASE_URL + `asset/module/dashboard/img/loading-2.svg" width="50px"></div>
        `);
    } else if (show == 0) {
        this.object.find('.loading-widged-wrapper').fadeOut('slow', function() {
            this.remove();
        });
    }
}
Widged.prototype.changeTitle = function(title) {
    this.object.find('.box-title').html(title)
}
Widged.prototype.setup = function(fn) {
    var _this = this;
    dashboard.registerEachWidged(this.type, fn);
    $(document).find('[data-widged-type="' + this.type + '"]').each(function() {
        var widged = new Widged;
        var obj = $(this);
        var instance = widged.target(obj);
        fn(instance);
        return _this;
    });
}
Widged.prototype.setting = function() {
    var object = this.target(this.object);
    var _this = this;
    var container = $('.sidebar-widged-setting');
    /*.showLoaderComponent(container);*/
    sidebarWidgedSetting.showLoader();
    $.ajax({
        url: BASE_URL + 'administrator/widged/setting',
        type: 'GET',
        dataType: 'JSON',
        data: object.meta.all()
    }).done(function(res) {
        if (res.status) {
            container.find('.sidebar-body').html(res.contents)
        }
    }).fail(function() {}).always(function() {
        sidebarWidgedSetting.hideLoader();
        /* _this.hideLoaderComponent($('.sidebar-widged-setting'));*/
    });
    return this;
}
Widged.prototype.reloadAllWidged = function() {
    var grid = $('.grid-stack').data('gridstack');
    $.ajax({
        url: BASE_URL + 'administrator/widged/show_all_widged/' + dashboardSlug,
        type: 'GET',
        dataType: 'JSON'
    }).done(function(res) {
        if (res.status) {
            $('.grid-stack').html('');
            $.each(res.widgeds, function(index, val) {
                grid.addWidget(val);
            });
            dashboard.doEachWidged().doIntervalGetData();
        }
    }).fail(function() {}).always(function() {
        sidebarWidgedSetting.find('.btn-close-side-page').trigger('click')
    });
    return this;
}
var widged = new Widged;
var dashboard = new Dashboard();
var sidebarWidgedSetting = dashboard.createSidebar({
    name: 'sidebar-widged-setting',
    width: '400px',
    title: 'Widged Setting',
})
$(function() {
    sidebarWidgedSetting.withScroll()
    if (editMode) {
        $('.sidebar-toggle, .sidebar').remove();
        $('body').addClass('sidebar-collapse')
        $('.content-wrapper').attr('style', 'margin-left: 0px !important')
    }
    var grid = $('.grid-stack').data('gridstack');
    widged.reloadAllWidged()
    $(document).on('click', '.grid-stack-item .btn-setup-widged', function(event) {
        dashboard.showSidePage($('.sidebar-widged-setting'))
        widged.object = $(this).parents('.grid-stack-item');
        widged.setting();
        
        var wg = new Widged; 
        var instance = wg.target($(this).parents('.grid-stack-item'))       
        dashboard.selectedWidged = instance
    });
    $(document).on('click', '.btn-save-widged', function(event) {
        sidebarWidgedSetting.showLoader();
        $.ajax({
            url: BASE_URL + 'administrator/widged/update',
            type: 'POST',
            dataType: 'JSON',
            data: sidebarWidgedSetting.find('form').serialize()
        }).done(function(res) {
            if (res.status) {
                /*
                                widged.targetByID(res.data.id).object.replaceWith(res.data.view);*/
                widged.reloadAllWidged();
                sidebarWidgedSetting.find('.btn-close-side-page').trigger('click')
            } else {
                toastr['error']("Update failed")
            }
        }).fail(function() {}).always(function() {
            sidebarWidgedSetting.hideLoader();
            sidebarWidgedSetting.find('.btn-close-side-page').trigger('click')
        });
    });
    $(document).on('click', '.btn-delete-widged', function(event) {
        $.ajax({
            url: BASE_URL + 'administrator/widged/remove',
            type: 'GET',
            dataType: 'JSON',
            data: sidebarWidgedSetting.find('form').serialize()
        }).done(function(res) {
            if (res.status) {
                $('.widged-box[data-widged-uuid="' + res.data.uuid + '"]').remove();
                sidebarWidgedSetting.find('.btn-close-side-page').trigger('click')
            } else {
                toastr['error']("Delete failed")
            }
        }).fail(function() {}).always(function() {
            sidebarWidgedSetting.find('.btn-close-side-page').trigger('click')
        });
    });
    $(document).on('click', '.btn-duplicate-widged', function(event) {
        $.ajax({
            url: BASE_URL + 'administrator/widged/duplicate',
            type: 'GET',
            dataType: 'JSON',
            data: sidebarWidgedSetting.find('form').serialize()
        }).done(function(res) {
            if (res.status) {
                widged.reloadAllWidged();
                sidebarWidgedSetting.find('.btn-close-side-page').trigger('click')
            } else {
                toastr['error']("Duplicate failed")
            }
        }).fail(function() {}).always(function() {
            sidebarWidgedSetting.find('.btn-close-side-page').trigger('click')
        });
    });
    var intDashboardTitle = null;
    $(document).on('keypress', 'h1.dashboard-title', function(event) {
        if (event.charCode == 13) {
            event.preventDefault();
        }
        var $this = $(this);
        clearInterval(intDashboardTitle);
        intDashboardTitle = setTimeout(function() {
            $.ajax({
                url: BASE_URL + 'administrator/dashboard/change_title',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    title: $this.text(),
                    id: dashboardConf.id
                }
            }).done(function(res) {}).fail(function() {}).always(function() {});
        }, 500);
    });

    function widgedMap() {
        var node;
        return _.map($('.grid-stack .grid-stack-item:visible'), function(el) {
            el = $(el);
            node = el.data('_gridstack_node');
            if (!node) {
                return false;
            }
            return {
                type: el.attr('data-widged-type'),
                id: el.attr('data-widged-uuid'),
                x: node.x,
                y: node.y,
                width: node.width,
                height: node.height
            };
        });
    }

    function saveWidgedSize() {
        var params = {};
        params[csrf] = token;
        params['widgeds'] = widgedMap();
        $.ajax({
            url: BASE_URL + 'administrator/widged/save_size',
            type: 'POST',
            dataType: 'JSON',
            data: params,
        }).done(function(response) {
            if (response.status) {} else {
                toastr['error']('Error', 'Error when reordering widgets..');
            }
        }).fail(function() {}).always(function() {});
    }
    $('.grid-stack').on('change', function(event, items) {
        saveWidgedSize();
    });
    $('.remove-dashboard').on('click', function() {
        var url = $(this).attr('data-href');
        swal({
            title: "Are you sure ?",
            text: "data to delete can not restored ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "yes",
            cancelButtonText: "cancel",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                document.location.href = url;
            }
        });
        return false;
    });


})