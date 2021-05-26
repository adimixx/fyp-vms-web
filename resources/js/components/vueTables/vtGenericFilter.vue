<template>
    <div class="VueTables__search-field">
        <div class="d-inline-block col-12 col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-light border-1 border-end-0">
                    <i class="fas fa-search"></i>
                </span>
                <input
                    type="text"
                    class="bg-light form-control border-1 border-start-0 small"
                    ref="filter"
                    placeholder="Filter data"
                    @keyup="e => props.search(props.opts.debounce)(e)"
                    :id="`VueTables__search_${props.id}`"
                    autocomplete="off"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MyGenericFilter",
    props: ["props"],
    methods: {
        focus() {
            this.$refs.filter.focus();
        },
        blur() {
            this.$refs.filter.blur();
        }
    }
};
</script>
