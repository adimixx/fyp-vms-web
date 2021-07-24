window.Vue = require("vue").default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

 var files = require.context("../../", true, /\.vue$/i);
 files.keys().map(key =>
     Vue.component(
         key
             .split("/")
             .pop()
             .split(".")[0],
         files(key).default
     )
 );

 require("./vueFormulate");
 require("./vueTables/vueTables");
 require("./vueFilters");

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
