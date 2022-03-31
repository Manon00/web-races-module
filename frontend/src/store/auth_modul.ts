import router from '@/router';
import { isMemberExpressionNode } from '@vue/compiler-core';
import AuthService from '../services/auth_service';

let user = (JSON.parse(localStorage.getItem("user")|| '')).toString();

if(user){
  if(user.expireAt < new Date().getTime()/1000){
    localStorage.removeItem("user");
    router.push('/');
  }
}
if(!localStorage.getItem("user")== null){
  user = (JSON.parse(localStorage.getItem("user")|| '')).toString();
}


const initialState = user ? 
                      user.id != -1 ? 
                        { status: { loggedIn: true }, user} 
                        : 
                        { status: { loggedIn: false }, user :null }
                      : 
                      { status: { loggedIn: false }, user :null };

export const auth = {
  namespaced: true,
  state: initialState,
  actions: {
    login({ commit } : any, user : any) {
      var auth = new AuthService();
      return auth.login(user).then(
        (user : any) => {
          commit('loginSuccess', user);
          return Promise.resolve(user);
        },
        (error : any) => {
          commit('loginFailure');
          return Promise.reject(error);
        }
      );
    },
    logout({ commit } : any) {
      var auth = new AuthService();
      auth.logout();
      commit('logout');
    },
    register({ commit } : any, user : any) {
      var auth = new AuthService();
      return auth.register(user).then(
        response => {
          //commit('registerSuccess');
          return Promise.resolve();
        },
        error => {
          //commit('registerFailure');
          return Promise.reject(error);
        }
      );
    }
  },
  mutations: {
    loginSuccess(state : any, user : any) {
      if(user.id!=-1){
        state.status.loggedIn = true;
      }
      state.user = user;
    },
    loginFailure(state : any) {
      state.status.loggedIn = false;
      state.user = null;
    },
    logout(state : any) {
      state.status.loggedIn = false;
      state.user = null;
    },
  },
};