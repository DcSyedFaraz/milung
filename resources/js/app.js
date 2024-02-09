import './bootstrap';
import './../css/toastr.css'
import { createApp } from 'vue';
import app from './Layouts/app.vue';
import router from './router';
import store from './store';
import VueGoodTablePlugin from 'vue-good-table';
import VuePaginate from 'vue-paginate';
// import the styles
import 'vue-good-table/dist/vue-good-table.css'
// import DataTable from 'datatables.net-vue3';
// import DataTablesCore from 'datatables.net';
import 'datatables.net-select';
import 'datatables.net-responsive';
import 'jszip';
import 'pdfmake';
import 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons/js/buttons.print.mjs';
import Select2 from 'vue3-select2-component';
import $ from 'jquery';
import 'select2';


const Myapp = createApp(app)
Myapp.use(router)
Myapp.use(VuePaginate)
Myapp.use(store)
Myapp.use(VueGoodTablePlugin)
// DataTable.use(DataTablesCore);
Myapp.mount('#app');
