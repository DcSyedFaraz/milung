<!-- src/components/DashboardCard.vue -->
<template>
    <Card class="dashboard-card" :style="{ backgroundColor: cardColor }" @click="navigate">
        <template #title>
            <h3 class="text-white">{{ title }}</h3>
        </template>
        <div class="card-content">
            <i :class="iconClass"></i>
            <span class="count text-white">{{ count }}</span>
        </div>
    </Card>
</template>

<script>
export default {
    name: 'DashboardCard',
    props: {
        title: { type: String, required: true },
        count: { type: [Number, String], required: true },
        iconClass: { type: String, required: true },
        cardColor: { type: String, default: '#000' },
        navigateTo: { type: String, required: true },
    },
    methods: {
        navigate() {
            this.$router.push({ name: this.navigateTo });
        },
    },
};
</script>

<style scoped>
.dashboard-card {
    cursor: pointer;
    color: white;
    padding: 20px;
    border-radius: 8px;
    transition: transform 0.2s;
    height: 100%;
}

.dashboard-card:hover {
    transform: scale(1.05);
}

.card-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 10px;
}

.card-content i {
    font-size: 2rem;
}

.count {
    font-size: 1.5rem;
    font-weight: bold;
}
</style>
