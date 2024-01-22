import './bootstrap';
import './../css/toastr.css'
import { createApp } from 'vue';
import app from './Layouts/app.vue';
import router from './router';
import store from './store';
import VueGoodTablePlugin from 'vue-good-table';
// import the styles
import 'vue-good-table/dist/vue-good-table.css'

const Myapp = createApp(app);
Myapp.use(router);
Myapp.use(store);
Myapp.use(VueGoodTablePlugin);
Myapp.mount('#app');
