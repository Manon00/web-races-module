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
         <div class="nav-item">
          <router-link to="/login" class="nav-link">Connexion</router-link>
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
