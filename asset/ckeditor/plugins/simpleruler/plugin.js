/**
 * Copyright (c) 2016, LOVATA - Aleksandra Shinkevich (a.shinkevich@lovata.com). All rights reserved.
 * For licensing, see LICENSE.md
 *
 * A simple ruler plugin for CKEditor (http://ckeditor.com)
 *
 * Require:
 * - nouislider (github.com/leongersen/noUiSlider) for ranging
 * - jquery (github.com/jquery/jquery) for DOM traversing
 */

window.noUiSlider = require('nouislider');
if (!window.$) {
    window.$ = require('jquery');
}

CKEDITOR.plugins.add('ruler', {
    init: function(editor) {
        var width = 800;
        var configs = getConfigs(editor.config.ruler);

        editor.addContentsCss(this.path + 'styles/editor-iframe-styles.css');
        editor.on('instanceReady', function() {
            var $ckeContent = $(editor.element.$).siblings('.cke').find('.cke_contents');
            $ckeContent.prepend('<div id="cke_ruler_wrap"></div>');
            var range = document.getElementById('cke_ruler_wrap');
            setPadding([configs.sliders.left, configs.sliders.right]);
            noUiSlider.create(range, {
                start: [configs.sliders.left, configs.sliders.right],
                margin: 2,
                connect: [true, false, true],
                behaviour: 'drag',
                step: configs.step,
                range: {
                    'min': 0,
                    'max': configs.values
                },
                pips: {
                    mode: 'count',
                    values: configs.values,
                    density: 2
                }
            });
            range.noUiSlider.on('change', function(values) {
                setPadding(values);
            });
        });
        editor.on('change', function(evt) {
            setPadding();
        });
        editor.on('setRulerPadding', function(evt) {
            setPadding([evt.data.left, evt.data.right]);
            var range = document.getElementById('cke_ruler_wrap');
            range.noUiSlider.set([evt.data.left, evt.data.right]);
        });

        function setPadding(values) {
            if (values) {
                configs.sliders.left = parseFloat(values[0]);
                configs.sliders.right = parseFloat(values[1]);
            }
            var left = (width / configs.values) * configs.sliders.left;
            var right = (width / configs.values) * (configs.values - configs.sliders.right);
            editor.document.getBody().setStyle('padding', configs.padding.top + 'px ' + right + 'px ' + configs.padding.bottom + 'px ' + left + 'px');
            editor.fire('updateRuler', configs.sliders);
        }

        function getConfigs(config) {
            var defaultConfig = {
                values: 21, // segment number of the ruler
                step: 0.25, // accuracy of sliders
                sliders: {
                    left: 2, // left slider value
                    right: 19 // right slider value (21-19 = 2)
                },
                padding: {
                    top: 20, // top 'canvas' padding (px)
                    bottom: 20 // bottom 'canvas' padding (px)
                }
            };
            if (!config) {
                // Oops, no configs
                config = defaultConfig;
            } else {
                if (!config.sliders) {
                    // Oops, no sliders info
                    config.sliders = defaultConfig.sliders;
                } else {
                    if (!config.sliders.hasOwnProperty('left')) {
                        config.sliders.left = defaultConfig.sliders.left;
                    }
                    if (!config.sliders.hasOwnProperty('right')) {
                        config.sliders.right = defaultConfig.sliders.right;
                    }
                }
                if (!config.padding) {
                    // Oops, no padding info
                    config.padding = defaultConfig.padding;
                } else {
                    if (!config.padding.hasOwnProperty('top')) {
                        config.padding.top = defaultConfig.padding.top;
                    }
                    if (!config.padding.hasOwnProperty('bottom')) {
                        config.padding.bottom = defaultConfig.padding.bottom;
                    }
                }
                if (!config.hasOwnProperty('values')) {
                    // Oops, no values info
                    config.values = defaultConfig.values;
                } else if (config.values < config.sliders.right) {
                    // Oops, values is less then right slider value
                    config.values = config.sliders.right;
                }
                if (!config.hasOwnProperty('step')) {
                    // Oops, no step info
                    config.step = defaultConfig.step;
                }
            }
            return config;
        }
    }
});
