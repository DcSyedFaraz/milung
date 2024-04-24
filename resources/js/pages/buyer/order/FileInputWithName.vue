<template>
    <div class="d-flex col-12 my-2">
        <div class="col-3 my-auto">
            <p class="my-auto fs-7">{{ label }}:</p>
        </div>
        <div class="col-9">
            <div class="col-12">
                <input type="text" class="form-control" :value="fileNames" readonly>
            </div>
            <div class="col-12 ">
                <button type="button" class="btn px-4 btn-milung" @click="importFile">
                    Import
                </button>
                <button type="button" class="btn px-4 mx-2 btn-primary my-2" @click="exportFile">
                    Export
                </button>
                <input ref="fileInput" type="file" class="form-control d-none" @change="updateFile">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    emits: ['export-file', 'update:files'],
    props: {
        label: { type: String, required: true, },
        files: { type: Object, required: true, },
        fileData: { type: Object, required: false, },

    },
    data() {
        return {
            fileNames: '',
            file: {
                name: ''
            },
        };
    },
    watch: {
        fileData: {
            handler(newVal) {
                if (newVal && newVal.filename) {
                    this.fileNames = newVal.filename;
                } else {
                    this.fileNames = '';
                }
            },
            immediate: true
        }
    },
    created() {
        // Set fileNames initially if fileData exists
        if (this.fileData && this.fileData.filename) {
            console.log('set initial file names'  , this.fileData.filename);
            this.fileNames = this.fileData.filename;
        }
    },
    methods: {
        importFile() {
            this.$refs.fileInput.click();
        },
        updateFile(event) {
            const fileInput = event.target.files[0];
            const fileName = fileInput.name;
            this.file = fileInput;
            this.fileNames = fileName;
            console.log(fileName);
            this.$emit('update:files', { file: this.file, fileName: this.fileNames, label: this.label });
        },
        exportFile() {
            this.$emit('export-file', this.file);
        },
    },
};
</script>
