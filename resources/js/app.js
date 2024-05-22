import './bootstrap';
import './../css/toastr.css'
import { createApp } from 'vue';
import app from './Layouts/app.vue';
import router from './router';
import store from './store';
import VueGoodTablePlugin from 'vue-good-table';
import VueApexCharts from "vue3-apexcharts";
import Multiselect from 'vue-multiselect';
// import 'vue-multiselect/dist/vue-multiselect.min.css';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
// PrimeVue
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/aura-light-green/theme.css'
import Notifications from './pages/notifications.vue';



import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'



const Myapp = createApp(app)
Myapp.use(VueApexCharts);
Myapp.use(router)
Myapp.component('multiselect', Multiselect)
Myapp.use(store)
Myapp.use(PrimeVue)
Myapp.component('VueDatePicker', VueDatePicker)
Myapp.use(VueGoodTablePlugin)
Myapp.use(LaravelPermissionToVueJS)
Myapp.component('notifications', Notifications);
Myapp.mount('#app');


