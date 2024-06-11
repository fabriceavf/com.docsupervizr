<template>

    <div>
        <ckeditor v-model="editorData" :config="editorConfig" :editor="editor" @ready="onReady"></ckeditor>
    </div>

</template>


<script>
import './ckeditor';

export default {
    name: "CkeditorInput",
    props: {
        disable: {
            default: false,
            type: Boolean
        },
        donnes: {
            type: String
        }
    },
    data() {
        return {
            editor: ClassicEditor,
            editorData: '',
            editorConfig: {
                codeBlock: {
                    languages: [
                        {language: 'css', label: 'CSS'},
                        {language: 'html', label: 'HTML'},
                        {language: 'javascript', label: 'JavaScript'},
                        {language: 'php', label: 'PHP'}
                    ]
                },
                image: {
                    resizeUnit: 'px',
                    toolbar: [
                        'imageStyle:inline',
                        'imageStyle:wrapText',
                        'imageStyle:breakText',
                        '|',
                        'toggleImageCaption',
                        'imageTextAlternative'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                },
                // The configuration of the editor.
            },
            editorApi: null
        };
    },
    methods: {
        onReady(editor) {
            this.editorApi = editor
            if (this.disable) {

                editor.enableReadOnlyMode(editor.id)
                const toolbarElement = editor.ui.view.toolbar.element;
                toolbarElement.style.display = 'none';
            }
            editor.setData(this.donnes)
            console.log()


            // console.log('editor==>',editor);
        },
        onBlur(evt) {
            console.log(evt);
        },
        verrouiler() {
            this.editorApi.disableReadOnlyMode(this.editorApi.id)
            const toolbarElement = this.editorApi.ui.view.toolbar.element;
            toolbarElement.style.display = 'none';
            console.log('Focus editor==>', this.editorApi);
        },
        onFocus() {
            // this.editorApi.disableReadOnlyMode(this.editorApi.id)
            // const toolbarElement = this.editorApi.ui.view.toolbar.element;
            // toolbarElement.style.display = 'flex';
            // console.log('Focus editor==>', this.editorApi);
        },
        onContentDom(evt) {
            console.log(evt);
        },
        onDialogDefinition(evt) {
            console.log(evt);
        },
        onFileUploadRequest(evt) {
            console.log(evt);
        },
        onFileUploadResponse(evt) {
            console.log(evt);
        }
    },
    created() {

        if (this.donnes == "" || this.donnes == null) {
            this.editorData = "<p></p>";
        } else {
            this.editorData = this.donnes
        }
    },
    watch: {
        'editorData': {
            handler: function (after, before) {
                this.$emit('changeData', after)
            },
            deep: true
        },
    },
}
</script>

<style scoped>
.ck-content {
    border-radius: 5px
}

</style>



