<template>
  <div>
    <nav id="nav" class="navbar navbar-light bg-light px-3">
      <span class="navbar-brand">Groupement des Croiseurs d'Iroise</span>

      <div class="nav nav-pills">
        <div class="nav-item">
          <router-link to="/" class="nav-link">Accueil</router-link>
        </div>
        <div class="nav-item">
          <router-link to="/calendar" class="nav-link">Calendrier</router-link>
        </div>
        <div class="nav-item">
          <router-link to="/offers" class="nav-link">Bourse aux équipiers</router-link>
        </div>
         <div  v-if="loggedIn" class="nav-item" title="Compte">
          <router-link to="/profile" class="nav-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
</svg></router-link>
        </div>
        <div v-if="loggedIn" class="nav-item" title="Compte" @click.prevent="logOut">
          <p class="nav-link">Deconnexion</p>
        </div>
        
      <div v-if="!loggedIn" class="navbar-nav ml-auto">
          <router-link to="/login" class="nav-link">
            Connexion
          </router-link>
      </div>
      </div>
    </nav>
    <router-view />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'App',
  computed: {
    currentUser() {
      return this.$store.state.auth.user;
    },
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    },
    showAdminBoard() {
      if (this.currentUser && this.currentUser.roles) {
        return this.currentUser.roles.includes('admin');
      }

      return false;
    }
  },
  methods: {
    logOut() {
      this.$store.dispatch('auth/logout');
      this.$router.push('/');
    }
  }
});
</script>

<style lang="less">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;

  a {
    &.router-link-exact-active {
    color: #fff;
    background-color: #0d6efd;    }
  }
}
</style>
