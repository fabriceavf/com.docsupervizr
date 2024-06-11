<template>
    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig" @onReady="onReady"></ckeditor>
</template>


<script>

import './ckeditor';

export default {
    name: "CkeditorRender",
    data() {
        return {
            editor: ClassicEditor,
            editorData: '<p>Content of the editor.</p>',
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
            }
        };
    },
    methods: {
        onBlur(evt) {
            console.log(evt);
        },
        onReady(editor) {
            const toolbarElement = editor.ui.view.toolbar.element;
            toolbarElement.style.display = 'none';
            console.log(editor);
        },
        onFocus(evt) {
            console.log(evt);
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
    mounted() {
        console.log('voici le ckeditot compiler==>', ClassicEditor)
    }
}
</script>

<style scoped>

</style>



