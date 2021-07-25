<template>
    <div
        :class="`alert alert-${classColor} alert-dismissible`"
        role="alert"
        v-if="visible"
    >
        <strong v-if="boldMsg != null">{{ boldMsg }}</strong>
        {{ msg }}
        <button
            type="button"
            class="btn-close"
            aria-label="Close"
            @click="visible = false"
        ></button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            visible: false
        }
    },
    props: {
        boldMsg: String,
        msg: String,
        classColor: String,
        date: Number,
        initVisible: Boolean
    },
    mounted(){
        if (this.initVisible){
            this.visible = true;
        }
    },
    watch: {
        date: function (val) {
            this.visible = true;
        }
    }
};
</script>

<style></style>
