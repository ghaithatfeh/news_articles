<template>
    <div class="row">
        <div class="col-4 col-md-3 p-1" v-for="image in dataImages" :key="image.id">
            <img
                loading="lazy"
                style="cursor: pointer"
                class="img-fluid rounded"
                :src="image.tinygif_url"
                @click="toggleImage(image)"
                :class="{ 'border border-primary border-5': image.selected }"
            />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        dataImages: Array,
    },
    methods: {
        toggleImage(image) {
            image.selected = !image.selected;
            this.$emit(
                "toggleImage",
                this.dataImages.filter((i) => i.selected == true)
            );
        },
    },
};
</script>
