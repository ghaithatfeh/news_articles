<template>
    <div class="row">
        <div class="col-3" v-for="image in dataImages" :key="image.id">
            <img class="img-fluid" :src="image.src" @click="addImage(image)" :class="{'border border-primary border-5': image.selected}" />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        dataImages: Array,
    },
    data() {
        return {
            selectedImages: [],
        };
    },
    emits: ['selectImage'],
    methods: {
        addImage(image) {
            image.selected = !image.selected
            if (this.selectedImages.find((i) => i == image))
                this.selectedImages = this.selectedImages.filter(
                    (i) => i != image
                );
            else this.selectedImages.push(image);
            this.$emit('selectImage', this.selectedImages)
        },
    },
};
</script>