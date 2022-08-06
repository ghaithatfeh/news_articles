<template>
    <div class="container">
        <div id="editorjs"></div>
    </div>
    <div class="d-flex">
        <button class="btn btn-success mx-auto" @click="save">
            Save Article
        </button>
    </div>

    <div id="modal" class="modal" tabindex="-1" aria-modal="true" role="dialog">
        <div
            class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select GIFs</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <ImagesSelector
                        :dataImages="dataImages"
                        @toggleImage="getSelectedImages"
                    />
                </div>
                <div class="modal-footer">
                    <button
                        id="close-btn"
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button
                        id="insert-btn"
                        type="button"
                        class="btn btn-primary"
                        @click="insert"
                    >
                        Insert
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import EditorJS from "@editorjs/editorjs";
import { Modal } from "bootstrap";
import ImagesSelector from "./ImagesSelector.vue";

let selectedImages = null;

class Gif {
    static get toolbox() {
        return {
            title: "GIF",
            icon: '<svg width="17" height="15" viewBox="0 0 336 276" xmlns="http://www.w3.org/2000/svg"><path d="M291 150V79c0-19-15-34-34-34H79c-19 0-34 15-34 34v42l67-44 81 72 56-29 42 30zm0 52l-43-30-56 30-81-67-66 39v23c0 19 15 34 34 34h178c17 0 31-13 34-29zM79 0h178c44 0 79 35 79 79v118c0 44-35 79-79 79H79c-44 0-79-35-79-79V79C0 35 35 0 79 0z"/></svg>',
        };
    }

    constructor({ data }) {
        this.data = data;
        this.wrapper = undefined;
        this.modal = undefined;
    }

    render() {
        this.wrapper = document.createElement("div");
        this.wrapper.classList.add("gifs-wrapper");
        this.modal = new Modal("#modal");

        if (this.data.length) {
            selectedImages = this.data;
            this.insertGifs();
            return this.wrapper;
        }

        this.modal.show();
        document.getElementById("insert-btn").onclick = () => {
            this.insertGifs();
        };
        return this.wrapper;
    }

    insertGifs() {
        selectedImages &&
            selectedImages.forEach((image) => {
                const img = document.createElement("img");
                img.src = image.src;
                this.wrapper.appendChild(img);
            });
        selectedImages = null;
        this.modal.hide();
    }

    save(blockContent) {
        let data = [];
        blockContent.querySelectorAll("img").forEach((img) => {
            data.push(img.src);
        });
        return {
            url: data,
        };
    }
}

export default {
    components: { ImagesSelector },
    methods: {
        getSelectedImages(images) {
            selectedImages = images;
        },
        insert() {
            this.dataImages.map((i) => (i.selected = false));
        },
        save() {
            this.editor
                .save()
                .then((outputData) => {
                    console.log("Article data: ", outputData.blocks[0]);
                })
                .catch((error) => {
                    console.log("Saving failed: ", error);
                });
        },
    },
    data() {
        return {
            editor: new EditorJS({
                tools: {
                    gif: {
                        class: Gif,
                    },
                },
                data: {
                    time: 1552744582955,
                    blocks: [
                        {
                            type: "gif",
                            data: [
                                {
                                    id: "1",
                                    src: "https://unsplash.it/200?1",
                                    alt: "Alt Image 1",
                                },
                                {
                                    id: "1",
                                    src: "https://unsplash.it/200?3",
                                    alt: "Alt Image 1",
                                },
                            ],
                        },
                        {
                            type: "gif",
                            data: [
                                {
                                    src: "https://unsplash.it/200?2",
                                    alt: "Alt Image 1",
                                },
                            ],
                        },
                    ],
                    version: "2.11.10",
                },
            }),
            dataImages: [
                {
                    id: "1",
                    src: "https://unsplash.it/200?1",
                    alt: "Alt Image 1",
                },
                {
                    id: "2",
                    src: "https://unsplash.it/200?2",
                    alt: "Alt Image 2",
                },
                {
                    id: "3",
                    src: "https://unsplash.it/200?3",
                    alt: "Alt Image 2",
                },
                {
                    id: "4",
                    src: "https://unsplash.it/200?4",
                    alt: "Alt Image 2",
                },
            ],
        };
    },
};
</script>

<style>
.ce-block__content {
    background-color: #eee;
    padding: 5px 10px;
}

.ce-block:last-child .ce-block__content {
    border-radius: 0 0 10px 10px;
}

.ce-block:first-child .ce-block__content {
    border-radius: 10px 10px 0 0;
}

.ce-block:only-child .ce-block__content {
    border-radius: 10px;
}
</style>
