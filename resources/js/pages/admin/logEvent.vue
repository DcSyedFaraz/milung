<template>
    <div>
        <div class="card  ">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center mx-3">
                    <span class=" fw-bold fs-4 text-dark">Log Event:</span>
                    <!-- <span class="fw-bold "><router-link :to="{ name: 'add-user' }" class="text-white">Add
                            new</router-link></span> -->
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
            <div class="card-body " v-else>

                <table class="table table-striped display">
                    <thead style="color: #009de1;">
                        <tr>
                            <th>Event</th>
                            <th>Description</th>
                            <th>User ID</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(entry, index) in displayedEntries" :key="index" v-if="displayedEntries.length > 0">
                            <td>{{ entry.event }}</td>
                            <td>{{ entry.description }}</td>
                            <td>{{ entry.user?.userid }}</td>
                            <td class="fst-italic text-muted">{{ formatDate(entry.created_at) }}</td>
                        </tr>
                        <tr v-else>
                            <td colspan="17">
                                <p class="text-center">No logs to display.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn btn-success" v-show="displayedEntries.length > 3" v-if="!showAll"
                    @click="showAllEntries">Show More</button>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    name: 'EventLogTable',
    data() {
        return {
            isLoading: true,
            entries: [],
            showAll: false
        };
    },
    computed: {
        displayedEntries() {
            return this.showAll ? this.entries : this.entries.slice(0, 3);
        }
    },
    methods: {

        showAllEntries() {
            this.showAll = true;
        },
        formatDate(date) {
            return moment(date).fromNow();
        }
    },
    async mounted() {
        try {

            const response = await axios.get('/api/events');
            this.entries = response.data;
            console.log(this.entries);
            this.isLoading = false;
        } catch (error) {
            console.error(error);
            this.isLoading = false;
        }
    }
};
</script>

<style scoped>
table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    border: 1px solid #ddd;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}

button {
    margin-top: 10px;
    padding: 10px 20px;
    cursor: pointer;
}
</style>
