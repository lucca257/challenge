(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/product/list.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/product/list.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "product-list",
  data: function data() {
    return {
      products: null,
      loading: false,
      editId: null,
      baseUrl: 'api/products/',
      editProductData: {
        id: null,
        name: null,
        price: null,
        description: null
      }
    };
  },
  mounted: function mounted() {
    this.loadProducts();
  },
  methods: {
    loadProducts: function loadProducts() {
      var _this = this;

      axios.get(this.baseUrl, this.fields).then(function (response) {
        _this.products = response.data;
        _this.loading = true;
      })["catch"](function (error) {
        console.log(error);
      });
    },
    onDelete: function onDelete(id) {
      var _this2 = this;

      axios["delete"](this.baseUrl + id).then(function (response) {
        _this2.loadProducts();

        alert("produto deletado");
      })["catch"](function (error) {
        console.log(error.response.data);
      });
    },
    onEdit: function onEdit(product) {
      this.editId = product.id;
      this.editProductData.name = product.name;
      this.editProductData.price = product.price;
      this.editProductData.description = product.description;
      this.editProductData.id = this.editId;
    },
    onEditSubmit: function onEditSubmit() {
      var _this3 = this;

      axios.patch(this.baseUrl + this.editId, this.editProductData).then(function (response) {
        _this3.onEditCancel();

        _this3.loadProducts();
      })["catch"](function (error) {
        console.log(error);
      });
    },
    onEditCancel: function onEditCancel() {
      this.editId = null;
      this.editProductData.name = null;
      this.editProductData.price = null;
      this.editProductData.id = this.editId;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/product/list.vue?vue&type=template&id=84d5daee&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/product/list.vue?vue&type=template&id=84d5daee& ***!
  \***************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "product-list" }, [
    _c("div", { staticClass: "card-header" }, [
      _vm._v("\n        Lista de produtos\n    ")
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "card-body" }, [
      _vm.loading
        ? _c("div", { staticClass: "table-responsive" }, [
            _c(
              "table",
              { staticClass: "table" },
              [
                _vm._m(0),
                _vm._v(" "),
                _vm._l(_vm.products, function(product) {
                  return _c("tbody", [
                    _c(
                      "tr",
                      [
                        _vm.editId == product.id
                          ? [
                              _c("td", [
                                _c("input", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: _vm.editProductData.name,
                                      expression: "editProductData.name"
                                    }
                                  ],
                                  attrs: { type: "text" },
                                  domProps: { value: _vm.editProductData.name },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        _vm.editProductData,
                                        "name",
                                        $event.target.value
                                      )
                                    }
                                  }
                                })
                              ]),
                              _vm._v(" "),
                              _c("td", [
                                _c("input", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: _vm.editProductData.price,
                                      expression: "editProductData.price"
                                    }
                                  ],
                                  attrs: {
                                    type: "number",
                                    min: "0",
                                    step: "0.01",
                                    "data-number-to-fixed": "2",
                                    "data-number-stepfactor": "100",
                                    required: ""
                                  },
                                  domProps: {
                                    value: _vm.editProductData.price
                                  },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        _vm.editProductData,
                                        "price",
                                        $event.target.value
                                      )
                                    }
                                  }
                                })
                              ]),
                              _vm._v(" "),
                              _c("td", [
                                _c("input", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: _vm.editProductData.description,
                                      expression: "editProductData.description"
                                    }
                                  ],
                                  attrs: { type: "text" },
                                  domProps: {
                                    value: _vm.editProductData.description
                                  },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        _vm.editProductData,
                                        "description",
                                        $event.target.value
                                      )
                                    }
                                  }
                                })
                              ]),
                              _vm._v(" "),
                              _c("td", [
                                _c(
                                  "span",
                                  {
                                    staticClass: "icon",
                                    on: {
                                      click: function($event) {
                                        return _vm.onEditSubmit()
                                      }
                                    }
                                  },
                                  [_c("i", { staticClass: "fa fa-check" })]
                                ),
                                _vm._v(" "),
                                _c(
                                  "span",
                                  {
                                    staticClass: "icon",
                                    on: {
                                      click: function($event) {
                                        return _vm.onEditCancel()
                                      }
                                    }
                                  },
                                  [_c("i", { staticClass: "fa fa-ban" })]
                                )
                              ])
                            ]
                          : [
                              _c("td", [_vm._v(_vm._s(product.name))]),
                              _vm._v(" "),
                              _c("td", [_vm._v(_vm._s(product.price))]),
                              _vm._v(" "),
                              _c("td", [_vm._v(_vm._s(product.description))]),
                              _vm._v(" "),
                              _c("td", [
                                _vm._m(1, true),
                                _vm._v(" "),
                                _c(
                                  "a",
                                  { staticClass: "icon", attrs: { href: "#" } },
                                  [
                                    _c("i", {
                                      staticClass: "fa fa-pencil",
                                      attrs: { "aria-hidden": "true" },
                                      on: {
                                        click: function($event) {
                                          return _vm.onEdit(product)
                                        }
                                      }
                                    })
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "a",
                                  { staticClass: "icon", attrs: { href: "#" } },
                                  [
                                    _c("i", {
                                      staticClass: "fa fa-trash",
                                      attrs: { "aria-hidden": "true" },
                                      on: {
                                        click: function($event) {
                                          return _vm.onDelete(product.id)
                                        }
                                      }
                                    })
                                  ]
                                )
                              ])
                            ]
                      ],
                      2
                    )
                  ])
                })
              ],
              2
            )
          ])
        : _c("div", [_c("h3", [_vm._v("Carregando...")])])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("Nome do produto")]),
        _vm._v(" "),
        _c("th", [_vm._v("Preço")]),
        _vm._v(" "),
        _c("th", [_vm._v("Descrição")]),
        _vm._v(" "),
        _c("th", [_vm._v("Ações")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("a", { staticClass: "icon", attrs: { href: "#" } }, [
      _c("i", { staticClass: "fa fa-eye", attrs: { "aria-hidden": "true" } })
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/product/list.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/product/list.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _list_vue_vue_type_template_id_84d5daee___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./list.vue?vue&type=template&id=84d5daee& */ "./resources/js/components/product/list.vue?vue&type=template&id=84d5daee&");
/* harmony import */ var _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./list.vue?vue&type=script&lang=js& */ "./resources/js/components/product/list.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _list_vue_vue_type_template_id_84d5daee___WEBPACK_IMPORTED_MODULE_0__["render"],
  _list_vue_vue_type_template_id_84d5daee___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/product/list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/product/list.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/product/list.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/product/list.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/product/list.vue?vue&type=template&id=84d5daee&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/product/list.vue?vue&type=template&id=84d5daee& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_84d5daee___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./list.vue?vue&type=template&id=84d5daee& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/product/list.vue?vue&type=template&id=84d5daee&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_84d5daee___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_84d5daee___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);