<template>
    <div class="toast-container position-fixed end-0 p-3" style="top: 30px">
        <div
            id="toast"
            class="toast align-items-center border-0"
            :class="{ 'text-bg-success': data.success , 'text-bg-danger': !data.success}"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
        >
            <div class="d-flex">
                <div class="toast-body">
                    {{ data.text }}
                </div>
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
export default {
    name: "ToastComponent",
    props: {
        data: Object,
    },
};
</script>
