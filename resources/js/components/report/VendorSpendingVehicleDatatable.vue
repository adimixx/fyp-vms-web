<template>
    <div>
        <div class="mb-2">
            <button class="btn btn-secondary" @click="showFilter = !showFilter">
                <i class="fas fa-filter"></i> Filter
            </button>
            <div class="m-1" v-if="showFilter">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label"
                            >Filter by Maintenance Category</label
                        >
                        <Multiselect
                            v-model="maintenanceType"
                            :filterResults="false"
                            :minChars="0"
                            :delay="0"
                            :resolveOnLoad="true"
                            :searchable="true"
                            :options="loadMaintenanceType"
                            ref="maintenanceTypeSelect"
                        />
                    </div>
                </div>
            </div>
        </div>

        <v-server-table
            :url="dtUrl"
            :columns="table.columns"
            :options="table.options"
            v-if="loaded"
        >
            <template v-slot:actions="props">
                <a
                    class="text-decoration-none"
                    :href="route + '/' + props.row.id"
                >
                    <i class="far fa-eye"></i>
                </a>
            </template>
        </v-server-table>
    </div>
</template>

<script>
import VueCompositionAPI from "@vue/composition-api";
Vue.use(VueCompositionAPI);
import Multiselect from "@vueform/multiselect/dist/multiselect.vue2.js";

export default {
    components: {
        Multiselect
    },
    data() {
        return {
            table: {
                columns: ["spending", "vendor"],
                options: {
                    headings: {}
                }
            },
            dtUrl: "",
            maintenanceType: 0,
            loaded: false,
            showFilter: false
        };
    },
    props: {
        route: String,
        apiUrl: String,
        maintenanceTypeList: String
    },
    mounted() {
        this.dtUrl = this.apiUrl;
        this.loaded = true;
    },
    watch: {
        maintenanceType(val) {
            console.log(val);
            if (val > 0) {
                this.dtUrl = this.apiUrl + `/${val}`;
            } else this.dtUrl = this.apiUrl;
        }
    },
    methods: {
        async loadMaintenanceType(query) {
            var link = this.maintenanceTypeList;
            if (query) {
                link += `?search=${query}`;
            }

            var res = await axios.get(link);
            return res.data;
        }
    }
};
</script>

<style></style>
