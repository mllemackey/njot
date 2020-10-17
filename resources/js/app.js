import Vue from 'vue';
import Vuex from 'vuex'
import router from './router'
import App from "./components/App";
import store from "./store/store";

require('./bootstrap');

Vue.use(Vuex)

const app = new Vue({
    el: '#app',
    components: {
      App
    },
    router,
    store
});
