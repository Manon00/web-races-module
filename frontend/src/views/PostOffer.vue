<template>
<!-- eslint-disable max-len -->
  <div class="card">
    <h1 class="card__title" v-if="login">Poster une offre</h1>

    <div v-if="!logged" class="form-row"> 
      <input v-model="prenom" class="form-row__input" type="text" placeholder="Prénom" maxlength="30"/>
      <input v-model="nom" class="form-row__input" type="text" placeholder="Nom" maxlength="50"/>
      <input v-model="phone_number" class="form-row__input" type="text" placeholder="Numéro de téléphone" maxlength="12"/>
      <p v-if="errorPhone" style="color:red">Numéro de téléphone non conforme</p>
      <input v-model="email" class="form-row__input" type="email" placeholder="Adresse mail" maxlength="254"/>
      <p v-if="errorMail" style="color:red">Email non conforme</p>
    </div>

    <div class="form-row">
      <span>Type de l'offre : </span>
        <select v-model="type" class="form-select">
          <option value="skipper">Embarquement</option>
          <option value="crew">Equipier</option>
        </select>
    </div>

    <div class="form-row">
      <textarea v-model="content" class="form-row__input input_content" type="textarea" placeholder="Contenu" maxlength= "2500" rows="10"/>
      <span>{{content.length}}/2500</span>
    </div>

    <div class="form-row">
      <button @click="annuler()" class="btn btn-dark">
        <span>Annuler</span>
      </button>
      <button @click="postOffer()" class="btn btn-dark" :disabled="!validatedFields">
        <span>Poster</span>
      </button>
      <span v-if="status == 'fail'" style="color:darkred">Erreur</span>
    </div>
  </div>
</template>

<script lang='ts'>
import { defineComponent } from 'vue';
import { mapState } from 'vuex'
import axios from 'axios';
import User from '../models/user';
export default defineComponent({
  name: 'PostOffer', 
  data: function () {
    return {
      email: '',
      prenom: '',
      nom: '',
      phone_number : '',
      type: '',
      content:'',
      errorPhone: false,
      errorMail: false,
    }
  },
  created() {
    if (this.$store.state.auth.status.loggedIn) {
      axios.get('http://localhost/backend/accounts/'+this.$store.state.auth.user.id)
                 .then((res) => {
                     //Perform Success Action
                     this.email=res.data.email;
                     this.prenom=res.data.first_name;
                     this.nom=res.data.last_name;
                     this.phone_number=res.data.phone_number;
                 })
                 .catch((error) => {
                     this.errorMessage = error;
                    console.error('There was an error!', error);
                 })  
      //getAccount
      //remplir champs
      return
    }
  },
  computed: {
   validatedFields: function () {
        if(this.prenom == "" || this.nom == "")
          return false;

        var post=true;

        const regPhone = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/
        if(!(this.phone_number.match(regPhone))){
          post=false;
          if(this.phone_number!="")
            this.errorPhone=true;
        }else{
          this.errorPhone=false;
        }

        const regMail = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        if(!(this.email.match(regMail))){
          if(this.email!="")
            this.errorMail=true;
          post=false;
        }else{
          this.errorMail=false;
        }

        if(this.type == "" || this.content == "")
          post=false;

        return post;
    },
    logged: function(){
      return this.$store.state.auth.status.loggedIn
    }
    
  },
  methods: {
    annuler : function() {
      this.$router.push('/offers');
    },
    postOffer: function () {
      if (!(this.$store.state.auth.status.loggedIn)){
        const formData = new FormData();
        formData.append('email',this.email);
        formData.append('first_name', this.prenom);
        formData.append('last_name', this.nom);
        formData.append('phone_number', this.phone_number);
        axios.post('http://localhost/backend/accounts/', formData)
                 .then((res) => {
                   this.post(res.data);
                 })
                 .catch((error) => {
                     this.errorMessage = error;
                    console.error('There was an error!', error);
                 })  
      }else{
        this.post(this.$store.state.auth.user.id);
      }

      
    },
    post: function(id) {
      const formData = new FormData();
      formData.append('writer_id',id);
      formData.append('content', this.content);
      formData.append('type', this.type);
       axios.post('http://localhost/backend/offers/', formData)
                 .then((res) => {
                   alert("Votre offre a bien été enregistrée")
                   this.$router.push("/offers");
                 })
                 .catch((error) => {
                     this.errorMessage = error;
                    console.error('There was an error!', error);
                 })  
    }
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
    margin : 10px;
    padding:8px;
    border: none;
    border-radius: 8px;
    background:#f2f2f2;
    font-weight: 500;
    font-size: 16px;
    flex:1;
    min-width: 200px;
    color: black;
  }

  .form-select{
    margin : 10px;
    border-radius: 8px;
    flex:1;
    min-width: 50%;
    width : 50%; 
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