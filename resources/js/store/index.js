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
    },
    mutations: {
        setAuthToken(state, token) {
            state.authToken = token;
            localStorage.setItem('authToken', token);
        },
        setUserRole(state, role) {
            state.userRole = role;
        },
        clearAuth(state) {
            state.authToken = null;
            state.userRole = null;
        },
    },
    actions: {
        login({ commit }, { token, role }) {
            commit('setAuthToken', token);
            commit('setUserRole', role);
        },
        logout({ commit }) {
            commit('clearAuth');
        },
    },
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

export default store; // Export the store instance
