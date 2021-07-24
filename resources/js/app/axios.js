window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios.defaults.withCredentials = true;
var csrf = document.querySelector(
    'meta[name="csrf-token"]'
).content;
window.axios.defaults.headers.common["X-CSRF-TOKEN"] = csrf;
