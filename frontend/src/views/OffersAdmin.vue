<template>
  <!-- eslint-disable max-len -->
  <div class="container">

    <h1>Offres :</h1>
    <span> Dates : </span>
    <select v-model="date" v-on:change="handle_filter">
      <option value="desc">Descendant</option>
      <option value="asc">Ascendant</option>
    </select>

    <span> Type d'offre : </span>
    <select v-model="type" v-on:change="handle_filter">
      <option value="default">Tous</option>
      <option value="crew">Equipier</option>
      <option value="skipper">Embarquement</option>
    </select>

    <span> Status des offres : </span>
    <select v-model="status" v-on:change="handle_filter">
      <option value="default">Tous</option>
      <option value="validate">Validées</option>
      <option value="to_validate">A valider</option>
      <option value="obsolete">Obsolètes</option>
    </select>

    <div
      v-for="item in offers"
      :key="item.offer_id"
      class="card"
    >
      <div class="card-body">
        <p class="card-title">
          {{ item.first_name }} {{ item.last_name }}  ( {{ item.email }} )
        </p>
        <p class="offer_info">
          {{ this.getDateOffer(item.date_creation) }} - {{ this.getTypeOffer(item.type) }}
        </p>

            <td v-if="!readMore[item.offer_id]">{{item.content.substring(0, 100) + "... "}}<button @click="readMore[item.offer_id]=true">Voir Plus</button></td>
            <td v-if="readMore[item.offer_id]">{{item.content+" "}}<button @click="readMore[item.offer_id]=false">Vois Moins</button></td>

          <div class="status">
            <div v-if="item.status=='validate'" class="validate">
              <p>Offre validée</p>
              <button @click="changeStatus(item.offer_id,'archive')">Archiver offre</button>
              <button @click="removeOffer(item.offer_id)">Supprimer offre</button>
            </div>
            <div v-if="item.status=='to_validate'" class="to_validate">
              <p>Offre à valider</p>
              <button @click="changeStatus(item.offer_id,'validate')">Valider offre</button>
              <button @click="removeOffer(item.offer_id)">Refuser offre</button>
            </div>
            <div v-if="item.status=='obsolete'" class="obsolete">
              <p>Offre obsolète</p>
              <button @click="changeStatus(item.offer_id,'unarchive')">Désarchiver offre</button>
              <button @click="removeOffer(item.offer_id)">Supprimer offre</button>
            </div>
          </div>
      </div>
     
    </div>
  </div>
</template>

<script lang='ts'>
import { defineComponent } from 'vue';
import axios from 'axios';
export default defineComponent({
  name: 'OffersAdmin',
  data() {
    return {
      init_offers: null,
      offers: null,
      errorMessage: null,
      type: 'default',
      status: 'default',
      date: 'desc',
      readMore: [],
      currentUser : this.$store.state.auth.user,
    };
  },
  created() {
    if (this.currentUser && this.currentUser.roles) {
      if(this.$store.state.auth.user.roles.includes('admin')){
        this.getOffer();
      }else{
        this.$router.push("/");
      }  
    }else{
        this.$router.push("/");
    }
  },  
  methods: {
    getOffer(){
      // GET request using fetch with error handling
    fetch('http://localhost/backend/offers/')
      .then(async (response) => {
        const data = await response.json();
        // check for error response
        if (!response.ok) {
          // get error message from body or default to response statusText
          const error = (data && data.message) || response.statusText;
          return Promise.reject(error);
        }
        this.init_offers = data;
        this.handle_filter();
        return null;
      })
      .catch((error) => {
        this.errorMessage = error;
        console.error('There was an error!', error);
      });
    },
    sort_type() {
      if(this.type !== 'default'){
        this.offers = this.offers.filter((e : any) => e.type === this.type)
      }
    },
    sort_status() {
      if(this.status !== 'default'){
        this.offers = this.offers.filter((e : any) => e.status === this.status)
      }
    },
    sort_date() {
        if (this.date === 'desc') {
          this.offers = this.offers.sort((a : any,b : any) => {
            return Number(new Date(b.date_creation)) - Number(new Date(a.date_creation));
          })
        }else{
          this.offers = this.offers.sort((a : any,b : any) => {
            return Number(new Date(a.date_creation)) - Number(new Date(b.date_creation));
          })
        }
    },
    handle_filter() {
       this.offers = this.init_offers;
       if(this.offers !== null){
         this.sort_type();
        this.sort_status();
        this.sort_date();
       }
       
    },
    getDateOffer($date : any){
      const $d = new Date($date);

      return $d.getDate() + "/" + $d.getMonth() + "/" + $d.getFullYear() + " - " + $d.getHours() + ":" + $d.getMinutes();
    },
    getTypeOffer($type : any){
      if($type === 'crew'){
        return "Equipier";
      }else{
        return "Embarquement"
      }
    },
    changeStatus($id : any, $param : any){
       const formData = new FormData();
        formData.append('status', $param);
       axios.post('http://localhost/backend/offers/'+$id, formData)
                 .then((res) => {
                     //Perform Success Action
                     this.getOffer();
                 })
                 .catch((error) => {
                     this.errorMessage = error;
                    console.error('There was an error!', error);
                 })  
    },
    removeOffer($id : any){
       const raison="parce que"
       const formData = new FormData();
        formData.append('status', 'remove');
        formData.append('raison', raison);
       axios.post('http://localhost/backend/offers/'+$id, formData)
                 .then((res) => {
                     //Perform Success Action
                     this.getOffer();
                 })
                 .catch((error) => {
                     this.errorMessage = error;
                    console.error('There was an error!', error);
                 })  
    },
  }
});
</script>

<style scoped>
.card{
  background-color: #fafafa; border-radius: 10px; margin: 0.5em;
}
.card-title{
  font-weight: bold;
}
.offer_info{
  font-style: italic; font-size: smaller;
}
button{
  border-radius:50px; background-color:light-grey; margin:2px;
}
td button{
  border:none;
}
.status{
  width: 45%;
}
.status .validate{
  padding:0.4em;
  background-color: #C6F3B4; 
}

.status .to_validate{
  padding:0.4em;
  background-color: #F2F3B4; 
}

.status .obsolete{
  padding:0.4em;
  background-color: #F0CEBB; 
}
 @media only screen and (max-width: 768px) {
   .status{
  width: 90%;
}
 }
</style>