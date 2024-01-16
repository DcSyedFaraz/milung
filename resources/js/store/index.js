// store/index.js

import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

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
  },
  actions: {
    login({ commit }, { token, role }) {
      commit('setAuthToken', token);
      commit('setUserRole', role);
    },
  },
});
