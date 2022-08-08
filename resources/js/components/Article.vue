<template>
    <ToastComponent :data="toastData" />
    <div class="container">
        <input
            type="text"
            v-model="title"
            placeholder="Article Title"
            class="form-control mx-auto my-3"
            style="font-size: 1.2rem; max-width: 650px"
        />
        <div id="editorjs"></div>
        <div class="d-flex my-4">
            <button class="btn btn-success mx-auto" @click="save">
                Save Article
            </button>
        </div>
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
                    <form
                        class="d-flex align-items-start"
                        @submit.prevent="getData(searchText)"
                    >
                        <input
                            v-model="searchText"
                            class="form-control mb-3 border-righ"
                            placeholder="Search for GIF"
                            style="border-radius: 5px 0 0 5px"
                        />
                        <button
                            class="btn btn-primary"
                            style="border-radius: 0 5px 5px 0"
                        >
                            Search
                        </button>
                    </form>

                    <div v-if="loading" class="d-flex my-5">
                        <img
                            class="w-25 mx-auto"
                            src="https://c.tenor.com/I6kN-6X7nhAAAAAi/loading-buffering.gif"
                            alt=""
                        />
                    </div>

                    <ImagesSelector
                        :dataImages="dataImages"
                        @toggleImage="getSelectedImages"
                    />
                </div>
                <div class="modal-footer">
                    <button
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
import { Modal, Toast } from "bootstrap";
import ImagesSelector from "./ImagesSelector.vue";
import ToastComponent from "./ToastComponent.vue";
import axios from "axios";

let selectedImages = null;

class Gif {
    static get toolbox() {
        return {
            title: "GIF",
            icon: '<svg width="17" height="15" viewBox="0 0 336 276" xmlns="http://www.w3.org/2000/svg"><path d="M291 150V79c0-19-15-34-34-34H79c-19 0-34 15-34 34v42l67-44 81 72 56-29 42 30zm0 52l-43-30-56 30-81-67-66 39v23c0 19 15 34 34 34h178c17 0 31-13 34-29zM79 0h178c44 0 79 35 79 79v118c0 44-35 79-79 79H79c-44 0-79-35-79-79V79C0 35 35 0 79 0z"/></svg>',
        };
    }

    constructor({ data, api }) {
        this.api = api;
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
                img.src = image.gif_url;
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
            urls: data,
        };
    }

    validate(savedData) {
        if (savedData.urls.length) {
            return true;
        }
        return false;
    }
}

export default {
    components: { ImagesSelector, ToastComponent },
    methods: {
        async getData(query = "") {
            this.loading = true;
            this.dataImages = [];
            axios
                .get("http://localhost:3000/api/gifs", {
                    params: { q: query },
                })
                .then((res) => {
                    this.dataImages = res.data;
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getSelectedImages(images) {
            selectedImages = images;
        },
        insert() {
            this.dataImages.map((i) => (i.selected = false));
        },
        save() {
            const toast = new Toast("#toast");
            this.editor
                .save()
                .then((outputData) => {
                    axios
                        .post("/article", {
                            _token: document.getElementById('csrf-token').content,
                            title: this.title,
                            blocks: outputData.blocks,
                        })
                        .then((res) => {
                            this.toastData.success = true;
                            this.toastData.text = "Article has been created successfuly.";
                            toast.show();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.toastData.success = false;
                            this.toastData.text = error.response.data.message;
                            toast.show();
                        });
                })
        },
    },
    mounted() {
        this.getData();
    },
    data() {
        return {
            title: "",
            savedData: "",
            searchText: "",
            toastData: { success: true, text: "" },
            dataImages: [],
            loading: false,

            editor: new EditorJS({
                tools: {
                    gif: {
                        class: Gif,
                    },
                },
                // data: {
                //     time: 1552744582955,
                //     blocks: [
                //         {
                //             type: "gif",
                //             data: [
                //                 {
                //                     gif_url: "https://unsplash.it/200?1",
                //                 },
                //                 {
                //                     gif_url: "https://unsplash.it/200?3",
                //                 },
                //             ],
                //         },
                //         {
                //             type: "gif",
                //             data: [
                //                 {
                //                     gif_url: "https://unsplash.it/200?2",
                //                 },
                //             ],
                //         },
                //     ],
                //     version: "2.11.10",
                // },
            }),
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
    border-radius: 0 0 8px 8px;
}

.ce-block:first-child .ce-block__content {
    border-radius: 8px 8px 0 0;
}

.ce-block:only-child .ce-block__content {
    border-radius: 8px;
}

.gifs-wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
.gifs-wrapper img {
    border-radius: 8px;
    margin: 0.5rem;
    max-width: 100%;
}
#editorjs,
#editorjs > div > div {
    padding-bottom: 0 !important;
}
</style>
