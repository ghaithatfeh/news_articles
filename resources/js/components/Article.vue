<template>
    <ToastComponent :data="toastData" ref="toast" />
    <div class="container">
        <h1 class="text-center mb-3" v-if="type === 'view'">{{ title }}</h1>
        <input
            v-else
            v-model="title"
            type="text"
            placeholder="Article Title"
            class="form-control mx-auto my-3"
            style="font-size: 1.2rem; max-width: 650px"
        />
        <div id="editorjs"></div>
        <div class="d-flex my-4">
            <button
                v-show="type !== 'view'"
                @click="submit"
                class="btn btn-success mx-auto"
            >
                {{ type === "edit" ? "Update Article" : "Save Article" }}
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
import { Modal } from "bootstrap";
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

    static get isReadOnlySupported() {
        return true;
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
const toast = undefined;

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
                    this.dataImages = res.status && res.data.gifs;
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
        submit() {
            this.editor.save().then((outputData) => {
                if (!this.validate(outputData.blocks)) return;
                if (this.type === "create") this.save(outputData.blocks);
                else if (this.type === "edit") this.update(outputData.blocks);
            });
        },
        validate(blocks) {
            if (blocks.length && this.title.length > 3) return true;
            this.toastData.success = false;
            this.toastData.text = `Article title is required and must be more than 3 character.
            <br> Article content can not be empty.`;
            this.$refs.toast.show();
        },
        save(blocks) {
            axios
                .post("/article", {
                    _token: document.getElementById("csrf-token").content,
                    title: this.title,
                    blocks: blocks,
                })
                .then((res) => {
                    this.title = "";
                    this.editor.blocks.clear();
                    this.toastData.success = true;
                    this.toastData.text =
                        "Article has been created successfuly.";
                    this.$refs.toast.show();
                })
                .catch((error) => {
                    console.log(error);
                    this.toastData.success = false;
                    this.toastData.text = error.response.data.message;
                    this.$refs.toast.show();
                });
        },
        update(blocks) {
            axios
                .put(`/article/${this.article.slug}`, {
                    _token: document.getElementById("csrf-token").content,
                    title: this.title,
                    blocks: blocks,
                })
                .then((res) => {
                    this.toastData.success = true;
                    this.toastData.text =
                        "Article has been updated successfuly.";
                    this.$refs.toast.show();
                })
                .catch((error) => {
                    console.log(error);
                    this.toastData.success = false;
                    this.toastData.text = error.response.data.message;
                    this.$refs.toast.show();
                });
        },
        loadOldData() {
            if (!this.article) return;
            this.title = this.article.title;
            this.blocks_data = this.article.blocks.map((block) => {
                const result = { type: block.type };
                if (result.type === "paragraph")
                    result.data = { text: block.value };
                else
                    result.data = block.gifs.map((gif) => {
                        return {
                            gif_url: gif.url,
                        };
                    });
                return result;
            });
        },
    },
    mounted() {
        this.getData();
        this.loadOldData();
    },
    props: {
        article: Object,
        type: String,
    },
    data() {
        return {
            title: "",
            savedData: "",
            searchText: "",
            toastData: { success: true, text: "" },
            dataImages: [],
            loading: false,
            blocks_data: [],
            editor: new EditorJS({
                tools: {
                    gif: {
                        class: Gif,
                    },
                },
                onReady: () => {
                    if (this.blocks_data.length)
                        this.editor.blocks.render({
                            blocks: this.blocks_data,
                        });
                },
                readOnly: this.type == "view",
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
