"use strict";

function initSortable(module_name, table, prefix) {
  if (typeof prefix == 'undefined') {
    prefix = 'administrator';
  }
  var url = new URL(window.location);
  var qst = url.searchParams.get("st");
  var qsb = url.searchParams.get("sb");
  var q = url.searchParams.get("q");
  var f = url.searchParams.get("f");
  table.find('thead th').each(function (index, el) {

    var sb = $(this).data('field')
    var icon = '<i class=" fa fa-sort"></i>';

    if (qsb == $(this).data('field')) {
      var sort = 'desc';
      if (qst == 'ASC') {
        sort = 'asc';
      }

      icon = '<i class=" fa fa-sort-' + sort + '"></i>';
    }

    if (qst == null && qsb == null && $(this).data('primary-key')) {
      icon = '<i class=" fa fa-sort-desc"></i>';
    }

    if ($(this).data('sort')) {
      $(this).append(` ` + icon)
      $(this).css('cursor', 'pointer')
      $(this).on('click', function (event) {
        var st = 'ASC';
        if (qsb == sb) {
          if (qst == 'ASC') {
            st = 'DESC';
          }
        }
        window.location = BASE_URL + prefix + '/' + module_name + '?st=' + st + '&sb=' + sb + '&q=' + (q ? q : '') + '&f=' + (f ? f : '')
      });
    }
  });
}


function initChosen() {

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

function showPopup(url, callback) {
  if (url == false) {
    $('#modalPopUp').modal('hide')

  } else {
    $('#modalPopUp').modal('show')
    $('#modalPopUp').find('.modal-body').html(`
      <center>
      <img src="`+ BASE_URL + `/asset/img/loading-spin-primary.svg" style="width:50px; width:50px;">
      </center>
      `);
    $('#modalPopUp').find('.modal-body').load(url, function () {
      callback()
    });
  }

}

function parseErrorField(errors) {
  $.each(errors, function (index, val) {
    $('form #' + index).parents('.form-group').addClass('has-error');
    $('form #' + index).parents('.form-group').find('small').prepend(`
          <div class="error-input">`+ val + `</div>
          `);
  });
  $('.content section').each(function (index, el) {
    if ($(this).find('.has-error').length) {
      $('.steps li:eq(' + index + ')').addClass('error').find('a').trigger('click');
    }
  });
}

jQuery.expr[':'].regex = function (elem, index, match) {
  var matchParams = match[3].split(','),
    validLabels = /^(data|css):/,
    attr = {
      method: matchParams[0].match(validLabels) ?
        matchParams[0].split(':')[0] : 'attr',
      property: matchParams.shift().replace(validLabels, '')
    },
    regexFlags = 'ig',
    regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g, ''), regexFlags);
  return regex.test(jQuery(elem)[attr.method](attr.property));
}

function resetForm() {
  $('form input[type = text], form input[type = email], form input[type = number], form input[type = password], form textarea').val('');
  $('form textarea').text('');
  $('.data_file').val('');
  $('input.flat-red').each(function (index, element) {
    $(element).iCheck('uncheck');
  });
  $('.refresh-captcha').trigger('click');
}
function getUnixId() {
  return Date.now();;

}
var config_choosen = {
  '.chosen-select': {},
  '.chosen-select-deselect': {
    allow_single_deselect: true
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

function getStyle(target, css_to_find) {
  var style = target.attr('style').trim().split(';');
  var selected = '';
  $.each(style, function (index, val) {
    var css = val.trim().split(':');
    var css_name = typeof css[0] != 'undefined' ? css[0].trim() : false;
    var css_val = typeof css[1] != 'undefined' ? css[1].trim() : false;

    if (css_name) {
      if (css_name == css_to_find) {
        selected = css_val;
      }
    }
  });

  return selected;
}

function goUrl(url) {
  document.location = BASE_URL + url;
}

$(document).ready(function () {

  $('a, button, input[type=submit], .tip').tooltip();

  $('.fancybox').each(function (index, el) {
    $(this).fancybox();
  });

  toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "preventDuplicates": true,
    "progressBar": false,
    "rtl": false,
    "positionClass": "toast-top-center",
    "onclick": null,
    "showDuration": 300,
    "hideDuration": 1000,
    "timeOut": 5000,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }

  $('.demo-version, .demo-version a').on('click', function () {
    toastr['warning']("Sorry, demo version can't be accessed this!", "Warning!");

    return false;
  }); /*end demo version click*/

  /*add activer menu side bar*/
  var i = $('.sidebar-menu li.active').parents('li').addClass('active');


  if (typeof $('form input')[1] != 'undefined') {
    $('form input')[1].focus();
  }

  /*show loading*/
  $.fn.loader = function (opsi) {
    $(this).html('<span class="loading loading-hide pull-right padding-10"><img src="' + BASE_URL + 'asset/img/loading-spin-primary.svg"> <i>Loading, Submitting Data</i></span>');
  };

  /*print message*/
  $.fn.printMessage = function (opsi) {
    var opsi = $.extend({
      type: 'success',
      message: 'Success',
      timeout: 500000
    }, opsi);

    $(this).hide();
    $(this).html(' <div class="col-md-12 message-alert" ><div class="callout callout-' + opsi.type + '"><h4>' + opsi.type + '!  <a href="#" class="close pull-right" >&times;</a></h4>' + opsi.message + '</div></div>');
    $(this).show();
    // Run the effect
    setTimeout(function () {
      $('.message-alert').fadeOut();
    }, opsi.timeout);

    var parentElem = $(this);

    $(this).find('.message-alert .close').on('click', function (event) {
      event.preventDefault();
      parentElem.html('');
    });
  };

  $.fn.btnSpinner = function (option) {


    var toggle = typeof option == 'undefined' ? 'show' : option;

    if (toggle == 'show') {
      if ($(this).find('.fa-spin').length == 0) {
        $(this).addClass('disabled');
        $(this).prepend(`<i class="fa fa-spin fa-refresh text-danger"></i> `);
      }
    } else {
      $(this).removeClass('disabled');
      $(this).find('.fa-spin').remove();
    }
  };

  /*replace all string*/
  String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
  };

  /*show  hide password*/
  $('.input-password').each(function (index, el) {
    var eye = $(this).parent().parent().find('.eye');
    $(this).find('.show-password').mousedown(function () {
      $(this).parent().parent().find('.password').attr('type', 'text');
      eye.addClass('fa-eye-slash');
      eye.removeClass('fa-eye');
    });
    $(this).find('.show-password').mouseup(function () {
      $(this).parent().parent().find('.password').attr('type', 'password');
      eye.removeClass('fa-eye-slash');
      eye.addClass('fa-eye');
    });
  });

  $('.datepicker').each(function (index, el) {
    $(this).datetimepicker({
      timepicker: false,
      formatDate: 'Y.m.d',

    });
  });

  $('.datepicker').each(function (index, el) {
    $(this).inputmask({
      mask: "y-1-2",
      placeholder: "yyyy-mm-dd",
      leapday: "-02-29",
      separator: "-",
      alias: "yyyy/mm/dd"
    });
  });

  $('.datetimepicker').each(function (index, el) {
    $(this).inputmask({
      mask: "y-1-2 h:s",
      placeholder: "yyyy-mm-dd hh:mm",
      leapday: "-02-29",
      separator: "-",
      alias: "yyyy/mm/dd"
    });
  });

  $('.datetimepicker').each(function (index, el) {
    $(this).datetimepicker({
      formatTime: 'H:i',
      formatDate: 'yyyy-mm-dd hh:ii',
    });
  });

  $('.timepicker').each(function (index, el) {
    $(this).inputmask({
      mask: "h:s",
      placeholder: "hh:mm",
      leapday: "-02-29",
      separator: "-",
      alias: "yyyy/mm/dd"
    });
  });

  $('.timepicker').each(function (index, el) {
    $(this).datetimepicker({
      datepicker: false,
      format: 'H:i',
      step: 5
    });
  });


  initChosen();

  //Flat red color scheme for iCheck
  $('input[type="radio"].flat-red').each(function (index, el) {
    $(this).iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
  });


  $('a[data-toggle="tab"].tab_animation').on('shown.bs.tab', function (e) {
    var target = $(this).attr('href');

    $(target).css('top', '-' + $(window).height() + 'px');
    var top = $(target).offset().left;
    $(target).css({ top: top }).animate({ "top": "0px" }, {
      duration: 'slow',
      specialEasing: {
        height: "easeInOutQuart"
      }
    }
    );
  });


  $('.popup-view').on('click', function (event) {
    event.preventDefault();

    var url = $(this).attr('href');
    showPopup(url, function () {
      $('#modalPopUp').find('#btn_edit, #btn_back').hide();
      $('#modalPopUp').find('.col-md-7').removeClass('col-md-7');
    });
  });


  setTimeout(function () {
    if ($('.steps').length) {
      var totalSteps = $('.steps ul li').length;
      if (totalSteps < 10) {
        $('.steps ul li').css('width', 100 / totalSteps + '%');
      }
      $('.steps ul li').each(function () {
        var content = $(this).find('a').clone();
        $(this).find('a').html('');
        content.find('.number').html(content.find('.number').html().replace('.', ''))
        content.find('.number').appendTo($(this).find('a'))
        content.find('.number').remove();
        $(this).append('<br>' + content.html());
      })

      $('.steps').append('<div class="rectangle-wizzard"></div>')
      /* $('.steps').append('<div class="round-left"></div>')
       $('.steps').append('<div class="round-right"></div>')*/
    }
  }, 50);


  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_minimal-red',
    radioClass: 'iradio_minimal-red'
  });


});
