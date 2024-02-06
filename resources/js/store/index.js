import { createApp } from 'vue';
import Vuex from 'vuex';
import axios from 'axios'; // Add the import for Axios

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
    const token = store.state.authToken;
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

export default store; // Export the store instance
