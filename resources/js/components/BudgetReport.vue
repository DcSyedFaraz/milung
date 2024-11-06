<!-- src/components/BudgetReport.vue -->
<template>
    <Card class="budget-report-card">
        <template #title>
            <h3>Budget Report <a href="#" class="see-all">See All</a></h3>
        </template>
        <div class="report-items">
            <div class="post-item" v-for="item in budgetItems" :key="item.id">
                <img :src="item.image" alt="" class="report-image" />
                <div class="report-details">
                    <h4><a :href="item.link">{{ item.title }}</a></h4>
                    <p>{{ item.time }}</p>
                </div>
            </div>
        </div>
    </Card>
</template>

<script>
export default {
    name: 'BudgetReport',
    props: {
        budgetItems: { type: Array, default: () => [] },
    },
};
</script>

<style scoped>
.budget-report-card {
    margin-top: 20px;
}

.see-all {
    float: right;
    font-size: 0.9rem;
    text-decoration: none;
    color: #2196F3;
}

.see-all:hover {
    text-decoration: underline;
}

.report-items {
    margin-top: 10px;
}

.post-item {
    display: flex;
    margin-bottom: 10px;
}

.report-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    margin-right: 10px;
    border-radius: 5px;
}

.report-details h4 {
    margin: 0;
    font-size: 1rem;
}

.report-details p {
    margin: 0;
    font-size: 0.8rem;
    color: gray;
}
</style>
