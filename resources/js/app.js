import Vue from 'vue';
import Vuex from 'vuex'
import router from './router'
import App from "./components/App";
import store from "./store/store";
import VueClipboard from 'vue-clipboard2'

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faPlus, faBirthdayCake, faCalendar, faCalendarAlt, faSignOutAlt, faArrowLeft, faChevronLeft, faHeart } from '@fortawesome/free-solid-svg-icons'

library.add(faPlus, faBirthdayCake, faCalendar, faCalendarAlt, faSignOutAlt, faArrowLeft, faChevronLeft, faHeart)

Vue.component('font-awesome-icon', FontAwesomeIcon)

require('./bootstrap');

Vue.use(Vuex)
Vue.use(VueClipboard)

const app = new Vue({
    el: '#app',
    components: {
      App
    },
    router,
    store
});
