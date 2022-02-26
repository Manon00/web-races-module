<template>
  <div class="card">
    <h1 class="card__title" v-if="login">Connexion</h1>
    <h1 class="card__title" v-else>Inscription</h1>
    <p class="card__subtitle" v-if="login">Tu n'as pas encore de compte ? <span style="border-bottom:inset 2px blue; color:blue;" @click="login=!(login);">Créer un compte</span></p>
    <p class="card__subtitle" v-else>Tu as déjà un compte ? <span style="border-bottom:inset 2px blue; color:blue;" @click="login=!(login)">Se connecter</span></p>
    <div class="form-row">
      <input v-model="email" class="form-row__input" type="email" placeholder="Adresse mail *" maxlength="254"/>
      <p v-if="errorMail" style="color:red">Email non conforme</p>
    </div>
    <div class="form-row" v-if="!login">
      <input v-model="firstname" class="form-row__input" type="text" placeholder="Prénom *" maxlength="30"/>
      <input v-model="lastname" class="form-row__input" type="text" placeholder="Nom *" maxlength="50"/>
      <input v-model="phone_number" class="form-row__input" type="text" placeholder="Numéro de téléphone *" maxlength="12"/>
      <p v-if="errorPhone" style="color:red">Numéro de téléphone non conforme</p>

      <select v-model="type" class="form-select">
        <option value="skipper">Embarquement</option>
        <option value="crew">Equipier</option>
      </select>
    </div>
    <div class="form-row">
      <input v-model="password" class="form-row__input" type="password" placeholder="Mot de passe *" maxlength="30"/>
    </div>
    <div class="form-row" v-if="!login">
      <div class="form-row">
        <input v-model="password_confirm" class="form-row__input" type="password" placeholder="Confirmation mot de passe *" maxlength="30"/>
    </div>
    <p v-if="errorConfirmation" style="color:red">Les mots de passe que vous avez entrés ne sont pas identiques.</p>
    </div>
    <div class="form-row" v-if="login && status == 'error_login'">
      Adresse mail et/ou mot de passe invalide
    </div>
    <div class="form-row" v-if="!login && status == 'error_create'">
      Adresse mail déjà utilisée
    </div>
    <div class="form-row">
      <button @click="loginAccount()" class="btn btn-dark" :disabled="!validatedFields" v-if="login">
        <span v-if="status == 'loading'">Connexion en cours...</span>
        <span v-else>Connexion</span>
      </button>
      <button @click="createAccount()" class="btn btn-dark" :disabled="!validatedFields" v-else>
        <span v-if="status == 'loading'">Création en cours...</span>
        <span v-else>Créer mon compte</span>
      </button>
      <span v-if="status == 'fail'" style="color:darkred">Adresse email et/ou mot de passe incorrect(s)</span>
    </div>
  </div>
</template>

<script lang='ts'>
import { defineComponent } from 'vue';
import { mapState } from 'vuex'
import User from '../models/user';
export default defineComponent({
  name: 'Login', 
  data: function () {
    return {
      login: true,
      email: '',
      firstname: '',
      lastname: '',
      password: '',
      password_confirm: '',
      phone_number: '',
      type:'',
      status:'',
      errorPhone: false,
      errorMail: false,
      errorConfirmation: false,
    }
  },
  created() {
    if (this.$store.state.auth.status.loggedIn) {
      this.$router.push('/profile');
      return
    }
  },
  computed: {
    validatedFields: function () {
      if (!this.login) {
        if(this.prenom == "" || this.nom == "" || this.email == "" || this.phone == "" && this.password == "" || this.password_confirm == "")
          return false;

        var register=true;

        const regPhone = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/
        if(!(this.phone_number.match(regPhone))){
          register=false;
          this.errorPhone=true;
        }else{
          this.errorPhone=false;
        }

        const regMail = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        if(!(this.email.match(regMail))){
          this.errorMail=true;
          register=false;
        }else{
          this.errorMail=false;
        }

        if(!(this.password==this.password_confirm)){
          this.errorConfirmation=true;
          register=false;
        }else{
          this.errorConfirmation=false;
        }

        return register;
      } else {
        return (this.email != "" && this.password != "");
      }
    },
    
  },
  methods: {
    loginAccount: function () {
      const self = this;
      this.status='loading';
      this.$store.dispatch('auth/login', new User(this.email, this.password, "","","","")).then(function (response) {
        self.loginVerif();
      }, function (error) {
        self.status='';
        console.log(error);
      })
    },
    loginVerif: function (){
      if(this.$store.state.auth.status.loggedIn){
          this.$router.push('/profile');
        }else{
          this.status='fail';
        }
    },
    createAccount: function () {
      const self = this;
      this.$store.dispatch('auth/register', new User(this.email, this.password, this.firstname, this.lastname, this.phone_number, this.type))
        .then(function () {
          self.registerVerif()
      }, function (error) {
        console.log(error);
      })
    },
    registerVerif: function (){
      this.email='';
      this.firstname='';
      this.lastname='';
      this.password='';
      this.phone_number='';
      this.type='';
      this.login=true;
    },
  }
})
</script>

<style scoped>
  .form-row {
    display: flex;
    margin: 16px 0px;
    gap:16px;
    flex-wrap: wrap;
  }
  .form-row__input {
    padding:8px;
    border: none;
    border-radius: 8px;
    background:#f2f2f2;
    font-weight: 500;
    font-size: 16px;
    flex:1;
    min-width: 100px;
    color: black;
  }
  .form-row__input::placeholder {
    color:#aaaaaa;
  }
  /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>