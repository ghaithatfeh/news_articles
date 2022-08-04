<template>
    <div class="container">
        <div id="editorjs"></div>
    </div>
    <div class="d-flex">
        <button class="btn btn-success mx-auto" @click="save">Save Article</button>
    </div>

    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button>

    <div id="exampleModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="url" type="text">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="save" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div> -->

    <div id="exampleModal" class="modal" tabindex="-1" aria-modal="true" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5><button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"><input id="asdurl" type="text"></div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button><button id="save-image" type="button"
                        class="btn btn-primary">Save changes</button></div>
            </div>
        </div>
    </div>
</template>

<script>
import EditorJS from '@editorjs/editorjs';

class Gif {
    static get toolbox() {
        return {
            title: 'GIF',
            icon: '<svg width="17" height="15" viewBox="0 0 336 276" xmlns="http://www.w3.org/2000/svg"><path d="M291 150V79c0-19-15-34-34-34H79c-19 0-34 15-34 34v42l67-44 81 72 56-29 42 30zm0 52l-43-30-56 30-81-67-66 39v23c0 19 15 34 34 34h178c17 0 31-13 34-29zM79 0h178c44 0 79 35 79 79v118c0 44-35 79-79 79H79c-44 0-79-35-79-79V79C0 35 35 0 79 0z"/></svg>'
        };
    }

    constructor({ data }) {
        this.data = data;
    }

    render() {
        document.querySelector('#exampleModal').style.display = 'block'
        const img = document.createElement('img')
        document.querySelector('#save-image').addEventListener('click', () => {
            img.src = document.querySelector('#asdurl').value
            document.querySelector('#exampleModal').style.display = 'none'
        })
        return img;
    }

    _createImage(url) {
        return
    }

    save(blockContent) {
        return
    }
}

export default {
    data() {
        return {
            editor: new EditorJS({
                tools: {
                    gif: Gif
                }
            })
        }
    },
    methods: {
        save() {
            this.editor.save().then((outputData) => {
                console.log('Article data: ', outputData)
            }).catch((error) => {
                console.log('Saving failed: ', error)
            });
        }
    }
}
</script>

    <style>
    .ce-paragraph.cdx-block {
        background-color: #eee;
        padding: 5px 10px;
    }
    
    .ce-block:last-child .ce-paragraph.cdx-block {
        border-radius: 0 0 10px 10px;
    }
    
    .ce-block:first-child .ce-paragraph.cdx-block {
        border-radius: 10px 10px 0 0;
    }
    
    .ce-block:only-child .ce-paragraph.cdx-block {
        border-radius: 10px;
    }
    </style>
