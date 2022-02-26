// import Vue from 'vue';
// import Vuex from 'vuex';
import { createStore } from 'vuex';
import { auth } from './auth_modul';

// Vue.use(Vuex);

// export default new Vuex.Store({
const store = createStore({
  modules: {
    auth
  }
});

export default store;
