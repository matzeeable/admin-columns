/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./js/admin-page-columns.ts":
/*!**********************************!*\
  !*** ./js/admin-page-columns.ts ***!
  \**********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _admin_columns_form__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./admin/columns/form */ "./js/admin/columns/form.ts");
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./constants */ "./js/constants.ts");
/* harmony import */ var _helpers_admin_columns__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./helpers/admin-columns */ "./js/helpers/admin-columns.ts");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _admin_columns_column_configurator__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./admin/columns/column-configurator */ "./js/admin/columns/column-configurator.ts");


 // @ts-ignore



Object(_helpers_admin_columns__WEBPACK_IMPORTED_MODULE_2__["initAdminColumnsGlobalBootstrap"])();
new _admin_columns_column_configurator__WEBPACK_IMPORTED_MODULE_4__["default"]();
document.addEventListener('DOMContentLoaded', function () {
  new SaveButtons();
  var formElement = document.querySelector('#listscreen_settings');

  if (formElement) {
    AdminColumns.Form = new _admin_columns_form__WEBPACK_IMPORTED_MODULE_0__["Form"](formElement, AdminColumns.events);
  }
});
AdminColumns.events.addListener(_constants__WEBPACK_IMPORTED_MODULE_1__["EventConstants"].SETTINGS.FORM.LOADED, function (form) {
  document.querySelectorAll('.add_column').forEach(function (el) {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      form.createNewColumn();
    });
  });
  document.querySelectorAll('a[data-clear-columns]').forEach(function (el) {
    el.addEventListener('click', function () {
      return form.resetColumns();
    });
  });
});
AdminColumns.events.addListener(_constants__WEBPACK_IMPORTED_MODULE_1__["EventConstants"].SETTINGS.FORM.SAVING, function () {
  document.querySelector('#cpac .ac-admin').classList.add('saving');
});
AdminColumns.events.addListener(_constants__WEBPACK_IMPORTED_MODULE_1__["EventConstants"].SETTINGS.FORM.SAVED, function () {
  document.querySelector('#cpac .ac-admin').classList.remove('saving');
  document.querySelector('#cpac .ac-admin').classList.add('stored');
});
AdminColumns.events.addListener(_constants__WEBPACK_IMPORTED_MODULE_1__["EventConstants"].SETTINGS.FORM.LOADED, function (form) {
  var $form = jquery__WEBPACK_IMPORTED_MODULE_3___default()(form.getElement());

  if ($form.hasClass('ui-sortable')) {
    $form.sortable('refresh');
  } else {
    $form.sortable({
      items: '.ac-column',
      handle: '.column_sort'
    });
  }
});
AdminColumns.events.addListener(_constants__WEBPACK_IMPORTED_MODULE_1__["EventConstants"].SETTINGS.FORM.LOADED, function (form) {
  document.querySelectorAll('a[data-clear-columns]').forEach(function (el) {
    el.addEventListener('click', function () {
      return form.resetColumns();
    });
  });
});

var SaveButtons =
/** @class */
function () {
  function SaveButtons() {
    this.elements = document.querySelectorAll('.sidebox a.submit, .column-footer a.submit');
    this.init();
  }

  SaveButtons.prototype.init = function () {
    var _this = this;

    AdminColumns.events.addListener(_constants__WEBPACK_IMPORTED_MODULE_1__["EventConstants"].SETTINGS.FORM.READY, function (form) {
      _this.elements.forEach(function (el) {
        el.addEventListener('click', function (e) {
          e.preventDefault();

          _this.disable();

          form.submitForm();
        });
      });
    });
    AdminColumns.events.addListener(_constants__WEBPACK_IMPORTED_MODULE_1__["EventConstants"].SETTINGS.FORM.SAVED, function () {
      return _this.enable();
    });
  };

  SaveButtons.prototype.disable = function () {
    this.elements.forEach(function (el) {
      return el.setAttribute('disabled', 'disabled');
    });
  };

  SaveButtons.prototype.enable = function () {
    this.elements.forEach(function (el) {
      return el.removeAttribute('disabled');
    });
  };

  return SaveButtons;
}();

/***/ }),

/***/ "./js/admin/columns/ajax.ts":
/*!**********************************!*\
  !*** ./js/admin/columns/ajax.ts ***!
  \**********************************/
/*! exports provided: submitColumnSettings, _switchColumnType, switchColumnType, refreshColumn */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "submitColumnSettings", function() { return submitColumnSettings; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "_switchColumnType", function() { return _switchColumnType; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "switchColumnType", function() { return switchColumnType; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "refreshColumn", function() { return refreshColumn; });
var axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");

var submitColumnSettings = function (data) {
  var formData = mapDataToFormData({
    action: 'ac-columns',
    id: 'save',
    _ajax_nonce: AC._ajax_nonce,
    data: data
  });
  return axios.post(ajaxurl, formData);
};

var mapDataToFormData = function (data, formData) {
  if (formData === void 0) {
    formData = null;
  }

  if (!formData) {
    formData = new FormData();
  }

  Object.keys(data).forEach(function (key) {
    formData.append(key, data[key]);
  });
  return formData;
};

var _switchColumnType = function (type, data) {
  var formData = mapDataToFormData({
    _ajax_nonce: AC._ajax_nonce,
    action: 'ac-columns',
    id: 'select',
    type: type,
    data: data,
    current_original_columns: JSON.stringify(AdminColumns.Form.getOriginalColumns())
  });
  return axios.post(ajaxurl, formData);
};
var switchColumnType = function (type, list_screen) {
  if (list_screen === void 0) {
    list_screen = AC.list_screen;
  }

  var formData = mapDataToFormData({
    _ajax_nonce: AC._ajax_nonce,
    action: 'ac-columns',
    id: 'select',
    type: type,
    list_screen: list_screen,
    current_original_columns: JSON.stringify(AdminColumns.Form.getOriginalColumns().map(function (e) {
      return e.getName();
    }))
  });
  return axios.post(ajaxurl, formData);
};
var refreshColumn = function (name, data, list_screen) {
  if (list_screen === void 0) {
    list_screen = AC.list_screen;
  }

  var formData = mapDataToFormData({
    _ajax_nonce: AC._ajax_nonce,
    action: 'ac-columns',
    id: 'refresh',
    column_name: name,
    data: data,
    list_screen: list_screen,
    current_original_columns: JSON.stringify(AdminColumns.Form.getOriginalColumns().map(function (e) {
      return e.getName();
    }))
  });
  return axios.post(ajaxurl, formData);
};

/***/ }),

/***/ "./js/admin/columns/column-configurator.ts":
/*!*************************************************!*\
  !*** ./js/admin/columns/column-configurator.ts ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../constants */ "./js/constants.ts");
/* harmony import */ var _events_toggle__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./events/toggle */ "./js/admin/columns/events/toggle.ts");
/* harmony import */ var _events_indicator__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./events/indicator */ "./js/admin/columns/events/indicator.ts");
/* harmony import */ var _events_type_selector__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./events/type-selector */ "./js/admin/columns/events/type-selector.ts");
/* harmony import */ var _events_refresh__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./events/refresh */ "./js/admin/columns/events/refresh.ts");
/* harmony import */ var _events_remove__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./events/remove */ "./js/admin/columns/events/remove.ts");
/* harmony import */ var _events_clone__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./events/clone */ "./js/admin/columns/events/clone.ts");
/* harmony import */ var _events_label__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./events/label */ "./js/admin/columns/events/label.ts");
/* harmony import */ var _settings_label__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./settings/label */ "./js/admin/columns/settings/label.ts");










var ColumnConfigurator =
/** @class */
function () {
  function ColumnConfigurator() {
    AdminColumns.events.addListener(_constants__WEBPACK_IMPORTED_MODULE_0__["EventConstants"].SETTINGS.COLUMN.INIT, function (column) {
      Object(_events_toggle__WEBPACK_IMPORTED_MODULE_1__["initToggle"])(column);
      Object(_events_indicator__WEBPACK_IMPORTED_MODULE_2__["initIndicator"])(column);
      Object(_events_type_selector__WEBPACK_IMPORTED_MODULE_3__["initTypeSelector"])(column);
      Object(_events_refresh__WEBPACK_IMPORTED_MODULE_4__["initColumnRefresh"])(column);
      Object(_events_remove__WEBPACK_IMPORTED_MODULE_5__["initRemoveColumn"])(column);
      Object(_events_clone__WEBPACK_IMPORTED_MODULE_6__["initClone"])(column);
      Object(_events_label__WEBPACK_IMPORTED_MODULE_7__["initLabel"])(column);
      Object(_events_label__WEBPACK_IMPORTED_MODULE_7__["initLabelSetting"])(column);
      new _settings_label__WEBPACK_IMPORTED_MODULE_8__["default"](column);
    });
  }

  return ColumnConfigurator;
}();

/* harmony default export */ __webpack_exports__["default"] = (ColumnConfigurator);

/***/ }),

/***/ "./js/admin/columns/column.ts":
/*!************************************!*\
  !*** ./js/admin/columns/column.ts ***!
  \************************************/
/*! exports provided: COLUMN_EVENTS, Column */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "COLUMN_EVENTS", function() { return COLUMN_EVENTS; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Column", function() { return Column; });
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../constants */ "./js/constants.ts");
/* harmony import */ var nanobus__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! nanobus */ "./node_modules/nanobus/index.js");
/* harmony import */ var nanobus__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(nanobus__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _ajax__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./ajax */ "./js/admin/columns/ajax.ts");
/* harmony import */ var _helpers_elements__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../helpers/elements */ "./js/helpers/elements.ts");
/* harmony import */ var _helpers_columns__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../helpers/columns */ "./js/helpers/columns.ts");
/* harmony import */ var _helpers_animations__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../helpers/animations */ "./js/helpers/animations.ts");
// @ts-ignore







var STATES = {
  CLOSED: 'closed',
  OPEN: 'open'
};
var COLUMN_EVENTS = {
  REMOVE: 'remove',
  CLONE: 'clone'
};

var Column =
/** @class */
function () {
  function Column(element, name) {
    this.events = new nanobus__WEBPACK_IMPORTED_MODULE_2___default.a();
    this.name = name;
    this.element = element;
    this.state = STATES.CLOSED;
    this.setPropertiesByElement(element);
  }

  Column.prototype.setPropertiesByElement = function (element) {
    this.type = element.dataset.type;
    this.original = element.dataset.original === '1';
    this.disabled = element.classList.contains('disabled');
    return this;
  };

  Column.prototype.getName = function () {
    return this.name;
  };

  Column.prototype.getType = function () {
    return this.type;
  };

  Column.prototype.isOriginal = function () {
    return this.original;
  };

  Column.prototype.getElement = function () {
    return this.element;
  };

  Column.prototype.isDisabled = function () {
    return this.element.classList.contains('disabled');
  };

  Column.prototype.disable = function () {
    this.element.classList.add('disabled');
    return this;
  };

  Column.prototype.setLoading = function (enabled) {
    enabled ? this.getElement().classList.add('loading') : this.getElement().classList.remove('loading');
    return this;
  };

  Column.prototype.enable = function () {
    this.element.classList.remove('disabled');
    return this;
  };

  Column.prototype.init = function () {
    AdminColumns.events.emit(_constants__WEBPACK_IMPORTED_MODULE_1__["EventConstants"].SETTINGS.COLUMN.INIT, this);
    return this;
  };

  Column.prototype.initNewInstance = function () {
    var temp_column_name = '_new_column_' + AC.Column.getNewIncementalName();
    var original_column_name = this.name;
    this.$el.find('input, select, label').each(function (i, v) {
      var $input = jQuery(v); // name attributes

      if ($input.attr('name')) {
        $input.attr('name', $input.attr('name').replace("columns[" + original_column_name + "]", "columns[" + temp_column_name + "]"));
      } // id attributes


      if ($input.attr('id')) {
        $input.attr('id', $input.attr('id').replace("-" + original_column_name + "-", "-" + temp_column_name + "-"));
      }
    });
    this.name = temp_column_name;
    AC.incremental_column_name++;
    return this;
  };
  /**
   *
   * @returns {Column}
   */


  Column.prototype.bindEvents = function () {
    var column = this;
    column.$el.data('column', column);
    Object.keys(AC.Column.events).forEach(function (key) {
      if (!column.isBound(key)) {
        AC.Column.events[key](column);
        column.bind(key);
      }
    });
    return this;
  };

  Column.prototype.destroy = function () {
    this.element.remove();
  };

  Column.prototype.remove = function (duration) {
    var _this = this;

    if (duration === void 0) {
      duration = 350;
    }

    this.events.emit(COLUMN_EVENTS.REMOVE, this);
    Object(_helpers_animations__WEBPACK_IMPORTED_MODULE_6__["fadeOut"])(this.getElement(), duration, function () {
      _this.destroy();
    });
  };

  Column.prototype.getState = function () {
    return this.state;
  };

  Column.prototype.toggle = function (duration) {
    if (duration === void 0) {
      duration = 150;
    }

    this.getState() === STATES.OPEN ? this.close(duration) : this.open(duration);
  };

  Column.prototype.close = function (duration) {
    if (duration === void 0) {
      duration = 0;
    }

    this.getElement().classList.remove('opened');
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(this.getElement()).find('.ac-column-body').slideUp(duration);
    this.state = STATES.CLOSED;
  };

  Column.prototype.open = function (duration) {
    if (duration === void 0) {
      duration = 0;
    }

    this.getElement().classList.add('opened');
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(this.getElement()).find('.ac-column-body').slideDown(duration);
    this.state = STATES.OPEN;
  };

  Column.prototype.showMessage = function (message) {
    var msgElement = this.getElement().querySelector('.ac-column-setting--type .msg');

    if (msgElement) {
      msgElement.innerHTML = message;
      msgElement.style.display = 'block';
    }
  };

  Column.prototype.getJson = function () {
    var r = {};
    this.getElement().querySelectorAll('input, select, textarea ').forEach(function (formEl) {
      var nameParts = formEl.name.split('[').map(function (p) {
        return p.split(']')[0];
      });
      var setter = r;
      var i = 0;
      nameParts.forEach(function (part) {
        i++;

        if (!setter.hasOwnProperty(part)) {
          setter[part] = i === nameParts.length ? formEl.value : {};
        }

        setter = setter[part];
      });
    });
    return r['columns'][this.getName()];
  };

  Column.prototype.switchToType = function (type) {
    var _this = this;

    this.setLoading(true);
    Object(_ajax__WEBPACK_IMPORTED_MODULE_3__["switchColumnType"])(type).then(function (response) {
      if (response.data.success) {
        var name_1 = Object(_helpers_columns__WEBPACK_IMPORTED_MODULE_5__["createColumnName"])();
        var element = Object(_helpers_elements__WEBPACK_IMPORTED_MODULE_4__["createElementFromString"])(response.data.data.trim()).firstChild;
        setColumnNameToFormElements(name_1, element);
        _this.name = name_1;

        _this.reinitColumnFromElement(element);
      } else {
        _this.showMessage(response.data.data.error);
      }
    }).finally(function () {
      return _this.setLoading(false);
    });
  };

  Column.prototype.refresh = function () {
    var _this = this;

    this.setLoading(true);
    Object(_ajax__WEBPACK_IMPORTED_MODULE_3__["refreshColumn"])(this.getName(), JSON.stringify(this.getJson())).then(function (response) {
      if (response.data.success) {
        _this.reinitColumnFromElement(Object(_helpers_elements__WEBPACK_IMPORTED_MODULE_4__["createElementFromString"])(response.data.data.trim()).firstChild);
      } else {
        _this.showMessage('sdfsdfsdf');
      }
    }).finally(function () {
      return _this.setLoading(false);
    });
  };

  Column.prototype.reinitColumnFromElement = function (element) {
    this.getElement().parentNode.replaceChild(element, this.getElement());
    this.element = element;
    this.setPropertiesByElement(element).init().open();
  };
  /**
   * @returns {Column}
   */


  Column.prototype.create = function () {// TODO move out ckass

    /*this.initNewInstance();
    this.bindEvents();
     jQuery(document).trigger('AC_Column_Created', [this]);
    return this;*/
  };

  Column.prototype.clone = function () {// TODO move out class

    /*let $clone = this.$el.clone();
    $clone.data('column-name', this.$el.data('column-name'));
     let clone = new Column($clone);
     clone.initNewInstance();
    clone.bindEvents();
     return clone;*/
  };

  return Column;
}();



var setColumnNameToFormElements = function (name, columnElement) {
  columnElement.querySelectorAll('input, select').forEach(function (element) {
    element.setAttribute('name', element.getAttribute('name').toString().replace('columns[]', "columns[" + name + "]"));
  });
};

/***/ }),

/***/ "./js/admin/columns/events/clone.ts":
/*!******************************************!*\
  !*** ./js/admin/columns/events/clone.ts ***!
  \******************************************/
/*! exports provided: initClone */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "initClone", function() { return initClone; });
/* harmony import */ var _column__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../column */ "./js/admin/columns/column.ts");
/*
* Column: bind clone events
*
* @since 2.0
*/

var initClone = function (column) {
  column.getElement().querySelectorAll('.clone-button').forEach(function (element) {
    element.addEventListener('click', function (e) {
      e.preventDefault();

      if (!column.isOriginal()) {
        column.events.emit(_column__WEBPACK_IMPORTED_MODULE_0__["COLUMN_EVENTS"].CLONE);
      }
    });
  });
};

/***/ }),

/***/ "./js/admin/columns/events/indicator.ts":
/*!**********************************************!*\
  !*** ./js/admin/columns/events/indicator.ts ***!
  \**********************************************/
/*! exports provided: initIndicator */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "initIndicator", function() { return initIndicator; });
var initIndicator = function (column) {
  if (column.isDisabled()) return;
  column.getElement().querySelectorAll('.ac-column-header [data-indicator-toggle]').forEach(function (toggleElement) {
    var relatedSettings = column.getElement().querySelectorAll(".ac-column-setting[data-setting='" + toggleElement.dataset.setting + "'] .col-input .ac-setting-input:first-child input[type=radio]");
    toggleElement.addEventListener('click', function () {
      switchTo(!toggleElement.classList.contains('on'), relatedSettings);
    });
    relatedSettings.forEach(function (element) {
      element.addEventListener('change', function () {
        element.value === 'off' ? toggleElement.classList.remove('on') : toggleElement.classList.add('on');
      });
    });
  });
};

var switchTo = function (checked, elements) {
  var checkvalue = checked ? 'on' : 'off';
  elements.forEach(function (el) {
    if (el.value === checkvalue) {
      el.checked = true;
      el.dispatchEvent(new Event('change'));
      el.dispatchEvent(new Event('click'));
    }
  });
};

/***/ }),

/***/ "./js/admin/columns/events/label.ts":
/*!******************************************!*\
  !*** ./js/admin/columns/events/label.ts ***!
  \******************************************/
/*! exports provided: initLabel, initLabelSetting */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "initLabel", function() { return initLabel; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "initLabelSetting", function() { return initLabelSetting; });
var initLabel = function (column) {
  column.getElement().querySelectorAll('select[data-label="update"]').forEach(function (select) {
    select.addEventListener('change', function () {
      var labelSetting = column.getElement().querySelector('input.ac-setting-input_label');
      var option = select.querySelector('option:selected');

      if (labelSetting && option) {
        labelSetting.value = option.innerHTML;
        labelSetting.dispatchEvent(new Event('change'));
      }
    });
  });
  setTimeout(function () {
    var label = column.getElement().querySelector('.column_label .toggle');

    if (label && label.offsetWidth < 10) {
      label.innerText = column.getType();
    }
  }, 50);
};
var initLabelSetting = function (column) {
  var labelInput = column.getElement().querySelector('.ac-column-setting--label input');

  if (!labelInput) {
    return;
  }

  labelInput.addEventListener('change', function () {
    return changeLabel(labelInput, column);
  });
  labelInput.addEventListener('keyup', function () {
    return changeLabel(labelInput, column);
  });
};

var changeLabel = function (labelInput, column) {
  column.getElement().querySelector('td.column_label .inner > a.toggle').innerHTML = labelInput.value;
};

/***/ }),

/***/ "./js/admin/columns/events/refresh.ts":
/*!********************************************!*\
  !*** ./js/admin/columns/events/refresh.ts ***!
  \********************************************/
/*! exports provided: initColumnRefresh, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "initColumnRefresh", function() { return initColumnRefresh; });
var initColumnRefresh = function (column) {
  column.getElement().querySelectorAll('[data-refresh="column"]').forEach(function (element) {
    element.addEventListener('change', function () {
      console.log('refres');
      column.refresh();
    });
  });
};

var refresh = function (column) {
  var $ = jQuery;
  column.$el.find('[data-refresh="column"]').on('change', function () {
    // Allow plugins to hook into this event
    column.$el.addClass('loading');
    setTimeout(function () {
      column.refresh().always(function () {
        column.$el.removeClass('loading');
      }).fail(function () {
        column.showMessage(AC.i18n.errors.loading_column);
      });
    }, 200);
  });
};

/* harmony default export */ __webpack_exports__["default"] = (refresh);

/***/ }),

/***/ "./js/admin/columns/events/remove.ts":
/*!*******************************************!*\
  !*** ./js/admin/columns/events/remove.ts ***!
  \*******************************************/
/*! exports provided: initRemoveColumn */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "initRemoveColumn", function() { return initRemoveColumn; });
var initRemoveColumn = function (column) {
  column.getElement().querySelectorAll('[data-remove-column]').forEach(function (element) {
    element.addEventListener('click', function (e) {
      e.preventDefault();
      column.remove();
    });
  });
};

/***/ }),

/***/ "./js/admin/columns/events/toggle.ts":
/*!*******************************************!*\
  !*** ./js/admin/columns/events/toggle.ts ***!
  \*******************************************/
/*! exports provided: initToggle */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "initToggle", function() { return initToggle; });
var initToggle = function (column) {
  column.getElement().querySelectorAll('[data-toggle="column"]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      return column.toggle();
    });
    el.style.cursor = 'pointer';
  });
};

/***/ }),

/***/ "./js/admin/columns/events/type-selector.ts":
/*!**************************************************!*\
  !*** ./js/admin/columns/events/type-selector.ts ***!
  \**************************************************/
/*! exports provided: initTypeSelector */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "initTypeSelector", function() { return initTypeSelector; });
var initTypeSelector = function (column) {
  column.getElement().querySelectorAll('select.ac-setting-input_type').forEach(function (select) {
    select.addEventListener('change', function () {
      return column.switchToType(select.value);
    });
  });
};

/***/ }),

/***/ "./js/admin/columns/form.ts":
/*!**********************************!*\
  !*** ./js/admin/columns/form.ts ***!
  \**********************************/
/*! exports provided: Form */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Form", function() { return Form; });
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../constants */ "./js/constants.ts");
/* harmony import */ var _column__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./column */ "./js/admin/columns/column.ts");
/* harmony import */ var _ajax__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ajax */ "./js/admin/columns/ajax.ts");
/* harmony import */ var _helpers_animations__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../helpers/animations */ "./js/helpers/animations.ts");
/* harmony import */ var _helpers_columns__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../helpers/columns */ "./js/helpers/columns.ts");
/* harmony import */ var _helpers_elements__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../helpers/elements */ "./js/helpers/elements.ts");







var Form =
/** @class */
function () {
  function Form(element, events) {
    this.form = element;
    this.events = events;
    this.columns = [];
    this.events.emit(_constants__WEBPACK_IMPORTED_MODULE_0__["EventConstants"].SETTINGS.FORM.LOADED, this); // TODO See usage
    // jQuery(document).trigger('AC_Form_Loaded');

    this.init();
  }

  Form.prototype.init = function () {
    this.initColumns();

    if (this.isDisabled()) {
      this.disableFields();
      this.disableColumns();
    }

    this.events.emit(_constants__WEBPACK_IMPORTED_MODULE_0__["EventConstants"].SETTINGS.FORM.READY, this);
  };

  Form.prototype.getElement = function () {
    return this.form;
  };

  Form.prototype.placeColumn = function (column, after) {
    if (after === void 0) {
      after = null;
    }

    if (after) {
      Object(_helpers_elements__WEBPACK_IMPORTED_MODULE_5__["insertAfter"])(column.getElement(), after);
    } else {
      this.getElement().querySelector('.ac-columns').append(column.getElement());
    }

    return this;
  };

  Form.prototype.createNewColumn = function () {
    var column = createColumnFromTemplate();
    column.init().open();
    this.columns.push(column);
    this.placeColumn(column);
    return column;
  };

  Form.prototype.isDisabled = function () {
    return this.form.classList.contains('-disabled');
  };

  Form.prototype.getOriginalColumns = function () {
    return this.columns.filter(function (column) {
      return column.isOriginal();
    });
  };

  Form.prototype.disableColumns = function () {
    this.columns.forEach(function (col) {
      return col.disable();
    });
  };

  Form.prototype.initColumns = function () {
    var _this = this;

    this.getElement().querySelectorAll('.ac-column').forEach(function (element) {
      var column = new _column__WEBPACK_IMPORTED_MODULE_1__["Column"](element, element.dataset.columnName);
      column.init();

      _this.columns.push(column);

      _this.bindColumnEvents(column);
    });
  };

  Form.prototype.bindColumnEvents = function (column) {
    var _this = this;

    column.events.addListener(_column__WEBPACK_IMPORTED_MODULE_1__["COLUMN_EVENTS"].REMOVE, function () {
      _this.removeColumn(column.getName());
    });
    column.events.addListener(_column__WEBPACK_IMPORTED_MODULE_1__["COLUMN_EVENTS"].CLONE, function () {
      var cloneColumn = new _column__WEBPACK_IMPORTED_MODULE_1__["Column"](column.getElement().cloneNode(true), Object(_helpers_columns__WEBPACK_IMPORTED_MODULE_4__["createColumnName"])());
      cloneColumn.init();

      _this.columns.push(cloneColumn);

      _this.placeColumn(cloneColumn, column.getElement()).bindColumnEvents(cloneColumn);

      Object(_helpers_animations__WEBPACK_IMPORTED_MODULE_3__["fadeIn"])(cloneColumn.getElement(), 300);
    });
  };

  Form.prototype.resetColumns = function () {
    this.columns.forEach(function (column) {
      column.destroy();
    });
    this.columns = [];
  };

  Form.prototype.getSerializedFormData = function () {
    var params = new URLSearchParams(new FormData(this.getElement()));
    return params.toString();
  };

  Form.prototype.disableFields = function () {
    var elements = this.getElement().elements;

    for (var i = 0; i < elements.length; i++) {
      elements[i].setAttribute('readonly', 'readonly');
      elements[i].setAttribute('disabled', 'disabled');
    }
  };

  Form.prototype.submitForm = function () {
    var _this = this;

    this.events.emit(_constants__WEBPACK_IMPORTED_MODULE_0__["EventConstants"].SETTINGS.FORM.SAVING, this);
    Object(_ajax__WEBPACK_IMPORTED_MODULE_2__["submitColumnSettings"])(this.getSerializedFormData()).then(function (response) {
      if (response.data.success) {
        _this.showMessage(response.data.data, 'updated');
      } else if (response.data) {
        var error = response.data;

        _this.showMessage(error.data.message, 'notice notice-warning');
      }
    }).catch(function () {
      _this.showMessage(AC.i18n.error.save_settings);
    }).finally(function () {
      _this.events.emit(_constants__WEBPACK_IMPORTED_MODULE_0__["EventConstants"].SETTINGS.FORM.SAVED, _this);
    });
  };

  Form.prototype.showMessage = function (message, className) {
    var _a;

    if (className === void 0) {
      className = 'updated';
    }

    var messageContainer = document.querySelector('.ac-admin__main');
    messageContainer.querySelectorAll('.ac-message').forEach(function (el) {
      return el.remove();
    });
    var element = document.createElement('div');
    element.classList.add('ac-message');

    (_a = element.classList).add.apply(_a, className.split(' '));

    element.innerHTML = "<p>" + message + "</p>";
    messageContainer.insertAdjacentElement('afterbegin', element);
    Object(_helpers_animations__WEBPACK_IMPORTED_MODULE_3__["fadeIn"])(element, 600);
  };

  Form.prototype.removeColumn = function (name) {
    var _this = this;

    this.columns.forEach(function (c, i) {
      if (name === c.getName()) {
        _this.columns.splice(i, 1);
      }
    });
    console.log(this.columns);
  };

  Form.prototype._addColumnToForm = function (column, open, $after) {
    if (open === void 0) {
      open = true;
    }

    if ($after === void 0) {
      $after = null;
    }

    if (!isInViewport(column.$el)) {
      jQuery('html, body').animate({
        scrollTop: column.$el.offset().top - 58
      }, 300);
    }

    return column;
  };

  return Form;
}();



var createColumnFromTemplate = function () {
  var columnElement = document.querySelector('#add-new-column-template .ac-column').cloneNode(true);
  return new _column__WEBPACK_IMPORTED_MODULE_1__["Column"](columnElement, '_new_column');
};

var isInViewport = function ($el) {
  var elementTop = $el.offset().top;
  var elementBottom = elementTop + $el.outerHeight();
  var viewportTop = jQuery(window).scrollTop();
  var viewportBottom = viewportTop + jQuery(window).height();
  return elementBottom > viewportTop && elementTop < viewportBottom;
};

/***/ }),

/***/ "./js/admin/columns/settings/label.ts":
/*!********************************************!*\
  !*** ./js/admin/columns/settings/label.ts ***!
  \********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_modal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../modules/modal */ "./js/modules/modal.ts");
/* harmony import */ var nanobus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! nanobus */ "./node_modules/nanobus/index.js");
/* harmony import */ var nanobus__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(nanobus__WEBPACK_IMPORTED_MODULE_1__);
var __extends = undefined && undefined.__extends || function () {
  var extendStatics = function (d, b) {
    extendStatics = Object.setPrototypeOf || {
      __proto__: []
    } instanceof Array && function (d, b) {
      d.__proto__ = b;
    } || function (d, b) {
      for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    };

    return extendStatics(d, b);
  };

  return function (d, b) {
    extendStatics(d, b);

    function __() {
      this.constructor = d;
    }

    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
  };
}();




var LabelSetting =
/** @class */
function () {
  function LabelSetting(column) {
    this.column = column;
    this.modal = new IconPickerModal(column.getElement().querySelector('.-iconpicker'));
    this.field = this.column.getElement().querySelector('.ac-column-setting--label .ac-setting-input_label');
    this.initEvents();
    this.modal.setIconSelection(this.getDashIconFromValue());
  }

  LabelSetting.prototype.initEvents = function () {
    var _this = this;

    this.column.getElement().querySelectorAll('.ac-setting-label-icon').forEach(function (el) {
      el.addEventListener('click', function (e) {
        e.preventDefault();

        _this.modal.open();
      });
    });
    this.modal.onSubmit(function () {
      _this.setLabel(_this.modal.getDashIconMarkup());

      _this.modal.close();
    });
  };

  LabelSetting.prototype.getDashIconFromValue = function () {
    var html = document.createRange().createContextualFragment(this.getValue());
    var dashicon = html.querySelector('.dashicons');
    var value = null;

    if (!dashicon) {
      return value;
    }

    dashicon.classList.forEach(function (cls) {
      if (cls.indexOf('dashicons-') === 0) {
        value = cls.replace('dashicons-', '');
      }
    });
    return value;
  };

  LabelSetting.prototype.getValue = function () {
    return this.field.value;
  };

  LabelSetting.prototype.setLabel = function (label) {
    if (this.field) {
      this.field.value = label;
      this.field.dispatchEvent(new Event('change'));
    }
  };

  return LabelSetting;
}();

/* harmony default export */ __webpack_exports__["default"] = (LabelSetting);

var IconPickerModal =
/** @class */
function (_super) {
  __extends(IconPickerModal, _super);

  function IconPickerModal(element) {
    var _this = _super.call(this, element) || this;

    _this.events = new nanobus__WEBPACK_IMPORTED_MODULE_1___default.a();
    _this.dashIcon = null;
    return _this;
  }

  IconPickerModal.prototype.initEvents = function () {
    var _this = this;

    _super.prototype.initEvents.call(this);

    this.getElement().querySelectorAll('[data-action="submit"]').forEach(function (element) {
      element.addEventListener('click', function (e) {
        e.preventDefault();

        _this.events.emit('submit');
      });
    });
    this.getIconElements().forEach(function (icon) {
      icon.addEventListener('click', function (e) {
        e.preventDefault();

        _this.setIconSelection(icon.dataset.dashicon);

        _this.getIconElements().forEach(function (el) {
          return el.classList.remove('active');
        });

        icon.classList.add('active');
      });
    });
  };

  IconPickerModal.prototype.getIconElements = function () {
    return this.getElement().querySelectorAll('.ac-ipicker__icon');
  };

  IconPickerModal.prototype.onSubmit = function (cb) {
    this.events.on('submit', cb);
  };

  IconPickerModal.prototype.getDashIconMarkup = function () {
    return "<span class=\"dashicons dashicons-" + this.dashIcon + "\"></span>";
  };

  IconPickerModal.prototype.setIconSelection = function (dashicon) {
    var selection = this.getElement().querySelector('.ac-ipicker__selection');
    this.dashIcon = dashicon;
    selection.innerHTML = this.getDashIconMarkup();
    selection.style.visibility = 'visible';
  };

  return IconPickerModal;
}(_modules_modal__WEBPACK_IMPORTED_MODULE_0__["default"]);

/***/ }),

/***/ "./js/constants.ts":
/*!*************************!*\
  !*** ./js/constants.ts ***!
  \*************************/
/*! exports provided: EventConstants */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "EventConstants", function() { return EventConstants; });
var EventConstants = {
  TABLE: {
    READY: 'Table.Ready'
  },
  SETTINGS: {
    FORM: {
      LOADED: 'Settings.Form.Loaded',
      READY: 'Settings.Form.Ready',
      SAVING: 'Settings.Form.Saving',
      SAVED: 'Settings.Form.Saved'
    },
    COLUMN: {
      INIT: 'Settings.Column.Init',
      SWITCH: 'Settings.Column.SwitchToType'
    }
  }
};

/***/ }),

/***/ "./js/helpers/admin-columns.ts":
/*!*************************************!*\
  !*** ./js/helpers/admin-columns.ts ***!
  \*************************************/
/*! exports provided: initAdminColumnsGlobalBootstrap */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "initAdminColumnsGlobalBootstrap", function() { return initAdminColumnsGlobalBootstrap; });
/* harmony import */ var _modules_modals__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../modules/modals */ "./js/modules/modals.ts");


var nanobus = __webpack_require__(/*! nanobus */ "./node_modules/nanobus/index.js");

var initAdminColumnsGlobalBootstrap = function () {
  if (window.AdminColumns) {
    return window.AdminColumns;
  }

  window.AdminColumns = window.AdminColumns || {};
  AdminColumns.events = nanobus();
  AdminColumns.Modals = new _modules_modals__WEBPACK_IMPORTED_MODULE_0__["default"]();
  return AdminColumns;
};

/***/ }),

/***/ "./js/helpers/animations.ts":
/*!**********************************!*\
  !*** ./js/helpers/animations.ts ***!
  \**********************************/
/*! exports provided: fadeIn, fadeOut */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "fadeIn", function() { return fadeIn; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "fadeOut", function() { return fadeOut; });
var _this = undefined;

var fadeIn = function (element, ms, cb) {
  if (ms === void 0) {
    ms = 100;
  }

  if (cb === void 0) {
    cb = null;
  }

  element.style.transition = "opacity " + ms + "ms";
  element.style.opacity = '0';
  setTimeout(function () {
    element.style.opacity = '1';
  }, 100);

  if (cb) {
    element.addEventListener('transitionend', function () {
      cb.call(_this);
    }, {
      once: true
    });
  }
};
var fadeOut = function (element, ms, cb) {
  if (ms === void 0) {
    ms = 100;
  }

  if (cb === void 0) {
    cb = null;
  }

  element.style.transition = "opacity " + ms + "ms";
  element.style.opacity = '1';
  setTimeout(function () {
    element.style.opacity = '0';
  }, 100);

  if (cb) {
    element.addEventListener('transitionend', function () {
      cb.call(_this);
    }, {
      once: true
    });
  }
};

/***/ }),

/***/ "./js/helpers/columns.ts":
/*!*******************************!*\
  !*** ./js/helpers/columns.ts ***!
  \*******************************/
/*! exports provided: createColumnName */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createColumnName", function() { return createColumnName; });
var columnName =
/** @class */
function () {
  function columnName() {
    columnName.count++;
  }

  columnName.prototype.getName = function () {
    return "_new_column_" + columnName.count;
  };

  columnName.count = 0;
  return columnName;
}();

var createColumnName = function () {
  return new columnName().getName();
};

/***/ }),

/***/ "./js/helpers/elements.ts":
/*!********************************!*\
  !*** ./js/helpers/elements.ts ***!
  \********************************/
/*! exports provided: insertAfter, insertBefore, createElementFromString */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "insertAfter", function() { return insertAfter; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "insertBefore", function() { return insertBefore; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createElementFromString", function() { return createElementFromString; });
var insertAfter = function (newNode, referenceNode) {
  referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
};
var insertBefore = function (newNode, referenceNode) {
  referenceNode.parentNode.insertBefore(newNode, referenceNode);
};
var createElementFromString = function (content, baseElement) {
  if (baseElement === void 0) {
    baseElement = 'div';
  }

  var element = document.createElement(baseElement);
  element.innerHTML = content;
  return element;
};

/***/ }),

/***/ "./js/modules/modal.ts":
/*!*****************************!*\
  !*** ./js/modules/modal.ts ***!
  \*****************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var Modal =
/** @class */
function () {
  function Modal(el) {
    if (!el) {
      return;
    }

    this.el = el;
    this.dialog = el.querySelector('.ac-modal__dialog');
    this.initEvents();
  }

  Modal.prototype.getElement = function () {
    return this.el;
  };

  Modal.prototype.initEvents = function () {
    var _this = this;

    var self = this;
    document.addEventListener('keydown', function (e) {
      var keyName = e.key;

      if (!_this.isOpen()) {
        return;
      }

      if ('Escape' === keyName) {
        _this.close();
      }
    });
    var dismissButtons = this.el.querySelectorAll('[data-dismiss="modal"], .ac-modal__dialog__close');

    if (dismissButtons.length > 0) {
      dismissButtons.forEach(function (b) {
        b.addEventListener('click', function (e) {
          e.preventDefault();
          self.close();
        });
      });
    }

    this.el.addEventListener('click', function (e) {
      if (e.target.classList.contains('ac-modal')) {
        self.close();
      }
    });
  };

  Modal.prototype.isOpen = function () {
    return this.el.classList.contains('-active');
  };

  Modal.prototype.close = function () {
    this.onClose();
    this.el.classList.remove('-active');
  };

  Modal.prototype.open = function () {
    var _this = this; //short delay in order to allow bubbling events to bind before opening


    setTimeout(function () {
      _this.onOpen();

      _this.el.removeAttribute('style');

      _this.el.classList.add('-active');
    });
  };

  Modal.prototype.destroy = function () {
    this.el.remove();
  };

  Modal.prototype.onClose = function () {};

  Modal.prototype.onOpen = function () {};

  return Modal;
}();

/* harmony default export */ __webpack_exports__["default"] = (Modal);

/***/ }),

/***/ "./js/modules/modals.ts":
/*!******************************!*\
  !*** ./js/modules/modals.ts ***!
  \******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modal */ "./js/modules/modal.ts");


var Modals =
/** @class */
function () {
  function Modals() {
    this.modals = {};
    this.number = 0;
    this.defaults = {
      modal: _modal__WEBPACK_IMPORTED_MODULE_0__["default"]
    };
    this.initGlobalEvents();
  }

  Modals.prototype.register = function (modal, key) {
    if (key === void 0) {
      key = '';
    }

    if (!key) {
      key = 'm' + this.number;
    }

    this.modals[key] = modal;
    this.number++;
    return modal;
  };

  Modals.prototype.get = function (key) {
    return this.modals.hasOwnProperty(key) ? this.modals[key] : null;
  };

  Modals.prototype.open = function (key) {
    if (this.get(key)) {
      this.get(key).open();
    }
  };

  Modals.prototype.close = function (key) {
    if (this.get(key)) {
      this.get(key).close();
    }
  };

  Modals.prototype.closeAll = function () {
    for (var key in this.modals) {
      this.close(key);
    }
  };

  Modals.prototype.initGlobalEvents = function () {
    var _this = this;

    document.addEventListener('click', function (e) {
      var target = e.target;

      if (target.dataset.acModal) {
        e.preventDefault();

        _this.open(target.dataset.acModal);
      }
    });
  };

  return Modals;
}();

/* harmony default export */ __webpack_exports__["default"] = (Modals);

/***/ }),

/***/ "./node_modules/axios/index.js":
/*!*************************************!*\
  !*** ./node_modules/axios/index.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./lib/axios */ "./node_modules/axios/lib/axios.js");

/***/ }),

/***/ "./node_modules/axios/lib/adapters/xhr.js":
/*!************************************************!*\
  !*** ./node_modules/axios/lib/adapters/xhr.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var settle = __webpack_require__(/*! ./../core/settle */ "./node_modules/axios/lib/core/settle.js");
var cookies = __webpack_require__(/*! ./../helpers/cookies */ "./node_modules/axios/lib/helpers/cookies.js");
var buildURL = __webpack_require__(/*! ./../helpers/buildURL */ "./node_modules/axios/lib/helpers/buildURL.js");
var buildFullPath = __webpack_require__(/*! ../core/buildFullPath */ "./node_modules/axios/lib/core/buildFullPath.js");
var parseHeaders = __webpack_require__(/*! ./../helpers/parseHeaders */ "./node_modules/axios/lib/helpers/parseHeaders.js");
var isURLSameOrigin = __webpack_require__(/*! ./../helpers/isURLSameOrigin */ "./node_modules/axios/lib/helpers/isURLSameOrigin.js");
var createError = __webpack_require__(/*! ../core/createError */ "./node_modules/axios/lib/core/createError.js");

module.exports = function xhrAdapter(config) {
  return new Promise(function dispatchXhrRequest(resolve, reject) {
    var requestData = config.data;
    var requestHeaders = config.headers;

    if (utils.isFormData(requestData)) {
      delete requestHeaders['Content-Type']; // Let the browser set it
    }

    var request = new XMLHttpRequest();

    // HTTP basic authentication
    if (config.auth) {
      var username = config.auth.username || '';
      var password = config.auth.password ? unescape(encodeURIComponent(config.auth.password)) : '';
      requestHeaders.Authorization = 'Basic ' + btoa(username + ':' + password);
    }

    var fullPath = buildFullPath(config.baseURL, config.url);
    request.open(config.method.toUpperCase(), buildURL(fullPath, config.params, config.paramsSerializer), true);

    // Set the request timeout in MS
    request.timeout = config.timeout;

    // Listen for ready state
    request.onreadystatechange = function handleLoad() {
      if (!request || request.readyState !== 4) {
        return;
      }

      // The request errored out and we didn't get a response, this will be
      // handled by onerror instead
      // With one exception: request that using file: protocol, most browsers
      // will return status as 0 even though it's a successful request
      if (request.status === 0 && !(request.responseURL && request.responseURL.indexOf('file:') === 0)) {
        return;
      }

      // Prepare the response
      var responseHeaders = 'getAllResponseHeaders' in request ? parseHeaders(request.getAllResponseHeaders()) : null;
      var responseData = !config.responseType || config.responseType === 'text' ? request.responseText : request.response;
      var response = {
        data: responseData,
        status: request.status,
        statusText: request.statusText,
        headers: responseHeaders,
        config: config,
        request: request
      };

      settle(resolve, reject, response);

      // Clean up request
      request = null;
    };

    // Handle browser request cancellation (as opposed to a manual cancellation)
    request.onabort = function handleAbort() {
      if (!request) {
        return;
      }

      reject(createError('Request aborted', config, 'ECONNABORTED', request));

      // Clean up request
      request = null;
    };

    // Handle low level network errors
    request.onerror = function handleError() {
      // Real errors are hidden from us by the browser
      // onerror should only fire if it's a network error
      reject(createError('Network Error', config, null, request));

      // Clean up request
      request = null;
    };

    // Handle timeout
    request.ontimeout = function handleTimeout() {
      var timeoutErrorMessage = 'timeout of ' + config.timeout + 'ms exceeded';
      if (config.timeoutErrorMessage) {
        timeoutErrorMessage = config.timeoutErrorMessage;
      }
      reject(createError(timeoutErrorMessage, config, 'ECONNABORTED',
        request));

      // Clean up request
      request = null;
    };

    // Add xsrf header
    // This is only done if running in a standard browser environment.
    // Specifically not if we're in a web worker, or react-native.
    if (utils.isStandardBrowserEnv()) {
      // Add xsrf header
      var xsrfValue = (config.withCredentials || isURLSameOrigin(fullPath)) && config.xsrfCookieName ?
        cookies.read(config.xsrfCookieName) :
        undefined;

      if (xsrfValue) {
        requestHeaders[config.xsrfHeaderName] = xsrfValue;
      }
    }

    // Add headers to the request
    if ('setRequestHeader' in request) {
      utils.forEach(requestHeaders, function setRequestHeader(val, key) {
        if (typeof requestData === 'undefined' && key.toLowerCase() === 'content-type') {
          // Remove Content-Type if data is undefined
          delete requestHeaders[key];
        } else {
          // Otherwise add header to the request
          request.setRequestHeader(key, val);
        }
      });
    }

    // Add withCredentials to request if needed
    if (!utils.isUndefined(config.withCredentials)) {
      request.withCredentials = !!config.withCredentials;
    }

    // Add responseType to request if needed
    if (config.responseType) {
      try {
        request.responseType = config.responseType;
      } catch (e) {
        // Expected DOMException thrown by browsers not compatible XMLHttpRequest Level 2.
        // But, this can be suppressed for 'json' type as it can be parsed by default 'transformResponse' function.
        if (config.responseType !== 'json') {
          throw e;
        }
      }
    }

    // Handle progress if needed
    if (typeof config.onDownloadProgress === 'function') {
      request.addEventListener('progress', config.onDownloadProgress);
    }

    // Not all browsers support upload events
    if (typeof config.onUploadProgress === 'function' && request.upload) {
      request.upload.addEventListener('progress', config.onUploadProgress);
    }

    if (config.cancelToken) {
      // Handle cancellation
      config.cancelToken.promise.then(function onCanceled(cancel) {
        if (!request) {
          return;
        }

        request.abort();
        reject(cancel);
        // Clean up request
        request = null;
      });
    }

    if (!requestData) {
      requestData = null;
    }

    // Send the request
    request.send(requestData);
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/axios.js":
/*!*****************************************!*\
  !*** ./node_modules/axios/lib/axios.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");
var Axios = __webpack_require__(/*! ./core/Axios */ "./node_modules/axios/lib/core/Axios.js");
var mergeConfig = __webpack_require__(/*! ./core/mergeConfig */ "./node_modules/axios/lib/core/mergeConfig.js");
var defaults = __webpack_require__(/*! ./defaults */ "./node_modules/axios/lib/defaults.js");

/**
 * Create an instance of Axios
 *
 * @param {Object} defaultConfig The default config for the instance
 * @return {Axios} A new instance of Axios
 */
function createInstance(defaultConfig) {
  var context = new Axios(defaultConfig);
  var instance = bind(Axios.prototype.request, context);

  // Copy axios.prototype to instance
  utils.extend(instance, Axios.prototype, context);

  // Copy context to instance
  utils.extend(instance, context);

  return instance;
}

// Create the default instance to be exported
var axios = createInstance(defaults);

// Expose Axios class to allow class inheritance
axios.Axios = Axios;

// Factory for creating new instances
axios.create = function create(instanceConfig) {
  return createInstance(mergeConfig(axios.defaults, instanceConfig));
};

// Expose Cancel & CancelToken
axios.Cancel = __webpack_require__(/*! ./cancel/Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");
axios.CancelToken = __webpack_require__(/*! ./cancel/CancelToken */ "./node_modules/axios/lib/cancel/CancelToken.js");
axios.isCancel = __webpack_require__(/*! ./cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");

// Expose all/spread
axios.all = function all(promises) {
  return Promise.all(promises);
};
axios.spread = __webpack_require__(/*! ./helpers/spread */ "./node_modules/axios/lib/helpers/spread.js");

module.exports = axios;

// Allow use of default import syntax in TypeScript
module.exports.default = axios;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/Cancel.js":
/*!*************************************************!*\
  !*** ./node_modules/axios/lib/cancel/Cancel.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * A `Cancel` is an object that is thrown when an operation is canceled.
 *
 * @class
 * @param {string=} message The message.
 */
function Cancel(message) {
  this.message = message;
}

Cancel.prototype.toString = function toString() {
  return 'Cancel' + (this.message ? ': ' + this.message : '');
};

Cancel.prototype.__CANCEL__ = true;

module.exports = Cancel;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/CancelToken.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/cancel/CancelToken.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var Cancel = __webpack_require__(/*! ./Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");

/**
 * A `CancelToken` is an object that can be used to request cancellation of an operation.
 *
 * @class
 * @param {Function} executor The executor function.
 */
function CancelToken(executor) {
  if (typeof executor !== 'function') {
    throw new TypeError('executor must be a function.');
  }

  var resolvePromise;
  this.promise = new Promise(function promiseExecutor(resolve) {
    resolvePromise = resolve;
  });

  var token = this;
  executor(function cancel(message) {
    if (token.reason) {
      // Cancellation has already been requested
      return;
    }

    token.reason = new Cancel(message);
    resolvePromise(token.reason);
  });
}

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
CancelToken.prototype.throwIfRequested = function throwIfRequested() {
  if (this.reason) {
    throw this.reason;
  }
};

/**
 * Returns an object that contains a new `CancelToken` and a function that, when called,
 * cancels the `CancelToken`.
 */
CancelToken.source = function source() {
  var cancel;
  var token = new CancelToken(function executor(c) {
    cancel = c;
  });
  return {
    token: token,
    cancel: cancel
  };
};

module.exports = CancelToken;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/isCancel.js":
/*!***************************************************!*\
  !*** ./node_modules/axios/lib/cancel/isCancel.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function isCancel(value) {
  return !!(value && value.__CANCEL__);
};


/***/ }),

/***/ "./node_modules/axios/lib/core/Axios.js":
/*!**********************************************!*\
  !*** ./node_modules/axios/lib/core/Axios.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var buildURL = __webpack_require__(/*! ../helpers/buildURL */ "./node_modules/axios/lib/helpers/buildURL.js");
var InterceptorManager = __webpack_require__(/*! ./InterceptorManager */ "./node_modules/axios/lib/core/InterceptorManager.js");
var dispatchRequest = __webpack_require__(/*! ./dispatchRequest */ "./node_modules/axios/lib/core/dispatchRequest.js");
var mergeConfig = __webpack_require__(/*! ./mergeConfig */ "./node_modules/axios/lib/core/mergeConfig.js");

/**
 * Create a new instance of Axios
 *
 * @param {Object} instanceConfig The default config for the instance
 */
function Axios(instanceConfig) {
  this.defaults = instanceConfig;
  this.interceptors = {
    request: new InterceptorManager(),
    response: new InterceptorManager()
  };
}

/**
 * Dispatch a request
 *
 * @param {Object} config The config specific for this request (merged with this.defaults)
 */
Axios.prototype.request = function request(config) {
  /*eslint no-param-reassign:0*/
  // Allow for axios('example/url'[, config]) a la fetch API
  if (typeof config === 'string') {
    config = arguments[1] || {};
    config.url = arguments[0];
  } else {
    config = config || {};
  }

  config = mergeConfig(this.defaults, config);

  // Set config.method
  if (config.method) {
    config.method = config.method.toLowerCase();
  } else if (this.defaults.method) {
    config.method = this.defaults.method.toLowerCase();
  } else {
    config.method = 'get';
  }

  // Hook up interceptors middleware
  var chain = [dispatchRequest, undefined];
  var promise = Promise.resolve(config);

  this.interceptors.request.forEach(function unshiftRequestInterceptors(interceptor) {
    chain.unshift(interceptor.fulfilled, interceptor.rejected);
  });

  this.interceptors.response.forEach(function pushResponseInterceptors(interceptor) {
    chain.push(interceptor.fulfilled, interceptor.rejected);
  });

  while (chain.length) {
    promise = promise.then(chain.shift(), chain.shift());
  }

  return promise;
};

Axios.prototype.getUri = function getUri(config) {
  config = mergeConfig(this.defaults, config);
  return buildURL(config.url, config.params, config.paramsSerializer).replace(/^\?/, '');
};

// Provide aliases for supported request methods
utils.forEach(['delete', 'get', 'head', 'options'], function forEachMethodNoData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, config) {
    return this.request(mergeConfig(config || {}, {
      method: method,
      url: url,
      data: (config || {}).data
    }));
  };
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, data, config) {
    return this.request(mergeConfig(config || {}, {
      method: method,
      url: url,
      data: data
    }));
  };
});

module.exports = Axios;


/***/ }),

/***/ "./node_modules/axios/lib/core/InterceptorManager.js":
/*!***********************************************************!*\
  !*** ./node_modules/axios/lib/core/InterceptorManager.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

function InterceptorManager() {
  this.handlers = [];
}

/**
 * Add a new interceptor to the stack
 *
 * @param {Function} fulfilled The function to handle `then` for a `Promise`
 * @param {Function} rejected The function to handle `reject` for a `Promise`
 *
 * @return {Number} An ID used to remove interceptor later
 */
InterceptorManager.prototype.use = function use(fulfilled, rejected) {
  this.handlers.push({
    fulfilled: fulfilled,
    rejected: rejected
  });
  return this.handlers.length - 1;
};

/**
 * Remove an interceptor from the stack
 *
 * @param {Number} id The ID that was returned by `use`
 */
InterceptorManager.prototype.eject = function eject(id) {
  if (this.handlers[id]) {
    this.handlers[id] = null;
  }
};

/**
 * Iterate over all the registered interceptors
 *
 * This method is particularly useful for skipping over any
 * interceptors that may have become `null` calling `eject`.
 *
 * @param {Function} fn The function to call for each interceptor
 */
InterceptorManager.prototype.forEach = function forEach(fn) {
  utils.forEach(this.handlers, function forEachHandler(h) {
    if (h !== null) {
      fn(h);
    }
  });
};

module.exports = InterceptorManager;


/***/ }),

/***/ "./node_modules/axios/lib/core/buildFullPath.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/core/buildFullPath.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var isAbsoluteURL = __webpack_require__(/*! ../helpers/isAbsoluteURL */ "./node_modules/axios/lib/helpers/isAbsoluteURL.js");
var combineURLs = __webpack_require__(/*! ../helpers/combineURLs */ "./node_modules/axios/lib/helpers/combineURLs.js");

/**
 * Creates a new URL by combining the baseURL with the requestedURL,
 * only when the requestedURL is not already an absolute URL.
 * If the requestURL is absolute, this function returns the requestedURL untouched.
 *
 * @param {string} baseURL The base URL
 * @param {string} requestedURL Absolute or relative URL to combine
 * @returns {string} The combined full path
 */
module.exports = function buildFullPath(baseURL, requestedURL) {
  if (baseURL && !isAbsoluteURL(requestedURL)) {
    return combineURLs(baseURL, requestedURL);
  }
  return requestedURL;
};


/***/ }),

/***/ "./node_modules/axios/lib/core/createError.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/core/createError.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var enhanceError = __webpack_require__(/*! ./enhanceError */ "./node_modules/axios/lib/core/enhanceError.js");

/**
 * Create an Error with the specified message, config, error code, request and response.
 *
 * @param {string} message The error message.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The created error.
 */
module.exports = function createError(message, config, code, request, response) {
  var error = new Error(message);
  return enhanceError(error, config, code, request, response);
};


/***/ }),

/***/ "./node_modules/axios/lib/core/dispatchRequest.js":
/*!********************************************************!*\
  !*** ./node_modules/axios/lib/core/dispatchRequest.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var transformData = __webpack_require__(/*! ./transformData */ "./node_modules/axios/lib/core/transformData.js");
var isCancel = __webpack_require__(/*! ../cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");
var defaults = __webpack_require__(/*! ../defaults */ "./node_modules/axios/lib/defaults.js");

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
function throwIfCancellationRequested(config) {
  if (config.cancelToken) {
    config.cancelToken.throwIfRequested();
  }
}

/**
 * Dispatch a request to the server using the configured adapter.
 *
 * @param {object} config The config that is to be used for the request
 * @returns {Promise} The Promise to be fulfilled
 */
module.exports = function dispatchRequest(config) {
  throwIfCancellationRequested(config);

  // Ensure headers exist
  config.headers = config.headers || {};

  // Transform request data
  config.data = transformData(
    config.data,
    config.headers,
    config.transformRequest
  );

  // Flatten headers
  config.headers = utils.merge(
    config.headers.common || {},
    config.headers[config.method] || {},
    config.headers
  );

  utils.forEach(
    ['delete', 'get', 'head', 'post', 'put', 'patch', 'common'],
    function cleanHeaderConfig(method) {
      delete config.headers[method];
    }
  );

  var adapter = config.adapter || defaults.adapter;

  return adapter(config).then(function onAdapterResolution(response) {
    throwIfCancellationRequested(config);

    // Transform response data
    response.data = transformData(
      response.data,
      response.headers,
      config.transformResponse
    );

    return response;
  }, function onAdapterRejection(reason) {
    if (!isCancel(reason)) {
      throwIfCancellationRequested(config);

      // Transform response data
      if (reason && reason.response) {
        reason.response.data = transformData(
          reason.response.data,
          reason.response.headers,
          config.transformResponse
        );
      }
    }

    return Promise.reject(reason);
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/core/enhanceError.js":
/*!*****************************************************!*\
  !*** ./node_modules/axios/lib/core/enhanceError.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Update an Error with the specified config, error code, and response.
 *
 * @param {Error} error The error to update.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The error.
 */
module.exports = function enhanceError(error, config, code, request, response) {
  error.config = config;
  if (code) {
    error.code = code;
  }

  error.request = request;
  error.response = response;
  error.isAxiosError = true;

  error.toJSON = function toJSON() {
    return {
      // Standard
      message: this.message,
      name: this.name,
      // Microsoft
      description: this.description,
      number: this.number,
      // Mozilla
      fileName: this.fileName,
      lineNumber: this.lineNumber,
      columnNumber: this.columnNumber,
      stack: this.stack,
      // Axios
      config: this.config,
      code: this.code
    };
  };
  return error;
};


/***/ }),

/***/ "./node_modules/axios/lib/core/mergeConfig.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/core/mergeConfig.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ../utils */ "./node_modules/axios/lib/utils.js");

/**
 * Config-specific merge-function which creates a new config-object
 * by merging two configuration objects together.
 *
 * @param {Object} config1
 * @param {Object} config2
 * @returns {Object} New object resulting from merging config2 to config1
 */
module.exports = function mergeConfig(config1, config2) {
  // eslint-disable-next-line no-param-reassign
  config2 = config2 || {};
  var config = {};

  var valueFromConfig2Keys = ['url', 'method', 'data'];
  var mergeDeepPropertiesKeys = ['headers', 'auth', 'proxy', 'params'];
  var defaultToConfig2Keys = [
    'baseURL', 'transformRequest', 'transformResponse', 'paramsSerializer',
    'timeout', 'timeoutMessage', 'withCredentials', 'adapter', 'responseType', 'xsrfCookieName',
    'xsrfHeaderName', 'onUploadProgress', 'onDownloadProgress', 'decompress',
    'maxContentLength', 'maxBodyLength', 'maxRedirects', 'transport', 'httpAgent',
    'httpsAgent', 'cancelToken', 'socketPath', 'responseEncoding'
  ];
  var directMergeKeys = ['validateStatus'];

  function getMergedValue(target, source) {
    if (utils.isPlainObject(target) && utils.isPlainObject(source)) {
      return utils.merge(target, source);
    } else if (utils.isPlainObject(source)) {
      return utils.merge({}, source);
    } else if (utils.isArray(source)) {
      return source.slice();
    }
    return source;
  }

  function mergeDeepProperties(prop) {
    if (!utils.isUndefined(config2[prop])) {
      config[prop] = getMergedValue(config1[prop], config2[prop]);
    } else if (!utils.isUndefined(config1[prop])) {
      config[prop] = getMergedValue(undefined, config1[prop]);
    }
  }

  utils.forEach(valueFromConfig2Keys, function valueFromConfig2(prop) {
    if (!utils.isUndefined(config2[prop])) {
      config[prop] = getMergedValue(undefined, config2[prop]);
    }
  });

  utils.forEach(mergeDeepPropertiesKeys, mergeDeepProperties);

  utils.forEach(defaultToConfig2Keys, function defaultToConfig2(prop) {
    if (!utils.isUndefined(config2[prop])) {
      config[prop] = getMergedValue(undefined, config2[prop]);
    } else if (!utils.isUndefined(config1[prop])) {
      config[prop] = getMergedValue(undefined, config1[prop]);
    }
  });

  utils.forEach(directMergeKeys, function merge(prop) {
    if (prop in config2) {
      config[prop] = getMergedValue(config1[prop], config2[prop]);
    } else if (prop in config1) {
      config[prop] = getMergedValue(undefined, config1[prop]);
    }
  });

  var axiosKeys = valueFromConfig2Keys
    .concat(mergeDeepPropertiesKeys)
    .concat(defaultToConfig2Keys)
    .concat(directMergeKeys);

  var otherKeys = Object
    .keys(config1)
    .concat(Object.keys(config2))
    .filter(function filterAxiosKeys(key) {
      return axiosKeys.indexOf(key) === -1;
    });

  utils.forEach(otherKeys, mergeDeepProperties);

  return config;
};


/***/ }),

/***/ "./node_modules/axios/lib/core/settle.js":
/*!***********************************************!*\
  !*** ./node_modules/axios/lib/core/settle.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var createError = __webpack_require__(/*! ./createError */ "./node_modules/axios/lib/core/createError.js");

/**
 * Resolve or reject a Promise based on response status.
 *
 * @param {Function} resolve A function that resolves the promise.
 * @param {Function} reject A function that rejects the promise.
 * @param {object} response The response.
 */
module.exports = function settle(resolve, reject, response) {
  var validateStatus = response.config.validateStatus;
  if (!response.status || !validateStatus || validateStatus(response.status)) {
    resolve(response);
  } else {
    reject(createError(
      'Request failed with status code ' + response.status,
      response.config,
      null,
      response.request,
      response
    ));
  }
};


/***/ }),

/***/ "./node_modules/axios/lib/core/transformData.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/core/transformData.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

/**
 * Transform the data for a request or a response
 *
 * @param {Object|String} data The data to be transformed
 * @param {Array} headers The headers for the request or response
 * @param {Array|Function} fns A single function or Array of functions
 * @returns {*} The resulting transformed data
 */
module.exports = function transformData(data, headers, fns) {
  /*eslint no-param-reassign:0*/
  utils.forEach(fns, function transform(fn) {
    data = fn(data, headers);
  });

  return data;
};


/***/ }),

/***/ "./node_modules/axios/lib/defaults.js":
/*!********************************************!*\
  !*** ./node_modules/axios/lib/defaults.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(process) {

var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
var normalizeHeaderName = __webpack_require__(/*! ./helpers/normalizeHeaderName */ "./node_modules/axios/lib/helpers/normalizeHeaderName.js");

var DEFAULT_CONTENT_TYPE = {
  'Content-Type': 'application/x-www-form-urlencoded'
};

function setContentTypeIfUnset(headers, value) {
  if (!utils.isUndefined(headers) && utils.isUndefined(headers['Content-Type'])) {
    headers['Content-Type'] = value;
  }
}

function getDefaultAdapter() {
  var adapter;
  if (typeof XMLHttpRequest !== 'undefined') {
    // For browsers use XHR adapter
    adapter = __webpack_require__(/*! ./adapters/xhr */ "./node_modules/axios/lib/adapters/xhr.js");
  } else if (typeof process !== 'undefined' && Object.prototype.toString.call(process) === '[object process]') {
    // For node use HTTP adapter
    adapter = __webpack_require__(/*! ./adapters/http */ "./node_modules/axios/lib/adapters/xhr.js");
  }
  return adapter;
}

var defaults = {
  adapter: getDefaultAdapter(),

  transformRequest: [function transformRequest(data, headers) {
    normalizeHeaderName(headers, 'Accept');
    normalizeHeaderName(headers, 'Content-Type');
    if (utils.isFormData(data) ||
      utils.isArrayBuffer(data) ||
      utils.isBuffer(data) ||
      utils.isStream(data) ||
      utils.isFile(data) ||
      utils.isBlob(data)
    ) {
      return data;
    }
    if (utils.isArrayBufferView(data)) {
      return data.buffer;
    }
    if (utils.isURLSearchParams(data)) {
      setContentTypeIfUnset(headers, 'application/x-www-form-urlencoded;charset=utf-8');
      return data.toString();
    }
    if (utils.isObject(data)) {
      setContentTypeIfUnset(headers, 'application/json;charset=utf-8');
      return JSON.stringify(data);
    }
    return data;
  }],

  transformResponse: [function transformResponse(data) {
    /*eslint no-param-reassign:0*/
    if (typeof data === 'string') {
      try {
        data = JSON.parse(data);
      } catch (e) { /* Ignore */ }
    }
    return data;
  }],

  /**
   * A timeout in milliseconds to abort a request. If set to 0 (default) a
   * timeout is not created.
   */
  timeout: 0,

  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN',

  maxContentLength: -1,
  maxBodyLength: -1,

  validateStatus: function validateStatus(status) {
    return status >= 200 && status < 300;
  }
};

defaults.headers = {
  common: {
    'Accept': 'application/json, text/plain, */*'
  }
};

utils.forEach(['delete', 'get', 'head'], function forEachMethodNoData(method) {
  defaults.headers[method] = {};
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  defaults.headers[method] = utils.merge(DEFAULT_CONTENT_TYPE);
});

module.exports = defaults;

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../process/browser.js */ "./node_modules/process/browser.js")))

/***/ }),

/***/ "./node_modules/axios/lib/helpers/bind.js":
/*!************************************************!*\
  !*** ./node_modules/axios/lib/helpers/bind.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function bind(fn, thisArg) {
  return function wrap() {
    var args = new Array(arguments.length);
    for (var i = 0; i < args.length; i++) {
      args[i] = arguments[i];
    }
    return fn.apply(thisArg, args);
  };
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/buildURL.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/helpers/buildURL.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

function encode(val) {
  return encodeURIComponent(val).
    replace(/%3A/gi, ':').
    replace(/%24/g, '$').
    replace(/%2C/gi, ',').
    replace(/%20/g, '+').
    replace(/%5B/gi, '[').
    replace(/%5D/gi, ']');
}

/**
 * Build a URL by appending params to the end
 *
 * @param {string} url The base of the url (e.g., http://www.google.com)
 * @param {object} [params] The params to be appended
 * @returns {string} The formatted url
 */
module.exports = function buildURL(url, params, paramsSerializer) {
  /*eslint no-param-reassign:0*/
  if (!params) {
    return url;
  }

  var serializedParams;
  if (paramsSerializer) {
    serializedParams = paramsSerializer(params);
  } else if (utils.isURLSearchParams(params)) {
    serializedParams = params.toString();
  } else {
    var parts = [];

    utils.forEach(params, function serialize(val, key) {
      if (val === null || typeof val === 'undefined') {
        return;
      }

      if (utils.isArray(val)) {
        key = key + '[]';
      } else {
        val = [val];
      }

      utils.forEach(val, function parseValue(v) {
        if (utils.isDate(v)) {
          v = v.toISOString();
        } else if (utils.isObject(v)) {
          v = JSON.stringify(v);
        }
        parts.push(encode(key) + '=' + encode(v));
      });
    });

    serializedParams = parts.join('&');
  }

  if (serializedParams) {
    var hashmarkIndex = url.indexOf('#');
    if (hashmarkIndex !== -1) {
      url = url.slice(0, hashmarkIndex);
    }

    url += (url.indexOf('?') === -1 ? '?' : '&') + serializedParams;
  }

  return url;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/combineURLs.js":
/*!*******************************************************!*\
  !*** ./node_modules/axios/lib/helpers/combineURLs.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Creates a new URL by combining the specified URLs
 *
 * @param {string} baseURL The base URL
 * @param {string} relativeURL The relative URL
 * @returns {string} The combined URL
 */
module.exports = function combineURLs(baseURL, relativeURL) {
  return relativeURL
    ? baseURL.replace(/\/+$/, '') + '/' + relativeURL.replace(/^\/+/, '')
    : baseURL;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/cookies.js":
/*!***************************************************!*\
  !*** ./node_modules/axios/lib/helpers/cookies.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs support document.cookie
    (function standardBrowserEnv() {
      return {
        write: function write(name, value, expires, path, domain, secure) {
          var cookie = [];
          cookie.push(name + '=' + encodeURIComponent(value));

          if (utils.isNumber(expires)) {
            cookie.push('expires=' + new Date(expires).toGMTString());
          }

          if (utils.isString(path)) {
            cookie.push('path=' + path);
          }

          if (utils.isString(domain)) {
            cookie.push('domain=' + domain);
          }

          if (secure === true) {
            cookie.push('secure');
          }

          document.cookie = cookie.join('; ');
        },

        read: function read(name) {
          var match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
          return (match ? decodeURIComponent(match[3]) : null);
        },

        remove: function remove(name) {
          this.write(name, '', Date.now() - 86400000);
        }
      };
    })() :

  // Non standard browser env (web workers, react-native) lack needed support.
    (function nonStandardBrowserEnv() {
      return {
        write: function write() {},
        read: function read() { return null; },
        remove: function remove() {}
      };
    })()
);


/***/ }),

/***/ "./node_modules/axios/lib/helpers/isAbsoluteURL.js":
/*!*********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isAbsoluteURL.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Determines whether the specified URL is absolute
 *
 * @param {string} url The URL to test
 * @returns {boolean} True if the specified URL is absolute, otherwise false
 */
module.exports = function isAbsoluteURL(url) {
  // A URL is considered absolute if it begins with "<scheme>://" or "//" (protocol-relative URL).
  // RFC 3986 defines scheme name as a sequence of characters beginning with a letter and followed
  // by any combination of letters, digits, plus, period, or hyphen.
  return /^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(url);
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/isURLSameOrigin.js":
/*!***********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isURLSameOrigin.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs have full support of the APIs needed to test
  // whether the request URL is of the same origin as current location.
    (function standardBrowserEnv() {
      var msie = /(msie|trident)/i.test(navigator.userAgent);
      var urlParsingNode = document.createElement('a');
      var originURL;

      /**
    * Parse a URL to discover it's components
    *
    * @param {String} url The URL to be parsed
    * @returns {Object}
    */
      function resolveURL(url) {
        var href = url;

        if (msie) {
        // IE needs attribute set twice to normalize properties
          urlParsingNode.setAttribute('href', href);
          href = urlParsingNode.href;
        }

        urlParsingNode.setAttribute('href', href);

        // urlParsingNode provides the UrlUtils interface - http://url.spec.whatwg.org/#urlutils
        return {
          href: urlParsingNode.href,
          protocol: urlParsingNode.protocol ? urlParsingNode.protocol.replace(/:$/, '') : '',
          host: urlParsingNode.host,
          search: urlParsingNode.search ? urlParsingNode.search.replace(/^\?/, '') : '',
          hash: urlParsingNode.hash ? urlParsingNode.hash.replace(/^#/, '') : '',
          hostname: urlParsingNode.hostname,
          port: urlParsingNode.port,
          pathname: (urlParsingNode.pathname.charAt(0) === '/') ?
            urlParsingNode.pathname :
            '/' + urlParsingNode.pathname
        };
      }

      originURL = resolveURL(window.location.href);

      /**
    * Determine if a URL shares the same origin as the current location
    *
    * @param {String} requestURL The URL to test
    * @returns {boolean} True if URL shares the same origin, otherwise false
    */
      return function isURLSameOrigin(requestURL) {
        var parsed = (utils.isString(requestURL)) ? resolveURL(requestURL) : requestURL;
        return (parsed.protocol === originURL.protocol &&
            parsed.host === originURL.host);
      };
    })() :

  // Non standard browser envs (web workers, react-native) lack needed support.
    (function nonStandardBrowserEnv() {
      return function isURLSameOrigin() {
        return true;
      };
    })()
);


/***/ }),

/***/ "./node_modules/axios/lib/helpers/normalizeHeaderName.js":
/*!***************************************************************!*\
  !*** ./node_modules/axios/lib/helpers/normalizeHeaderName.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ../utils */ "./node_modules/axios/lib/utils.js");

module.exports = function normalizeHeaderName(headers, normalizedName) {
  utils.forEach(headers, function processHeader(value, name) {
    if (name !== normalizedName && name.toUpperCase() === normalizedName.toUpperCase()) {
      headers[normalizedName] = value;
      delete headers[name];
    }
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/parseHeaders.js":
/*!********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/parseHeaders.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

// Headers whose duplicates are ignored by node
// c.f. https://nodejs.org/api/http.html#http_message_headers
var ignoreDuplicateOf = [
  'age', 'authorization', 'content-length', 'content-type', 'etag',
  'expires', 'from', 'host', 'if-modified-since', 'if-unmodified-since',
  'last-modified', 'location', 'max-forwards', 'proxy-authorization',
  'referer', 'retry-after', 'user-agent'
];

/**
 * Parse headers into an object
 *
 * ```
 * Date: Wed, 27 Aug 2014 08:58:49 GMT
 * Content-Type: application/json
 * Connection: keep-alive
 * Transfer-Encoding: chunked
 * ```
 *
 * @param {String} headers Headers needing to be parsed
 * @returns {Object} Headers parsed into an object
 */
module.exports = function parseHeaders(headers) {
  var parsed = {};
  var key;
  var val;
  var i;

  if (!headers) { return parsed; }

  utils.forEach(headers.split('\n'), function parser(line) {
    i = line.indexOf(':');
    key = utils.trim(line.substr(0, i)).toLowerCase();
    val = utils.trim(line.substr(i + 1));

    if (key) {
      if (parsed[key] && ignoreDuplicateOf.indexOf(key) >= 0) {
        return;
      }
      if (key === 'set-cookie') {
        parsed[key] = (parsed[key] ? parsed[key] : []).concat([val]);
      } else {
        parsed[key] = parsed[key] ? parsed[key] + ', ' + val : val;
      }
    }
  });

  return parsed;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/spread.js":
/*!**************************************************!*\
  !*** ./node_modules/axios/lib/helpers/spread.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Syntactic sugar for invoking a function and expanding an array for arguments.
 *
 * Common use case would be to use `Function.prototype.apply`.
 *
 *  ```js
 *  function f(x, y, z) {}
 *  var args = [1, 2, 3];
 *  f.apply(null, args);
 *  ```
 *
 * With `spread` this example can be re-written.
 *
 *  ```js
 *  spread(function(x, y, z) {})([1, 2, 3]);
 *  ```
 *
 * @param {Function} callback
 * @returns {Function}
 */
module.exports = function spread(callback) {
  return function wrap(arr) {
    return callback.apply(null, arr);
  };
};


/***/ }),

/***/ "./node_modules/axios/lib/utils.js":
/*!*****************************************!*\
  !*** ./node_modules/axios/lib/utils.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");

/*global toString:true*/

// utils is a library of generic helper functions non-specific to axios

var toString = Object.prototype.toString;

/**
 * Determine if a value is an Array
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Array, otherwise false
 */
function isArray(val) {
  return toString.call(val) === '[object Array]';
}

/**
 * Determine if a value is undefined
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if the value is undefined, otherwise false
 */
function isUndefined(val) {
  return typeof val === 'undefined';
}

/**
 * Determine if a value is a Buffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Buffer, otherwise false
 */
function isBuffer(val) {
  return val !== null && !isUndefined(val) && val.constructor !== null && !isUndefined(val.constructor)
    && typeof val.constructor.isBuffer === 'function' && val.constructor.isBuffer(val);
}

/**
 * Determine if a value is an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an ArrayBuffer, otherwise false
 */
function isArrayBuffer(val) {
  return toString.call(val) === '[object ArrayBuffer]';
}

/**
 * Determine if a value is a FormData
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an FormData, otherwise false
 */
function isFormData(val) {
  return (typeof FormData !== 'undefined') && (val instanceof FormData);
}

/**
 * Determine if a value is a view on an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a view on an ArrayBuffer, otherwise false
 */
function isArrayBufferView(val) {
  var result;
  if ((typeof ArrayBuffer !== 'undefined') && (ArrayBuffer.isView)) {
    result = ArrayBuffer.isView(val);
  } else {
    result = (val) && (val.buffer) && (val.buffer instanceof ArrayBuffer);
  }
  return result;
}

/**
 * Determine if a value is a String
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a String, otherwise false
 */
function isString(val) {
  return typeof val === 'string';
}

/**
 * Determine if a value is a Number
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Number, otherwise false
 */
function isNumber(val) {
  return typeof val === 'number';
}

/**
 * Determine if a value is an Object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Object, otherwise false
 */
function isObject(val) {
  return val !== null && typeof val === 'object';
}

/**
 * Determine if a value is a plain Object
 *
 * @param {Object} val The value to test
 * @return {boolean} True if value is a plain Object, otherwise false
 */
function isPlainObject(val) {
  if (toString.call(val) !== '[object Object]') {
    return false;
  }

  var prototype = Object.getPrototypeOf(val);
  return prototype === null || prototype === Object.prototype;
}

/**
 * Determine if a value is a Date
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Date, otherwise false
 */
function isDate(val) {
  return toString.call(val) === '[object Date]';
}

/**
 * Determine if a value is a File
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a File, otherwise false
 */
function isFile(val) {
  return toString.call(val) === '[object File]';
}

/**
 * Determine if a value is a Blob
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Blob, otherwise false
 */
function isBlob(val) {
  return toString.call(val) === '[object Blob]';
}

/**
 * Determine if a value is a Function
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Function, otherwise false
 */
function isFunction(val) {
  return toString.call(val) === '[object Function]';
}

/**
 * Determine if a value is a Stream
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Stream, otherwise false
 */
function isStream(val) {
  return isObject(val) && isFunction(val.pipe);
}

/**
 * Determine if a value is a URLSearchParams object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a URLSearchParams object, otherwise false
 */
function isURLSearchParams(val) {
  return typeof URLSearchParams !== 'undefined' && val instanceof URLSearchParams;
}

/**
 * Trim excess whitespace off the beginning and end of a string
 *
 * @param {String} str The String to trim
 * @returns {String} The String freed of excess whitespace
 */
function trim(str) {
  return str.replace(/^\s*/, '').replace(/\s*$/, '');
}

/**
 * Determine if we're running in a standard browser environment
 *
 * This allows axios to run in a web worker, and react-native.
 * Both environments support XMLHttpRequest, but not fully standard globals.
 *
 * web workers:
 *  typeof window -> undefined
 *  typeof document -> undefined
 *
 * react-native:
 *  navigator.product -> 'ReactNative'
 * nativescript
 *  navigator.product -> 'NativeScript' or 'NS'
 */
function isStandardBrowserEnv() {
  if (typeof navigator !== 'undefined' && (navigator.product === 'ReactNative' ||
                                           navigator.product === 'NativeScript' ||
                                           navigator.product === 'NS')) {
    return false;
  }
  return (
    typeof window !== 'undefined' &&
    typeof document !== 'undefined'
  );
}

/**
 * Iterate over an Array or an Object invoking a function for each item.
 *
 * If `obj` is an Array callback will be called passing
 * the value, index, and complete array for each item.
 *
 * If 'obj' is an Object callback will be called passing
 * the value, key, and complete object for each property.
 *
 * @param {Object|Array} obj The object to iterate
 * @param {Function} fn The callback to invoke for each item
 */
function forEach(obj, fn) {
  // Don't bother if no value provided
  if (obj === null || typeof obj === 'undefined') {
    return;
  }

  // Force an array if not already something iterable
  if (typeof obj !== 'object') {
    /*eslint no-param-reassign:0*/
    obj = [obj];
  }

  if (isArray(obj)) {
    // Iterate over array values
    for (var i = 0, l = obj.length; i < l; i++) {
      fn.call(null, obj[i], i, obj);
    }
  } else {
    // Iterate over object keys
    for (var key in obj) {
      if (Object.prototype.hasOwnProperty.call(obj, key)) {
        fn.call(null, obj[key], key, obj);
      }
    }
  }
}

/**
 * Accepts varargs expecting each argument to be an object, then
 * immutably merges the properties of each object and returns result.
 *
 * When multiple objects contain the same key the later object in
 * the arguments list will take precedence.
 *
 * Example:
 *
 * ```js
 * var result = merge({foo: 123}, {foo: 456});
 * console.log(result.foo); // outputs 456
 * ```
 *
 * @param {Object} obj1 Object to merge
 * @returns {Object} Result of all merge properties
 */
function merge(/* obj1, obj2, obj3, ... */) {
  var result = {};
  function assignValue(val, key) {
    if (isPlainObject(result[key]) && isPlainObject(val)) {
      result[key] = merge(result[key], val);
    } else if (isPlainObject(val)) {
      result[key] = merge({}, val);
    } else if (isArray(val)) {
      result[key] = val.slice();
    } else {
      result[key] = val;
    }
  }

  for (var i = 0, l = arguments.length; i < l; i++) {
    forEach(arguments[i], assignValue);
  }
  return result;
}

/**
 * Extends object a by mutably adding to it the properties of object b.
 *
 * @param {Object} a The object to be extended
 * @param {Object} b The object to copy properties from
 * @param {Object} thisArg The object to bind function to
 * @return {Object} The resulting value of object a
 */
function extend(a, b, thisArg) {
  forEach(b, function assignValue(val, key) {
    if (thisArg && typeof val === 'function') {
      a[key] = bind(val, thisArg);
    } else {
      a[key] = val;
    }
  });
  return a;
}

/**
 * Remove byte order marker. This catches EF BB BF (the UTF-8 BOM)
 *
 * @param {string} content with BOM
 * @return {string} content value without BOM
 */
function stripBOM(content) {
  if (content.charCodeAt(0) === 0xFEFF) {
    content = content.slice(1);
  }
  return content;
}

module.exports = {
  isArray: isArray,
  isArrayBuffer: isArrayBuffer,
  isBuffer: isBuffer,
  isFormData: isFormData,
  isArrayBufferView: isArrayBufferView,
  isString: isString,
  isNumber: isNumber,
  isObject: isObject,
  isPlainObject: isPlainObject,
  isUndefined: isUndefined,
  isDate: isDate,
  isFile: isFile,
  isBlob: isBlob,
  isFunction: isFunction,
  isStream: isStream,
  isURLSearchParams: isURLSearchParams,
  isStandardBrowserEnv: isStandardBrowserEnv,
  forEach: forEach,
  merge: merge,
  extend: extend,
  trim: trim,
  stripBOM: stripBOM
};


/***/ }),

/***/ "./node_modules/nanoassert/index.js":
/*!******************************************!*\
  !*** ./node_modules/nanoassert/index.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

assert.notEqual = notEqual
assert.notOk = notOk
assert.equal = equal
assert.ok = assert

module.exports = assert

function equal (a, b, m) {
  assert(a == b, m) // eslint-disable-line eqeqeq
}

function notEqual (a, b, m) {
  assert(a != b, m) // eslint-disable-line eqeqeq
}

function notOk (t, m) {
  assert(!t, m)
}

function assert (t, m) {
  if (!t) throw new Error(m || 'AssertionError')
}


/***/ }),

/***/ "./node_modules/nanobus/index.js":
/*!***************************************!*\
  !*** ./node_modules/nanobus/index.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var splice = __webpack_require__(/*! remove-array-items */ "./node_modules/remove-array-items/index.js")
var nanotiming = __webpack_require__(/*! nanotiming */ "./node_modules/nanotiming/browser.js")
var assert = __webpack_require__(/*! assert */ "./node_modules/nanoassert/index.js")

module.exports = Nanobus

function Nanobus (name) {
  if (!(this instanceof Nanobus)) return new Nanobus(name)

  this._name = name || 'nanobus'
  this._starListeners = []
  this._listeners = {}
}

Nanobus.prototype.emit = function (eventName) {
  assert.ok(typeof eventName === 'string' || typeof eventName === 'symbol', 'nanobus.emit: eventName should be type string or symbol')

  var data = []
  for (var i = 1, len = arguments.length; i < len; i++) {
    data.push(arguments[i])
  }

  var emitTiming = nanotiming(this._name + "('" + eventName.toString() + "')")
  var listeners = this._listeners[eventName]
  if (listeners && listeners.length > 0) {
    this._emit(this._listeners[eventName], data)
  }

  if (this._starListeners.length > 0) {
    this._emit(this._starListeners, eventName, data, emitTiming.uuid)
  }
  emitTiming()

  return this
}

Nanobus.prototype.on = Nanobus.prototype.addListener = function (eventName, listener) {
  assert.ok(typeof eventName === 'string' || typeof eventName === 'symbol', 'nanobus.on: eventName should be type string or symbol')
  assert.equal(typeof listener, 'function', 'nanobus.on: listener should be type function')

  if (eventName === '*') {
    this._starListeners.push(listener)
  } else {
    if (!this._listeners[eventName]) this._listeners[eventName] = []
    this._listeners[eventName].push(listener)
  }
  return this
}

Nanobus.prototype.prependListener = function (eventName, listener) {
  assert.ok(typeof eventName === 'string' || typeof eventName === 'symbol', 'nanobus.prependListener: eventName should be type string or symbol')
  assert.equal(typeof listener, 'function', 'nanobus.prependListener: listener should be type function')

  if (eventName === '*') {
    this._starListeners.unshift(listener)
  } else {
    if (!this._listeners[eventName]) this._listeners[eventName] = []
    this._listeners[eventName].unshift(listener)
  }
  return this
}

Nanobus.prototype.once = function (eventName, listener) {
  assert.ok(typeof eventName === 'string' || typeof eventName === 'symbol', 'nanobus.once: eventName should be type string or symbol')
  assert.equal(typeof listener, 'function', 'nanobus.once: listener should be type function')

  var self = this
  this.on(eventName, once)
  function once () {
    listener.apply(self, arguments)
    self.removeListener(eventName, once)
  }
  return this
}

Nanobus.prototype.prependOnceListener = function (eventName, listener) {
  assert.ok(typeof eventName === 'string' || typeof eventName === 'symbol', 'nanobus.prependOnceListener: eventName should be type string or symbol')
  assert.equal(typeof listener, 'function', 'nanobus.prependOnceListener: listener should be type function')

  var self = this
  this.prependListener(eventName, once)
  function once () {
    listener.apply(self, arguments)
    self.removeListener(eventName, once)
  }
  return this
}

Nanobus.prototype.removeListener = function (eventName, listener) {
  assert.ok(typeof eventName === 'string' || typeof eventName === 'symbol', 'nanobus.removeListener: eventName should be type string or symbol')
  assert.equal(typeof listener, 'function', 'nanobus.removeListener: listener should be type function')

  if (eventName === '*') {
    this._starListeners = this._starListeners.slice()
    return remove(this._starListeners, listener)
  } else {
    if (typeof this._listeners[eventName] !== 'undefined') {
      this._listeners[eventName] = this._listeners[eventName].slice()
    }

    return remove(this._listeners[eventName], listener)
  }

  function remove (arr, listener) {
    if (!arr) return
    var index = arr.indexOf(listener)
    if (index !== -1) {
      splice(arr, index, 1)
      return true
    }
  }
}

Nanobus.prototype.removeAllListeners = function (eventName) {
  if (eventName) {
    if (eventName === '*') {
      this._starListeners = []
    } else {
      this._listeners[eventName] = []
    }
  } else {
    this._starListeners = []
    this._listeners = {}
  }
  return this
}

Nanobus.prototype.listeners = function (eventName) {
  var listeners = eventName !== '*'
    ? this._listeners[eventName]
    : this._starListeners

  var ret = []
  if (listeners) {
    var ilength = listeners.length
    for (var i = 0; i < ilength; i++) ret.push(listeners[i])
  }
  return ret
}

Nanobus.prototype._emit = function (arr, eventName, data, uuid) {
  if (typeof arr === 'undefined') return
  if (arr.length === 0) return
  if (data === undefined) {
    data = eventName
    eventName = null
  }

  if (eventName) {
    if (uuid !== undefined) {
      data = [eventName].concat(data, uuid)
    } else {
      data = [eventName].concat(data)
    }
  }

  var length = arr.length
  for (var i = 0; i < length; i++) {
    var listener = arr[i]
    listener.apply(listener, data)
  }
}


/***/ }),

/***/ "./node_modules/nanoscheduler/index.js":
/*!*********************************************!*\
  !*** ./node_modules/nanoscheduler/index.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var assert = __webpack_require__(/*! assert */ "./node_modules/nanoassert/index.js")

var hasWindow = typeof window !== 'undefined'

function createScheduler () {
  var scheduler
  if (hasWindow) {
    if (!window._nanoScheduler) window._nanoScheduler = new NanoScheduler(true)
    scheduler = window._nanoScheduler
  } else {
    scheduler = new NanoScheduler()
  }
  return scheduler
}

function NanoScheduler (hasWindow) {
  this.hasWindow = hasWindow
  this.hasIdle = this.hasWindow && window.requestIdleCallback
  this.method = this.hasIdle ? window.requestIdleCallback.bind(window) : this.setTimeout
  this.scheduled = false
  this.queue = []
}

NanoScheduler.prototype.push = function (cb) {
  assert.equal(typeof cb, 'function', 'nanoscheduler.push: cb should be type function')

  this.queue.push(cb)
  this.schedule()
}

NanoScheduler.prototype.schedule = function () {
  if (this.scheduled) return

  this.scheduled = true
  var self = this
  this.method(function (idleDeadline) {
    var cb
    while (self.queue.length && idleDeadline.timeRemaining() > 0) {
      cb = self.queue.shift()
      cb(idleDeadline)
    }
    self.scheduled = false
    if (self.queue.length) self.schedule()
  })
}

NanoScheduler.prototype.setTimeout = function (cb) {
  setTimeout(cb, 0, {
    timeRemaining: function () {
      return 1
    }
  })
}

module.exports = createScheduler


/***/ }),

/***/ "./node_modules/nanotiming/browser.js":
/*!********************************************!*\
  !*** ./node_modules/nanotiming/browser.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var scheduler = __webpack_require__(/*! nanoscheduler */ "./node_modules/nanoscheduler/index.js")()
var assert = __webpack_require__(/*! assert */ "./node_modules/nanoassert/index.js")

var perf
nanotiming.disabled = true
try {
  perf = window.performance
  nanotiming.disabled = window.localStorage.DISABLE_NANOTIMING === 'true' || !perf.mark
} catch (e) { }

module.exports = nanotiming

function nanotiming (name) {
  assert.equal(typeof name, 'string', 'nanotiming: name should be type string')

  if (nanotiming.disabled) return noop

  var uuid = (perf.now() * 10000).toFixed() % Number.MAX_SAFE_INTEGER
  var startName = 'start-' + uuid + '-' + name
  perf.mark(startName)

  function end (cb) {
    var endName = 'end-' + uuid + '-' + name
    perf.mark(endName)

    scheduler.push(function () {
      var err = null
      try {
        var measureName = name + ' [' + uuid + ']'
        perf.measure(measureName, startName, endName)
        perf.clearMarks(startName)
        perf.clearMarks(endName)
      } catch (e) { err = e }
      if (cb) cb(err, name)
    })
  }

  end.uuid = uuid
  return end
}

function noop (cb) {
  if (cb) {
    scheduler.push(function () {
      cb(new Error('nanotiming: performance API unavailable'))
    })
  }
}


/***/ }),

/***/ "./node_modules/process/browser.js":
/*!*****************************************!*\
  !*** ./node_modules/process/browser.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),

/***/ "./node_modules/remove-array-items/index.js":
/*!**************************************************!*\
  !*** ./node_modules/remove-array-items/index.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Remove a range of items from an array
 *
 * @function removeItems
 * @param {Array<*>} arr The target array
 * @param {number} startIdx The index to begin removing from (inclusive)
 * @param {number} removeCount How many items to remove
 */
module.exports = function removeItems (arr, startIdx, removeCount) {
  var i, length = arr.length

  if (startIdx >= length || removeCount === 0) {
    return
  }

  removeCount = (startIdx + removeCount > length ? length - startIdx : removeCount)

  var len = length - removeCount

  for (i = startIdx; i < len; ++i) {
    arr[i] = arr[i + removeCount]
  }

  arr.length = len
}


/***/ }),

/***/ 0:
/*!****************************************!*\
  !*** multi ./js/admin-page-columns.ts ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./js/admin-page-columns.ts */"./js/admin-page-columns.ts");


/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = jQuery;

/***/ })

/******/ });
//# sourceMappingURL=admin-page-columns.js.map