<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header pt-3  ">
                        <div class="mb-5">
                            <div class="row d-flex">
                                <div class="col-2">
                                    <div class="text-uppercase fw-bold fs-4 " style="color: #14245c;">date:</div>
                                    <div class="text-uppercase fw-bold fs-4 mt-2" style="color: #14245c;">bank:</div>
                                </div>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="row  ">
                                            <div class="col-3">
                                                <input type="date" name="start_date" class="form-control ">
                                            </div>
                                            <div class="col-3">
                                                <input type="date" name="end_date" class="form-control ">
                                            </div>
                                        </div>
                                        <form @submit.prevent="submitForm" enctype="multipart/form-data">
                                            <div class="row mt-2 ">

                                                <div class="col-3">
                                                    <input type="text" placeholder="Bnak Name USD" v-model="bank_name"
                                                        class="form-control ">
                                                </div>
                                                <div class="col-3">
                                                    <button class="btn btn-light text-white fw-bold"
                                                        style="background-color: #009de1; border-color: #009de1;"
                                                        type="button" @click="uploadFile">UPLOAD</button>
                                                    <button class="btn btn-milung text-white mx-2 fw-bold">Submit</button>
                                                    <input ref="fileInput" type="file" name="statement" class="d-none "
                                                        @change="handleFileUpload">
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
                        <table class="table table-striped  display ">
                            <thead style="color: white; background-color: #14245c" class="">
                                <tr class="rounded-top-new" style="">
                                    <th>
                                        Date
                                    </th>
                                    <th>Transaction Details</th>
                                    <th>Deposit</th>
                                    <th>Widrawal</th>
                                    <th>Balance</th>
                                    <th>Notice</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-for="user in dataToDisplay" :key="user.id">
                                <tr>
                                    <td>{{ user.id }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.email }}</td>

                                    <td>
                                        <span
                                            :class="{ 'badge': true, 'bg-success-new': user.status === 'active', 'bg-danger': user.status !== 'active' }">
                                            {{ user.status === 'active' ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>

                                    <td>
                                        <button @click="toggleAccordion(user)" class="btn btn-light"
                                            :class="{ 'rotate-icon': accordionOpen[user.id] }">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <!-- <router-link :to="'/edit-user/' + user.id" class="text-dark">
                                            <i class="bi bi-pencil"></i>
                                        </router-link> -->

                                        <a href="#" @click="deleteUser(user.id)" class="text-dark"><i
                                                class="bi bi-trash"></i>
                                        </a>
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
        data: {
            type: Array,
            required: true
        },
        perPage: {
            type: Number,
            default: 10
        }
    },
    data() {
        return {
            isLoading: true,
            bank_name: '',
            file: null,
            users: [],
            accordionOpen: {},
            currentPage: 1,
            searchQuery: ''
        };
    },
    watch: {
        data(newVal) {
            this.users = newVal;
        }
    },
    computed: {
        filteredUsers() {
            return this.users.filter(user => {
                return user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || user.email.toLowerCase().includes(this.searchQuery.toLowerCase());
            });
        },
        totalPages() {
            return Math.ceil(this.users.length / this.perPage)
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage
            const end = start + this.perPage
            return this.users.slice(start, end)
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
        this.fetchUsers().then(() => {
            setTimeout(() => {
                this.isLoading = false;
            }, 1000); // Delay of 1 second
        });
    },
    methods: {
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

        toggleAccordion(user) {
            this.accordionOpen[user.id] = !this.accordionOpen[user.id];
        },
        changePage(page) {
            this.currentPage = page
        },
        async fetchUsers() {
            try {
                const response = await axios.get('/api/users');
                this.users = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

            } catch (error) {
                console.error('Error fetching users:', error);
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
