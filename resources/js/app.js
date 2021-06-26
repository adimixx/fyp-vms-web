/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;

// require('chart.js');

// require("startbootstrap-sb-admin-2/js/sb-admin-2.js");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

var files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
    Vue.component(
        key
            .split("/")
            .pop()
            .split(".")[0],
        files(key).default
    )
);
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VueFormulate from "@braid/vue-formulate";
Vue.use(VueFormulate, {
    useInputDecorators: false,
    classes: {
        outer: "mb-3",
        label: "form-label",
        element: "mw-100",
        input: "form-control",
        inputHasErrors: "is-invalid",
        errors: "text-danger list-unstyled mt-2",
        help: "form-text",
        groupRepeatable: "row",
        formErrors: "alert alert-danger list-unstyled",
        decorator: "form-check-input"
    },
    locales: {
        en: {
            // required({ name }) {
            //     return `Sila isi ${name}`;
            // },
            // min({ name, args }) {
            //     return `Nilai ${name} mestilah sekurang-kurangnya ${args} `;
            // },
            // after({ name, args }) {
            //     return `${name} mestilah selepas ${args} `;
            // },
            requiredIf: ({ name }) => `${name} is required`
        }
    },
    validationNameStrategy: ["validationName", "label", "name", "type"],
    rules: {
        requiredIf: function(context, formKey, formValue) {
            var a = (context.getFormValues()[formKey] == formValue);
            var b = ((formValue == "undefined" || formValue == "null") && typeof context.getFormValues()[formKey] === "undefined");

            if (a || b) {
                if (context.value.length == 0) {
                    return false;
                }
            }

            return true;
        }
    }
});

import { ServerTable, ClientTable, Event } from "vue-tables-2";
// Vue.use(ClientTable, [options = {}], [useVuex = false], [theme = 'bootstrap4'], [swappables = {}]);
// Vue.use(ServerTable, [options = {}], [useVuex = false], [theme = 'bootstrap4'], [swappables = {}]);
import vtGenericFilter from "./components/vueTables/vtGenericFilter.vue";
import vtPerPageSelector from "./components/vueTables/vtPerPageSelector.vue";
import Vue from "vue";

Vue.use(ClientTable, {}, false, "bootstrap4");
Vue.use(
    ServerTable,
    {
        skin: "table table-striped table-hover table-light",
        sortIcon: {
            base: "fas fa-sort",
            up: "fas fa-sort-up",
            down: "fas fa-sort-down",
            is: "glyphicon-sort"
        },
        requestFunction(data) {
            const param = {
                ascending: data.ascending,
                orderBy: data.orderBy,
                query: data.query,
                "page[number]": data.page,
                "page[size]": data.limit
            };

            return axios
                .get(this.url, {
                    params: param
                })
                .catch(function(e) {
                    this.dispatch("error", e);
                });
        },
        responseAdapter(resp) {
            var data = this.getResponseData(resp);
            return { data: data.data, count: data.total };
        }
    },
    false,
    "bootstrap4",
    {
        genericFilter: vtGenericFilter,
        perPageSelector: vtPerPageSelector
    }
);

window.Chart = require('chart.js');

const app = new Vue({
    el: "#app",
    data() {
        return {
            alert: {
                msg: null,
                boldMsg: null,
                classColor: null,
                date: null
            },
            toast: {
                msg: null,
                boldMsg: null,
                classColor: null,
                show: false
            }
        };
    },
    methods: {
        activateAlert(boldMsg, msg, classColor) {
            this.alert.msg = msg;
            this.alert.boldMsg = boldMsg;
            this.alert.classColor = classColor;
            this.alert.date = Date.now();
        },
        activateToast(boldMsg, msg, classColor) {
            this.toast.msg = msg;
            this.toast.boldMsg = boldMsg;
            this.toast.classColor = classColor;
            this.toast.show = true;
        },
        dismissToast() {
            this.toast.show = false;
        }
    }
});
