<template>
    <div class="d-flex col-12 my-2">
        <div class="col-3 my-auto">
            <p class="my-auto fs-7">{{ label }}:</p>
        </div>
        <div class="col-9">
            <div class="col-12">
                {{ fileNames }}
            </div>
            <div class="col-12">
                <a
                    :href="'/storage/' + fileData.filepath"
                    :download="fileData.filename"
                    download
                    @click.prevent="exportFile"
                    class="btn px-4 mx-2 btn-primary my-2"
                >
                    Export
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    emits: ["export-file", "update:files"],
    props: {
        label: { type: String, required: true },
        files: { type: Object, required: true },
        fileData: { type: Object, required: false },
    },
    data() {
        return {
            fileNames: "",
            file: {
                name: "",
            },
        };
    },
    watch: {
        fileData: {
            handler(newVal) {
                if (newVal && newVal.filename) {
                    this.fileNames = newVal.filename;
                } else {
                    this.fileNames = "";
                }
            },
            immediate: true,
        },
    },
    created() {
        // Set fileNames initially if fileData exists
        if (this.fileData && this.fileData.filename) {
            console.log("set initial file names", this.fileData.filename);
            this.fileNames = this.fileData.filename;
        }
    },
    methods: {
        exportFile() {
            console.log(this.fileData);
            this.$emit("export-file", this.file);
        },
    },
};
</script>
