<template>
    <div
        class="position-fixed bottom-0 start-50 translate-middle-x p-3"
        style="z-index: 5"
    >
        <div
            ref="bsToast"
            :class="`toast hide bg-${classColor} text-white`"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
        >
            <div class="d-flex justify-content-between">
                <div class="toast-body flex-fill">
                    <span class="fw-bold">{{ boldMsg }}</span> {{ msg }}
                </div>
                <button
                    type="button"
                    class="btn-close btn-close-white my-auto mx-3"
                    aria-label="Close"
                    @click="dismissToast"
                ></button>
            </div>
        </div>
    </div>
</template>

<script>
import { Toast } from "bootstrap";
export default {
    data() {
        return {
            toast: null
        };
    },
    props: {
        boldMsg: String,
        msg: String,
        classColor: String
    },
    mounted() {
        this.toast = new Toast(this.$refs.bsToast, {});
        this.toast.show();
        this.$refs.bsToast.addEventListener("hidden.bs.toast", () => {
            this.$emit("dismiss-toast");
        });
    },
    methods: {
        dismissToast() {
            this.toast.hide();
        }
    }
};
</script>

<style></style>
