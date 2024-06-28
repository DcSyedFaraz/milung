<template>
    <div class="d-flex my-2">
        <div class="col-3 mt-3">{{ label }}</div>
        <div class="col-5 mt-2">
            <input type="text" :name="inputName" disabled v-model="selectedFileName" class="form-control w-full">
        </div>
        <div class="col-4">
            <button type="button" class="btn-sm btn btn-light rotate-icon" @click="uploadFile"><i
                    class="bi bi-arrow-up-right-square fs-2 text-success"></i></button>
            <input ref="fileInput" type="file" style="display: none" @change="handleFileChange">
            <button v-if="initialFile.name" type="button" class="btn-sm btn btn-light" @click="downloadFile"><i
                    class="bi bi-arrow-up-right-square fs-2 text-primary"></i></button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        label: String,
        inputName: String,
        initialFile: {
            type: Object,
            default: () => ({ path: null, name: null })
        }
    },
    data() {
        return {
            selectedFileName: this.initialFile.name || '',
        };
    },
    methods: {
        downloadFile() {
            const fileUrl = `/storage/${this.initialFile.path}`; // Replace with your file URL
            const fileName = this.initialFile.name;
            const a = document.createElement('a');
            a.href = fileUrl;
            a.download = fileName;
            a.click();
        },
        uploadFile() {
            this.$refs.fileInput.click();
        },
        handleFileChange() {
            const fileInput = this.$refs.fileInput;
            const selectedFile = fileInput.files.length > 0 ? fileInput.files[0] : null;

            if (selectedFile) {
                this.selectedFileName = selectedFile.name;
            } else {
                // Handle the case when the file input is cleared
                this.selectedFileName = '';
            }

            this.$emit('file-uploaded', this.inputName, selectedFile);
        },
    },
};
</script>

<style scoped>
.rotate-icon {
    transform: rotate(180deg);
}
</style>
