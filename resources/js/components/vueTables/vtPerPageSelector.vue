<template>
    <div class="VueTables__limit-field">
        <div class="input-group">
            <label
                class="input-group-text bg-light border-1 border-end-0"
                :for="`VueTables__limit_${props.id}`"
            >
                {{ props.display("limit") }}
            </label>
            <select
                :id="props.selectAttrs.id"
                class="bg-light form-select border-1 border-start-0 small"
                @change="props.selectEvents.change"
            >
                <option
                    v-for="val in props.perPageValues"
                    :key="val"
                    :value="val"
                    :selected="val === props.selectAttrs.value"
                    >{{ val }}</option
                >
            </select>
        </div>
    </div>
</template>

<script>
export default {
    name: "MyPerPageSelector",
    props: ["props"]
};
</script>
