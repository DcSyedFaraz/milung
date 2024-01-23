<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header pt-3 pb-5 text-white rounded-top-new" style="background-color: #14245c">
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span class=" mt-2 fw-bold fs-4">USERS LIST</span>
                            <span class="fw-bold "><router-link :to="{ name: 'add-user' }" class="text-white">Add
                                    new</router-link></span>
                        </div>
                    </div>

                    <div class="card-body ">


                        <!-- Table with stripped rows -->
                        <table class="table table-striped mt-5 display" id="">
                            <thead style="color: #14245c;">
                                <tr>
                                    <th>
                                        User Type
                                    </th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Buyer ID.</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in paginatedData" :key="user.id">
                                    <td class="fw-bold">{{ user.roles[0] }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.buyer_id }}</td>

                                    <td>
                                        <span
                                            :class="{ 'badge': true, 'bg-success-new': user.status === 'active', 'bg-danger': user.status !== 'active' }">
                                            {{ user.status === 'active' ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>

                                    <td>
                                        <router-link :to="'/edit-user/' + user.id" class="text-dark">
                                            <i class="bi bi-pencil"></i>
                                        </router-link>

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
import './index';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';



export default {
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
            users: [],
            currentPage: 1
        };
    },
    watch: {
        data(newVal) {
            this.users = newVal;
        }
    },
    computed: {
        totalPages() {
            return Math.ceil(this.users.length / this.perPage)
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage
            const end = start + this.perPage
            return this.users.slice(start, end)
        }
    },
    mounted() {

        // Initialize DataTables in the 'mounted' hook
        $('#dataTable').DataTable({
            responsive: true,

        });
    },
    created() {
        this.fetchUsers();
    },
    methods: {
        changePage(page) {
            this.currentPage = page
        },

        async fetchUsers() {
            try {
                const response = await axios.get('/api/users');
                this.users = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);
                var dataTable = $("#example3").DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "buttons": ["csv", "excel", "pdf", "print"],
                });
            } catch (error) {
                console.error('Error fetching users:', error);
                toastr.error('Error fetching data');
            }
        },
        async deleteUser(userId) {
            // Display SweetAlert confirmation dialog
            const result = await Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this user!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            });

            if (result.isConfirmed) {
                // User confirmed, proceed with the deletion
                try {
                    await axios.delete(`/api/userDelete/${userId}`);

                    // If successful, remove the user from the local data
                    this.users = this.users.filter(user => user.id !== userId);

                    Swal.fire({
                        icon: 'success',
                        title: 'User deleted successfully',
                    });
                } catch (error) {
                    console.error('Error deleting user:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error deleting user',
                    });
                }
            }
        },

    },
};
</script>

<style scoped>
@import url('./style.css');

.page-link {
    border: none !important;
    color: #14245c;
}
.page-item.active .page-link {
    background-color: #14245c !important;
}
thead,
th {
    border-color: #009de1 !important;
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
