import './bootstrap';
import './../css/toastr.css'
import { createApp } from 'vue';
import app from './Layouts/app.vue';
import router from './router';
import store from './store';
import VueGoodTablePlugin from 'vue-good-table';
import VueApexCharts from "vue3-apexcharts";
import Multiselect from 'vue-multiselect';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';



const Myapp = createApp(app)
Myapp.use(VueApexCharts);
Myapp.use(router)
Myapp.component('multiselect', Multiselect)
Myapp.use(store)
Myapp.component('VueDatePicker', VueDatePicker)
Myapp.use(VueGoodTablePlugin)
// DataTable.use(DataTablesCore);
Myapp.mount('#app');
