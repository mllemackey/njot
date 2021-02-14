import Vue from 'vue';
import VueRouter from 'vue-router';
import EventsCreate from "./views/EventsCreate";
import EventsShow from "./views/EventsShow";
import EventsEdit from "./views/EventsEdit";
import Logout from "./views/Logout";
import Calendar from "./views/Calendar";
import EventsList from "./components/EventsList";
import UserProfile from "./views/UserProfile";
import UserProfileEdit from "./views/UserProfileEdit";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: '/events',
            component: EventsList,
            meta: {
                title: 'My Events'
            },
            props: { api: 'userEvents' }
        },

        {
            path: '/events/create',
            component: EventsCreate,
            meta: {
                title: 'Create Event'
            }
        },
        {
            path: '/events/:id',
            component: EventsShow,
            meta: {
                title: 'Event Details'
            }
        },
        {
            path: '/events/:id/edit',
            component: EventsEdit,
            meta: {
                title: 'Edit Event'
            }
        },
        {
            path: '/',
            component: EventsList,
            meta: {
                title: 'Welcome to Njot'
            },
            props: { api: 'publicEvents' }
        },
        {
            path: '/users/:id',
            component: UserProfile,
            meta: {
                title: 'User Profile'
            }
        },
        {
            path: '/users/:id/edit',
            component: UserProfileEdit,
            meta: {
                title: 'Edit User Profile'
            }
        },
        {
            path: '/logout',
            component: Logout
        },
        {
            path: '/calendar',
            component: Calendar,
            meta: {
                title: 'Calendar'
            }
        },
        ],
    mode: 'history',

});
