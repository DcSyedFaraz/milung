// store/index.js

import { createApp } from 'vue';

import Vuex from 'vuex';
const app = createApp({})

app.use(Vuex);

export default new Vuex.Store({
    state: {
        authToken: null,
        userRole: null,
    },
    mutations: {
        setAuthToken(state, token) {
            state.authToken = token;
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
