<template>
    <div class="d-flex col-12 my-2">
        <div class="col-3 my-auto">
            <p class="my-auto fs-7">{{ label }}:</p>
        </div>
        <div class="col-9">
            <div class="col-12">
                <input type="text" class="form-control" :value="fileName" readonly>
            </div>
            <div class="col-12">
                <button type="button" class="btn px-4 btn-milung" @click="importFile">
                    Import
                </button>
                <button type="button" class="btn px-4 mx-2 btn-primary my-2" v-if="fileData && fileData.filename"
                    @click="exportFile">
                    Export
                </button>
                <input ref="fileInput" type="file" class="form-control d-none" @change="handleFileChange">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    emits: ['exportFile', 'updateFiles'],
    props: {
        label: { type: String, required: true },
        files: { type: Object, required: false, default: () => ({}) },
        fileData: { type: Object, required: false, default: () => ({}) },
    },
    data() {
        return {
            file: null,
            fileName: '',
        };
    },
    watch: {
        fileData: {
            handler(newVal) {
                this.fileName = newVal?.filename || '';
            },
            immediate: true,
        },
    },
    methods: {
        importFile() {
            this.$refs.fileInput.click();
        },
        handleFileChange(event) {
            const file = event.target.files[0];
            this.file = file;
            this.fileName = file.name;
            this.$emit('updateFiles', { file, fileName: this.fileName, label: this.label });
        },
        exportFile() {
            const fileUrl = `/storage/${this.fileData.filepath}`; // Replace with your file URL
            const fileName = this.fileData.filename;
            const a = document.createElement('a');
            a.href = fileUrl;
            a.download = fileName;
            a.click();
        },
    },
};
</script>
