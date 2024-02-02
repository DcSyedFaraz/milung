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
            <button type="button" class="btn-sm btn btn-light "><i
                    class="bi bi-arrow-up-right-square fs-2 text-primary"></i></button>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        label: String,
        inputName: String,
    },
    data() {
        return {
            selectedFileName: '',
        };
    },
    methods: {
        uploadFile() {
            this.$refs.fileInput.click();
        },
        handleFileChange() {
            const fileInput = this.$refs.fileInput;
            this.selectedFileName = fileInput.files.length > 0 ? fileInput.files[0].name : '';
            this.$emit('file-uploaded', this.inputName, this.selectedFileName);
        },
    },
};
</script>
<style scoped>

.rotate-icon {
    transform: rotate(180deg);
}
</style>
