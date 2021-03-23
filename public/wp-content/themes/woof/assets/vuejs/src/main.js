


// installation de font awesome
import '@fortawesome/fontawesome-free/css/all.css';

console.log('%c' + 'bootstrap loaded', 'color: #0bf; font-size: 1rem; background-color:#fff');
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.css' // Import precompiled Bootstrap css


import './scss/main.scss';



console.log('%c' + 'Vuejs loaded', 'color: #0bf; font-size: 1rem; background-color:#fff');
// import de vuejs
import Vue from 'vue';


// ==========================================================
import router from './plugins/router';

// inclusion de la configuration de vuetify
import vuetifyInstance from './plugins/vuetify';


// inclusion de la configuration de vuex
import store from './plugins/vuex';
// ==========================================================

// import Application from "./Application";
// import Application2 from "./Application2";



/*
let application = new Vue({
  // élément du dom (via selecteur) dans lequel l'application va s'afficher
  el: '#app',

  // STEP injection des plugins
  router,
  store,
  vuetify: vuetifyInstance,

  // TIPS on injecte un objet Application dans le container #vuejs-container
  render: createApplication => createApplication(Application),
  // on "injecte" les composant dont l'application va avoir besoin
});
*/


import DemoVuetify from './components/DemoVuetify.vue'
new Vue({
  render: h => h(DemoVuetify),
  router,
  store,
  vuetify: vuetifyInstance
}).$mount('#vuejs-container')


import DemoVuetify2 from './components/DemoVuetify2.vue'
new Vue({
  render: h => h(DemoVuetify2),
  router,
  store,
  vuetify: vuetifyInstance
}).$mount('#vuejs-container-2')



/*
import App from './App.vue'
Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router,
  store,
  vuetify: vuetifyInstance
}).$mount('#vuejs-container')
*/

