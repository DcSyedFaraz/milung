import './bootstrap';
import { createApp } from 'vue';
import app from './Layouts/app.vue';
import router from './router';
import store from './store';

const Myapp = createApp(app);
Myapp.use(router);
Myapp.use(store);
Myapp.mount('#app');
