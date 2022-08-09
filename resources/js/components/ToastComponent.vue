<template>
    <div class="toast-container position-fixed end-0 p-3" style="top: 30px">
        <div
            id="toast"
            class="toast align-items-center border-0"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
        >
            <div class="d-flex">
                <div class="toast-body" v-html="data.text"></div>
                <button
                    type="button"
                    class="btn-close me-2 m-auto"
                    data-bs-dismiss="toast"
                    aria-label="Close"
                ></button>
            </div>
        </div>
    </div>
</template>

<script>
import { Toast } from "bootstrap";

export default {
    name: "ToastComponent",
    props: {
        data: Object,
    },
    data() {
        return {
            toast: undefined,
            toastEl: undefined,
        };
    },
    mounted() {
        this.toastEl = document.getElementById("toast");
        this.toast = new Toast(this.toastEl);
    },
    methods: {
        show() {
            this.toast.show();
            this.toastEl.classList.remove("text-bg-success", "text-bg-danger");
            this.toastEl.classList.add(
                this.data.success ? "text-bg-success" : "text-bg-danger"
            );
        },
    },
};
</script>
