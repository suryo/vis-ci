# Simple Ruler

[![Build Status](https://travis-ci.org/lovata/ckeditor-ruler.svg?branch=master)](https://travis-ci.org/lovata/ckeditor-ruler) [![npm version](https://badge.fury.io/js/ckeditor-ruler.svg)](https://badge.fury.io/js/ckeditor-ruler)

## Description

A ruler plugin for [CKEditor](http://ckeditor.com) displays the horizontal dimension of the page. You can modify it on the ruler using a mouse.

## Demo
You can try it on the [demo page](https://lovata.github.io/ckeditor-ruler/).


## Getting Started

### Manual

[Download](http://ckeditor.com/addon/simple-ruler) the plugin from the official CKEditor add-ons list and enable them by editing `config.js`:

```js
config.extraPlugins = 'ruler';
```
### NPM

Install Simple Ruler as a development dependency:

```bash
npm install ckeditor-ruler --save-dev
```

Init CKEditor with the plugin:

```js
window.onload = function() {
    CKEDITOR.plugins.addExternal('ruler', '/node_modules/ckeditor-ruler/');
    CKEDITOR.config.extraPlugins = 'ruler';
    CKEDITOR.replace('editor');
};

```
## Options
```javascript
CKEDITOR.config.ruler = {
    values: 21,     // segment number of the ruler
    step: 0.25,     // accuracy of sliders
    sliders: {
        left: 2,    // left slider value
        right: 19   // right slider value (21-19 = 2)
    },
    padding: {
        top: 20,    // top 'canvas' padding (px)
        bottom: 20  // bottom 'canvas' padding (px)
    }
};
```

## API
Plugin dispatches `updateRuler` event as soon as any of slider's values have been changed:

```js
editor.fire('updateRuler', { left: Number, right: Number });
```

Plugin is subscribed to `setRulerPadding` editor's event, so you can fire the event to change ruler's values programmatically:

```js
editor.fire('setRulerPadding', { left: Number, right: Number });
```

## Browser compatibility
Originally this plugin was build for an [Electron](https://github.com/electron/electron) library, therefore it wasn't tested in other browsers.

## License

© 2016, [LOVATA Group, LLC](http://lovata.com) under GNU GPL v3.

Develped by [Aleksandra Shinkevich](https://github.com/neesoglasnaja).
