<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header pt-3  ">
                        <div class="mb-5">
                            <div class="row d-flex">
                                <div class="col-2">
                                    <div class="text-uppercase fw-bold fs-4 mt-2" style="color: #14245c;">date:</div>
                                    <div class="text-uppercase fw-bold fs-4 mt-4" style="color: #14245c;">bank:</div>
                                </div>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="row  ">
                                            <div class="col-3">
                                                <input type="date" v-model="startDate" class="form-control">
                                            </div>
                                            <div class="col-3">
                                                <input type="date" v-model="endDate" class="form-control">
                                            </div>
                                            <!-- <div class="col-3 my-auto">
                                                <button class="btn btn-milung"
                                                    @click="filterTransactions">Submit</button>
                                            </div> -->
                                        </div>
                                        <form @submit.prevent="submitForm" enctype="multipart/form-data">
                                            <div class="row mt-2 ">

                                                <div class="col-3 my-auto">
                                                    <input type="text" placeholder="Bnak Name USD" v-model="bank_name"
                                                        class="form-control ">
                                                </div>
                                                <div class="col-3">
                                                    <button class="btn btn-light text-white fw-bold"
                                                        style="background-color: #009de1; border-color: #009de1;"
                                                        type="button" @click="uploadFile">UPLOAD</button>
                                                    <button
                                                        class="btn btn-milung text-white mx-2 fw-bold">Submit</button>
                                                    <input ref="fileInput" accept=".xlsx , .csv" type="file"
                                                        name="statement" class="d-none " @change="handleFileUpload">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span>
                                <span class=" mt-2 fw-bold fs-4 " style="color: #14245c;">BANK STATEMENT:</span>
                            </span>

                            <div class="col-4 d-flex">
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i style="color: #41b400;"
                                                class="bx bx-filter-alt fw-bold fs-4"></i></span>
                                        <input type="text" name="search" class="form-control " v-model="searchQuery"
                                            ref="search" placeholder="Write here to filter..." />
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- // Loader -->
                    <div class="card-body rounded-top" v-if="isLoading">

                        <div class="d-flex justify-content-center">
                            <div class="spinner-border text-warning" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <!-- // Loader -->
                    <div class="card-body rounded-top" v-else>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped text-center display ">
                            <thead style="color: white; background-color: #14245c" class="">
                                <tr>
                                    <th @click="sortTable('date')">Date
                                        <i :class="getSortIcon('date')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('transaction_details')">Transaction Details
                                        <i :class="getSortIcon('transaction_details')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('deposit')">Deposit
                                        <i :class="getSortIcon('deposit')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('withdrawal')">Withdrawal
                                        <i :class="getSortIcon('withdrawal')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('balance')">Balance
                                        <i :class="getSortIcon('balance')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('notice')">Notice
                                        <i :class="getSortIcon('notice')" class="ms-1"></i>
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="transaction in dataToDisplay" :key="transaction.id"
                                    v-if="dataToDisplay.length > 0">
                                    <td>{{ transaction.date }}</td>
                                    <td>{{ transaction.transaction_details }}</td>
                                    <td>
                                        <span v-if="!transaction.deposit" class="text-muted fst-italic">N/A</span>
                                        <span v-else class="fw-bold">{{ transaction.deposit }}</span>
                                    </td>
                                    <td>
                                        <span v-if="!transaction.withdrawal" class="text-muted fst-italic">N/A</span>
                                        <span v-else class="fw-bold">{{ transaction.withdrawal }}</span>
                                    </td>
                                    <td class="fw-bold">{{ transaction.balance }}</td>
                                    <td>{{ transaction.notice }}</td>

                                    <td>
                                        <input type="file" :ref="setFileInputRef(transaction.id)"
                                            @change="onFileChange($event, transaction.id)" style="display: none;" />

                                        <button v-if="!transaction.remittance_slip" class="btn btn-info btn-sm mx-2"
                                            @click="triggerFileInput(transaction.id)">
                                            Upload
                                        </button>
                                        <a v-else :href="'/storage/' + transaction.remittance_slip" download
                                            class="btn px-4 mx-2 btn-outline-primary">
                                            <i class="bi bi-file-earmark-text fw-bold"></i>
                                        </a>
                                        <button @click.prevent="deleteUser(transaction.id)"
                                            class="btn btn-danger btn-sm mx-2"><i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td colspan="17">
                                        <p class="text-center">
                                            No statement to display.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination d-flex justify-content-center">
                                <li class="page-item me-auto fw-bold" :class="{ disabled: currentPage === 1 }">
                                    <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)"><i
                                            class="bi bi-arrow-left"></i> Previous</a>
                                </li>
                                <li class="page-item" v-for="page in totalPages" :key="page"
                                    :class="{ active: page === currentPage }">
                                    <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                                </li>
                                <li class="page-item ms-auto fw-bold" :class="{ disabled: currentPage === totalPages }">
                                    <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Next <i
                                            class="bi bi-arrow-right"></i> </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>

<script>
import './../index';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

export default {
    name: "Transaction",
    props: {

        perPage: {
            type: Number,
            default: 10
        }
    },
    data() {
        return {
            isLoading: true,
            bank_name: '',
            sortKey: '',
            sortAsc: true,
            startDate: '',
            endDate: '',
            file: null,
            transactions: [],
            accordionOpen: {},
            currentPage: 1,
            searchQuery: '',
            selectedFiles: {},
            userIdForUpload: null,
            fileInputs: {},

        };
    },
    watch: {
        data(newVal) {
            this.transactions = newVal;
        }
    },
    computed: {
        filteredUsers() {
            return this.transactions.filter(transaction => {
                return (
                    transaction.date.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    transaction.transaction_details.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (transaction.deposit && transaction.deposit.toString().includes(this.searchQuery)) ||
                    (transaction.withdrawal && transaction.withdrawal.toString().includes(this.searchQuery)) ||
                    transaction.balance.toString().includes(this.searchQuery) ||
                    transaction.notice.toLowerCase().includes(this.searchQuery)
                );
            });
        },
        totalPages() {
            return Math.ceil(this.transactions.length / this.perPage)
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage
            const end = start + this.perPage
            return this.transactions.slice(start, end)
        },
        dataToDisplay() {
            if (this.searchQuery) {
                return this.filteredUsers;
            } else {
                return this.paginatedData;
            }
        }
    },
    mounted() {

    },
    created() {
        this.fetchTransactions().then(() => {
            setTimeout(() => {
                this.isLoading = false;
            }, 1000); // Delay of 1 second
        });
    },
    methods: {
        sortTable(key) {
            if (this.sortKey === key) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortKey = key;
                this.sortAsc = true;
            }
            this.transactions.sort((a, b) => {
                const getValue = (obj, path) => path.split('.').reduce((acc, part) => acc && acc[part], obj);
                const aValue = getValue(a, key);
                const bValue = getValue(b, key);

                let result = 0;
                if (aValue < bValue) {
                    result = -1;
                } else if (aValue > bValue) {
                    result = 1;
                }
                return this.sortAsc ? result : -result;
            });
        },
        getSortIcon(key) {
            if (this.sortKey === key) {
                return this.sortAsc ? 'fas fa-sort-up' : 'fas fa-sort-down';
            }
            return 'fas fa-sort';
        },
        async filterTransactions() {
            if (!this.startDate || !this.endDate) {
                Swal.fire(
                    'Validation Error',
                    'Please select both start and end dates.',
                    'warning'
                );
                return;
            }

            if (new Date(this.startDate) > new Date(this.endDate)) {
                Swal.fire(
                    'Validation Error',
                    'Start date cannot be later than end date.',
                    'warning'
                );
                return;
            }

            try {
                const response = await axios.get('/api/transactions', {
                    params: {
                        start_date: this.startDate,
                        end_date: this.endDate
                    }
                });
                this.transactions = response.data;
            } catch (error) {
                console.error('Error fetching transactions:', error);
                Swal.fire(
                    'Error',
                    'There was an error fetching the transactions.',
                    'error'
                );
            }
        },
        async deleteUser(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await axios.delete(`/api/transactions/${userId}`);
                        this.fetchTransactions();
                        Swal.fire(
                            'Deleted!',
                            'The transaction has been deleted.',
                            'success'
                        );
                    } catch (error) {
                        console.error('There was an error deleting the transaction:', error);
                        Swal.fire(
                            'Error!',
                            'There was an error deleting the transaction.',
                            'error'
                        );
                    }
                }
            });
        },
        setFileInputRef(userId) {
            return (el) => {
                if (el) {
                    this.fileInputs[userId] = el;
                }
            };
        },
        triggerFileInput(userId) {
            this.fileInputs[userId].click();
        },
        onFileChange(event, userId) {
            this.selectedFiles[userId] = event.target.files[0];
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to upload this file?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, upload it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.uploadFiles(userId);
                }
            });
        },
        async uploadFiles(userId) {
            if (this.selectedFiles[userId]) {
                let formData = new FormData();
                formData.append('file', this.selectedFiles[userId]);

                try {
                    const response = await axios.post(`/api/transactions/${userId}/upload`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                    this.fetchTransactions();
                    Swal.fire(
                        'Uploaded!',
                        'Your file has been uploaded.',
                        'success'
                    );
                } catch (error) {
                    console.error('There was an error uploading the file:', error);
                    Swal.fire(
                        'Error!',
                        'There was an error uploading the file.',
                        'error'
                    );
                }
            } else {
                Swal.fire(
                    'No file selected!',
                    'Please select a file to upload.',
                    'warning'
                );
            }
        },
        uploadFile() {
            this.$refs.fileInput.click();
        },
        handleFileUpload(e) {
            this.file = e.target.files[0];
            console.log(this.file);
        },
        async submitForm() {
            const formData = new FormData();
            formData.append('bank_name', this.bank_name);
            formData.append('statement', this.file);

            try {
                const response = await axios.post('/api/statement', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                console.log(response.data);
            } catch (error) {
                console.error(error);
            }
        },

        changePage(page) {
            this.currentPage = page
        },
        async fetchTransactions() {
            try {
                const response = await axios.get('/api/statementget');
                this.transactions = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

            } catch (error) {
                console.error('Error fetching transactions:', error);
                toastr.error('Error fetching data');
            }
        },

    },
};
</script>

<style scoped>
@import url('./../style.css');

.rotate-icon {
    transform: rotate(180deg);
}

.table {
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 20px;

    border-radius: 10px 10px 0 0;
    overflow: hidden;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s !important;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.page-link {
    border: none !important;
    color: #14245c;
}

.page-item.active .page-link,
.btn-milung {
    background-color: #14245c !important;
    color: white;
}

.rounded-top-new {
    border-top-left-radius: 2.25rem !important;
    border-top-right-radius: 2.25rem !important;
}

.rounded-bottom-new {
    border-bottom-left-radius: 2.25rem !important;
    border-bottom-right-radius: 2.25rem !important;
}
</style>
