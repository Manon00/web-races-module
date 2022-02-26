import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import Home from '../views/Home.vue';
import Calendar from '../views/Calendar.vue';
import Offers from '../views/Offers.vue';
import OffersAdmin from '../views/OffersAdmin.vue';
import Login from '../views/Login.vue';
import Profile from '../views/Profile.vue';
import PostOffer from '../views/PostOffer.vue';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/calendar',
    name: 'Calendar',
    component: Calendar,
  },
  {
    path: '/offers',
    name: 'Offers',
    component: Offers,
  },
  {
    path: '/offersAdmin',
    name: 'OffersAdmin',
    component: OffersAdmin,
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/profile',
    name: 'Profile',
    component: Profile,
  },
  {
    path: '/post',
    name: 'PostOffer',
    component: PostOffer,
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
