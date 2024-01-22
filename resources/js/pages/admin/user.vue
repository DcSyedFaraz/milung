<template>
    <!-- <div class="pagetitle">
        <h1>Data Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data</li>
            </ol>
        </nav>
    </div> -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header pt-3 pb-5 text-white rounded-top-new" style="background-color: #14245c">
                        <div class="d-flex justify-content-between align-items-center mx-3">
                          <span class=" mt-2 fw-bold fs-4">USERS LIST</span>
                          <span class="fw-bold "><router-link :to="{ name: 'add-user'}" class="text-white">Add new</router-link></span>
                        </div>
                      </div>

                    <div class="card-body ">


                        <!-- Table with stripped rows -->
                        <table ref="myTable" class="table table-striped mt-5 " id="myTable">
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
                                <tr v-for="user in users" :key="user.id">
                                    <td class="fw-bold">{{ user.roles[0] }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.buyer_id }}</td>

                                    <td>
                                        <span :class="{'badge': true, 'bg-success-new': user.status === 'active', 'bg-danger': user.status !== 'active'}">
                                            {{ user.status === 'active' ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>

                                    <td><router-link :to="'/edit-user/' + user.id"><i class="bi bi-pencil"></i></router-link> <a href="#" @click="some"><i
                                                class="bi bi-trash"></i></a></td>
                                </tr>

                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
</template>

<script>
import './index';


export default {
    data() {
        return {
            users: [],
        };
    },
    created() {
        this.fetchUsers();
    },
    methods: {
        async fetchUsers() {
            try {
                const response = await axios.get('/api/users');
                this.users = response.data;
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
@import url('./style.css');

thead,
th {
    border-color: #009de1 !important;
}
.rounded-top-new {
    border-top-left-radius: 2.25rem!important;
    border-top-right-radius: 2.25rem!important;
}
.rounded-bottom-new {
    border-bottom-left-radius: 2.25rem!important;
    border-bottom-right-radius: 2.25rem!important;
}
</style>
