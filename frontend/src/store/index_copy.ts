import { createStore } from 'vuex';

//const axios = require('axios');
import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://localhost/backend/'
});
// let user = localStorage.getItem('user');
// if (!user) {
//  user = {
//     userId: -1,
//     token: '',
//   }; 
// } else {
//   try {
//     user = JSON.parse(user);
//     instance.defaults.headers.common['Authorization'] = user.token;
//   } catch (ex) {
//     user = {
//       userId: -1,
//       token: '',
//     };
//   }
// }

// Create a new store instance.
const store = createStore({
  state: {
    status: '',
    user: {
      userId: -1,
      token: '',
    },
    userInfos: {
      id:-1,
      first_name:'',
      last_name:'',
      email:'',
      phone_number:'',
      role:'',
    },
  },
  mutations: {
    setStatus: function (state, status) {
      state.status = status;
    },
    logUser: function (state, user) {
      instance.defaults.headers.common['Authorization'] = user.token;
      localStorage.setItem('user', JSON.stringify(user));
      state.user = user;
    },
    userInfos: function (state, userInfos) {
      state.userInfos = userInfos;
    },
    logout: function (state) {
      state.user = {
        userId: -1,
        token: '',
      }
      localStorage.removeItem('user');
    }
  },
  actions: {
    login: ({commit}, userInfos) => {
      commit('setStatus', 'loading');
       axios.post('http://localhost/backend/offers/', userInfos)
                 .then((res) => {
                     console.log(res);
                 })
                 .catch((error) => {
                    console.error('There was an error!', error);
                 });
      /*
      return new Promise((resolve, reject) => {
        instance.post('/login', userInfos)
        .then(function (response) {
          commit('setStatus', '');
          commit('logUser', response.data);
          resolve(response);
        })
        .catch(function (error) {
          commit('setStatus', 'error_login');
          reject(error);
        });
      });
      */
    },
    createAccount: ({commit}, userInfos) => {
      commit('setStatus', 'loading');
      /*
      return new Promise((resolve, reject) => {
        commit;
        instance.post('/createAccount', userInfos)
        .then(function (response) {
          commit('setStatus', 'created');
          resolve(response);
        })
        .catch(function (error) {
          commit('setStatus', 'error_create');
          reject(error);
        });
      });
      */
    },
    getUserInfos: ({commit}) => {
      
      instance.get('/account/1')
      .then(function (response) {
        commit('userInfos', response.data);
      })
      .catch(function () {
      });
      
    }
  }
})

export default store;
