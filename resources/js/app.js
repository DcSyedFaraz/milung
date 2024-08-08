import './bootstrap';
import './../css/toastr.css'

import { createApp } from 'vue';
import appvue from './Layouts/app.vue';
import router from './router';
import store from './store';
import VueGoodTablePlugin from 'vue-good-table';
import VueApexCharts from "vue3-apexcharts";
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

// PrimeVue
import PrimeVue from "primevue/config";
import 'primeicons/primeicons.css';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';
import Aura from '@primevue/themes/aura';
import Select from 'primevue/select';

import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';

import DatePicker from 'primevue/datepicker';


import Notifications from './pages/notifications.vue';
import EventLogTable from './pages/admin/logEvent.vue';



import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'


const app = createApp(appvue)
app.use(VueApexCharts);
app.use(router)
app.component('multiselect', Multiselect)
app.component('Select', Select)
app.use(store)
app.component('VueDatePicker', VueDatePicker)
app.use(VueGoodTablePlugin)
app.use(LaravelPermissionToVueJS)
app.component('EventLogTable', EventLogTable);
app.component('notifications', Notifications);
app.component('InputGroup', InputGroup);
app.component('InputGroupAddon', InputGroupAddon);
app.component('DatePicker', DatePicker);

app.use(PrimeVue, {
    ripple: true,
    theme: {
        preset: Aura,
        options: {
            darkModeSelector: 'off',
        },
        colors: {
            primary: '#14245c', // apna primary color hash yaha daalein
        }
    }
});
app.use(ConfirmationService);
app.use(ToastService);
app.mount('#app');


