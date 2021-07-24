

import { ServerTable, ClientTable, Event } from "vue-tables-2";
// Vue.use(ClientTable, [options = {}], [useVuex = false], [theme = 'bootstrap4'], [swappables = {}]);
// Vue.use(ServerTable, [options = {}], [useVuex = false], [theme = 'bootstrap4'], [swappables = {}]);
import vtGenericFilter from "./vtGenericFilter.vue";
import vtPerPageSelector from "./vtPerPageSelector.vue";

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
