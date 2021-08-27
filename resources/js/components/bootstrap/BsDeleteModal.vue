<template>
    <!-- Modal -->
    <div class="modal fade" ref="modalDelete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down">
            <div class="modal-content">
                <div class="modal-body my-4 text-center">
                    <p class="fw-bold">
                        Are you sure you want to delete this item?
                    </p>

                    <div class="my-3">
                        <slot name="content"></slot>
                    </div>

                    <button
                        type="button"
                        class="btn btn-secondary"
                        @click="onDismissModal"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="onDelete"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from "bootstrap";
export default {
    data() {
        return {
            modal: null,
            dataChange: false
        };
    },
    props: {
        url: String
    },
    mounted() {
        this.modal = new Modal(this.$refs.modalDelete, {
            keyboard: false,
            backdrop: "static"
        });
        this.modal.show();
    },
    methods: {
        async onDelete() {
            try {
                await axios.delete(this.url);
                this.$emit(
                    "activate-toast",
                    "Success",
                    "Item deleted",
                    "success"
                );
                this.dataChange = true;
            } catch (error) {
                if (error.response) {
                    var msg =
                        error.response.data.message ??
                        "Server Error. Please Try Again";

                    this.$emit("activate-toast", "Error", msg, "danger");
                }
            }

            this.onDismissModal();
        },
        onDismissModal() {
            this.modal.hide();
            this.$emit("dismiss-modal", this.dataChange);
        }
    }
};
</script>

<style></style>
