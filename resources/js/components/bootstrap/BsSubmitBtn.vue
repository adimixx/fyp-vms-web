<template>
    <div class="d-flex flex-row justify-content-end">
        <div class="mr-1">
            <button
                type="button"
                class="btn btn-secondary"
                @click="dismiss"
            >
                Cancel
            </button>
        </div>
        <div>
            <input
                type="submit"
                class="btn btn-primary text-white"
                value="Save"
            />
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        dismiss() {
            this.$emit('on-dismiss');
        }
    }
};
</script>

<style></style>
