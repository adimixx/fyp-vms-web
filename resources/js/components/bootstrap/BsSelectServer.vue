<template>
    <div>
        <label :for="formName" v-if="formLabel != null" class="fw-bold">{{
            formLabel
        }}</label>
        <v-select
            v-model="selectedItem"
            :options="data"
            @search="query => searchData(query)"
            :filterable="false"
        >
            <li slot="list-footer">
                <div class="row mx-0">
                    <div class="col-12">
                        <p class="text-secondary text-center">
                            Page
                            {{ currentPage }}
                            of
                            {{ lastPage }}
                        </p>
                    </div>
                    <div class="col">
                        <div class="d-grid">
                            <a
                                class="btn btn-outline-secondary"
                                @click="loadPrevPage()"
                                :disabled="!hasPrevPage"
                            >
                                Prev
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-grid">
                            <a
                                class="btn btn-primary"
                                @click="loadNextPage()"
                                :disabled="!hasNextPage"
                            >
                                Next
                            </a>
                        </div>
                    </div>
                </div>
            </li>
        </v-select>
        <FormulateInput
            type="hidden"
            :name="formName"
            :help="formHelp"
            :validation="formValidation"
            :validation-name="formValidationName"
            v-model="selectedInput"
        />
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: [],
            lastPage: 0,
            currentPage: 1,
            filter: null,
            selectedItem: null,
            selectedInput: null
        };
    },
    props: {
        url: String,
        formName: String,
        formHelp: String,
        formValidation: String,
        formValidationName: String,
        formLabel: String
    },
    mounted() {
        this.loadData();
    },
    watch: {
        url(val) {
            this.loadData();
            this.selectedItem = null;
        },
        selectedItem(val) {
            if (val) {
                this.selectedInput = val.value;
            } else this.selectedInput = null;
            this.$emit("on-selected-change", val);
        }
    },
    computed: {
        hasNextPage: function() {
            return Boolean(this.currentPage < this.lastPage);
        },

        hasPrevPage: function() {
            return Boolean(this.currentPage != 1);
        }
    },
    methods: {
        async loadData() {
            var param = {
                "page[number]": this.currentPage
            };
            if (this.filter) param.search = this.filter;

            var res = await axios.get(this.url, {
                params: param
            });

            this.lastPage = res.data.last_page;
            this.currentPage = res.data.current_page;
            this.data = res.data.data;
        },
        async loadNextPage() {
            if (this.hasNextPage) {
                this.currentPage++;
                await this.loadData();
            } else {
                console.log(
                    "Maximum page on Select Pagination, Page " +
                        this.currentPage +
                        " of " +
                        this.lastPage
                );
            }
        },
        async loadPrevPage() {
            if (this.hasPrevPage) {
                this.currentPage--;
                await this.loadData();
            } else {
                console.log(
                    "Maximum page on Select Pagination, Page " +
                        this.currentPage +
                        " of " +
                        this.lastPage
                );
            }
        },
        searchData(query) {
            this.currentPage = 1;
            this.filter = query;
            this.loadData();
        }
    }
};
</script>

<style></style>
