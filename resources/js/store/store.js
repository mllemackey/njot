import Vue from 'vue';
import Vuex from 'vuex';
import events from "./modules/events";
import users from "./modules/users";
import present_ideas from "./modules/present_ideas";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        events,
        users,
        present_ideas
    }
});
