<!-- src/components/TopCategories.vue -->
<template>
    <Card class="top-categories-card">
        <template #title>
            <h3>Top Categories</h3>
        </template>
        <p class="date-info"><i class="pi pi-clock"></i> {{ currentDate }}</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        <div class="categories">
            <div class="category" v-for="category in categories" :key="category.id">
                <i :class="category.icon"></i>
                <h6>{{ category.name }}</h6>
                <p>{{ category.units }} <span>Units</span></p>
            </div>
        </div>
    </Card>
</template>

<script>
export default {
    name: 'TopCategories',
    props: {
        categories: { type: Array, default: () => [] },
    },
    computed: {
        currentDate() {
            const options = { hour: '2-digit', minute: '2-digit', day: 'numeric', month: 'long' };
            return new Date().toLocaleDateString(undefined, options);
        },
    },
};
</script>

<style scoped>
.top-categories-card {
    margin-top: 20px;
}

.date-info {
    color: gray;
    font-size: 0.9rem;
    margin-bottom: 10px;
}

.categories {
    display: flex;
    justify-content: space-between;
}

.category {
    text-align: center;
}

.category i {
    font-size: 2rem;
    color: #666;
}

.category h6 {
    margin: 5px 0;
    font-size: 1rem;
}

.category p {
    margin: 0;
    font-size: 0.9rem;
    color: gray;
}
</style>
