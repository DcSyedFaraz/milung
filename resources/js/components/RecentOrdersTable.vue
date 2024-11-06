<!-- src/components/RecentOrdersTable.vue -->
<template>
    <table class="table table-active ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Send Out Date</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="order in orders" v-if="orders">
                <th scope="row"> <router-link :to="{ name: 'order_edit', params: { id: order.id } }" class="">
                        {{ order.id }}
                    </router-link></th>
                <td>{{ order.productname }}</td>
                <td>
                    {{ order.sendoutdate }}
                </td>
                <td>{{ order.status }}</td>

            </tr>
            <tr v-else>
                <td colspan="5" class="text-muted fst-italic text-center">

                    no orders avaialable
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>

export default {
    name: 'RecentOrdersTable',
    props: {
        orders: {
            type: Array,
            default: () => [],
        },
    },
};
</script>

<style scoped>
.recent-orders-card {
    margin-top: 20px;
}

.no-data {
    text-align: center;
    color: gray;
    padding: 20px;
}
</style>
