import { createApp } from 'vue';
import Vuex from 'vuex';
import axios from 'axios'; // Add the import for Axios
import router from '@/router';

const app = createApp({});

app.use(Vuex);

const store = new Vuex.Store({
    state: {
        authToken: null,
        userRole: null,
        inquiryData: {},
        inquiry: null
    },
    mutations: {
        SET_INQUIRY_DATA(state, payload) {
            state.inquiryData = payload;
        },
        CLEAR_INQUIRY_DATA(state) {
            state.inquiryData = null;
        },
        clearInquiry(state) {
            state.inquiry = null;
        },
        setInquiry(state, inquiry) {
            state.inquiry = inquiry;
        },
        setAuthToken(state, token) {
            state.authToken = token;
            localStorage.setItem('authToken', token);
        },
        setUserRole(state, role) {
            state.userRole = role;
        },
        clearAuth(state) {
            localStorage.removeItem('authToken');
            state.authToken = null;
            state.userRole = null;
        },
    },
    actions: {
        setInquiryData({ commit }, inquiryData) {
            commit('SET_INQUIRY_DATA', inquiryData);
        },
        updateInquiry({ commit }, inquiry) {
            commit('setInquiry', inquiry);
        },
        clearInquiry({ commit }) {
            commit('clearInquiry');
        },
        CLEAR_INQUIRY_DATA({ commit }) {
            commit('CLEAR_INQUIRY_DATA');
        },
        login({ commit }, { token, role }) {
            commit('setAuthToken', token);
            commit('setUserRole', role);
        },
        logout({ commit }) {
            commit('clearAuth');

            // Clear axios default headers
            delete axios.defaults.headers.common['Authorization'];
        },
    },
    getters: {
        getInquiryData: (state) => state.inquiryData,
        inquiry: state => state.inquiry,
        isAuthenticated: state => !!state.authToken,
    }
});

// Add a request interceptor
axios.interceptors.request.use(
    (config) => {
        // const token = store.state.authToken;
        const token = localStorage.getItem('authToken');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => Promise.reject(error)
);
axios.interceptors.response.use(
    (response) => response,
    (error) => {
        const { status } = error.response;

        if (status === 401 || status === 403) {
            // Log out the user and redirect to login
            store.dispatch('logout');

            // Display a toastr error message
            toastr.error('Unauthorized access. Please log in again.', 'Error');
            router.push({ name: 'login' });

        }

        return Promise.reject(error);
    }
);
// axios.get('/api/get-permissions', {
//     headers: {
//       Authorization: `Bearer ${localStorage.getItem('token')}`
//     }).then(
//     response => {
//         window.Laravel.jsPermissions = response.data;
//         console.log(response.data);
//     }
// );
export default store; // Export the store instance
