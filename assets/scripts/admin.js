/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/admin/modules/installation_counter.js":
/*!***************************************************!*\
  !*** ./src/admin/modules/installation_counter.js ***!
  \***************************************************/
/***/ (() => {

;
(function ($) {
  function bkbm_kbtfw_installation_counter() {
    return $.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        action: "bkbm_kbtfw_installation_counter",
        // this is the name of our WP AJAX function that we'll set up next
        product_id: BkbmKbtfwAdminData.product_id // change the localization variable.
      },

      dataType: "JSON"
    });
  }
  if (typeof BkbmKbtfwAdminData.installation != "undefined" && BkbmKbtfwAdminData.installation != 1) {
    $.when(bkbm_kbtfw_installation_counter()).done(function (response_data) {
      // console.log(response_data)
    });
  }
})(jQuery);

/***/ }),

/***/ "./src/admin/modules/kbtfw_admin_scripts.js":
/*!**************************************************!*\
  !*** ./src/admin/modules/kbtfw_admin_scripts.js ***!
  \**************************************************/
/***/ (() => {

;
(function ($) {
  if (typeof inlineEditPost == "undefined") {
    return "";
  }

  // we create a copy of the WP inline edit post function
  var $wp_inline_edit = inlineEditPost.edit;

  // and then we overwrite the function with our own code
  inlineEditPost.edit = function (id) {
    // "call" the original WP edit function
    // we don't want to leave WordPress hanging
    $wp_inline_edit.apply(this, arguments);

    // now we take care of our business

    // get the post ID

    var $post_id = 0;
    if (typeof id == "object") $post_id = parseInt(this.getId(id));
    if ($post_id > 0) {
      // define the edit row
      var $edit_row = $("#edit-" + $post_id);

      // Display Status

      var bkb_woo_tab_hide_status = $("#bkb_woo_tab_hide_status-" + $post_id).data("status_code");
      $edit_row.find('select[name="bkb_woo_tab_hide_status"]').val(bkb_woo_tab_hide_status == "" ? 3 : bkb_woo_tab_hide_status);
    }
  };

  /*------------------------------ Bulk Edit Settings ---------------------------------*/

  $("#bulk_edit").on("click", function () {
    // define the bulk edit row
    let $bulk_row = $("#bulk-edit");
    $post_ids = new Array();
    $bulk_row.find("#bulk-titles-list .button-link.ntdelbutton").each(function () {
      $post_ids.push($(this).attr("id").replace(/_/g, ""));
    });

    // get the $bkb_display_status

    var $bkb_woo_tab_hide_status = $bulk_row.find('select[name="bkb_woo_tab_hide_status"]').val();
    // save the data
    $.ajax({
      url: ajaxurl,
      // this is a variable that WordPress has already defined for us
      type: "POST",
      async: false,
      cache: false,
      data: {
        action: "manage_wp_posts_using_bulk_edit_kbtfw",
        // this is the name of our WP AJAX function that we'll set up next
        post_ids: $post_ids,
        // and these are the 2 parameters we're passing to our function
        bkb_woo_tab_hide_status: $bkb_woo_tab_hide_status
      }
    });
  });
})(jQuery);

/***/ }),

/***/ "./src/admin/styles/admin.scss":
/*!*************************************!*\
  !*** ./src/admin/styles/admin.scss ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!**********************************!*\
  !*** ./src/admin/admin_index.js ***!
  \**********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _styles_admin_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./styles/admin.scss */ "./src/admin/styles/admin.scss");
/* harmony import */ var _modules_installation_counter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/installation_counter */ "./src/admin/modules/installation_counter.js");
/* harmony import */ var _modules_installation_counter__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_modules_installation_counter__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _modules_kbtfw_admin_scripts__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modules/kbtfw_admin_scripts */ "./src/admin/modules/kbtfw_admin_scripts.js");
/* harmony import */ var _modules_kbtfw_admin_scripts__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_modules_kbtfw_admin_scripts__WEBPACK_IMPORTED_MODULE_2__);
// Load Stylesheets.


// Load JavaScripts


})();

/******/ })()
;
//# sourceMappingURL=admin.js.map