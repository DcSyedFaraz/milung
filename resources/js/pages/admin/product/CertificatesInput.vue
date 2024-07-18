<template>
    <div>
        <div v-for="(certificate, index) in certificates" :key="index" class="row mb-3">
            <div class="col-3 mt-2">
                <input type="text" v-model="certificate.label" placeholder="Enter label" class="form-control" @input="emitCertificates"/>
            </div>
            <div class="col-5 mt-2">
                <input type="text" :name="`certificate_${index}`" disabled v-model="certificate.fileName"
                    class="form-control w-full">
            </div>
            <div class="col-4 px-0 ">
                <button type="button" class="btn-sm btn btn-light rotate-icon" @click="triggerFileInput(index)">
                    <i class="bi bi-arrow-up-right-square fs-2 text-success"></i>
                </button>
                <input ref="fileInput" type="file" style="display: none" @change="onFileChange($event, index)">
                <button v-if="certificate.filePath && isEditing" type="button" class="btn-sm btn btn-light" @click="downloadFile(index)">
                    <i class="bi bi-arrow-up-right-square fs-2 text-primary"></i>
                </button>
                <button @click="removeCertificate(index)" type="button" class="btn btn-danger btn-sm">Remove</button>
            </div>
        </div>
        <button @click="addCertificate" type="button" class="btn btn-primary my-3">Add Certificate</button>
    </div>
</template>

<script>
export default {
    props: {
        initialCertificates: {
            type: Array,
            default: () => []
        },
        isEditing: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            certificates: [...this.initialCertificates].map(cert => ({
                ...cert,
                file: null, // Ensure file is reset for new uploads
                fileName: cert.file_name || '', // Use existing file name if available
                filePath: cert.file_path || '' // Use existing file path if available
            })),
        };
    },
    methods: {
        triggerFileInput(index) {
            this.$refs.fileInput[index].click();
        },
        addCertificate() {
            this.certificates.push({ label: '', file: null });
        },
        removeCertificate(index) {
            this.certificates.splice(index, 1);
            this.emitCertificates();
        },
        emitCertificates() {
            console.log('ss');
            this.$emit('update-certificates', this.certificates);
        },
        onFileChange(event, index) {
            const file = event.target.files[0];
            this.certificates[index].file = file;
            this.certificates[index].fileName = file.name; // Update fileName property
            this.emitCertificates();
        },
        downloadFile(index) {
            // Logic to handle file download
            const url = `/storage/${this.certificates[index].filePath}`;
            console.log(url);
            if (url) {
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', '');
                document.body.appendChild(link);
                link.download = this.certificates[index].file_name;
                link.click();

                document.body.removeChild(link);
            }
        },
    },
};
</script>

<style>
.certificate-input-group {
    margin-bottom: 10px;
}
</style>
