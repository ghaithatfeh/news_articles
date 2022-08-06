<template>
    <div class="row">
        <div class="col-3" v-for="image in dataImages" :key="image.id">
            <img
                class="img-fluid"
                :src="image.src"
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
