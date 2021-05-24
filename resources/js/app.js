/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;

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
    classes: {
        outer: "mb-3",
        label: "form-label",
        element: "mw-100",
        input: "form-control",
        inputHasErrors: "is-invalid",
        errors: "text-danger list-unstyled mt-2",
        help: "form-text"
    },
    locales: {
        en: {
            required({ name }) {
                return `Sila isi ${name}`;
            },
            min({ name, args }) {
                return `Nilai ${name} mestilah sekurang-kurangnya ${args} `;
            },
            after({ name, args }) {
                return `${name} mestilah selepas ${args} `;
            }
        }
    },
    validationNameStrategy: ["validationName", "label", "name", "type"]
});

const app = new Vue({
    el: "#app",
    mounted() {
        // console.log(Vue.options.components);
    }
});
