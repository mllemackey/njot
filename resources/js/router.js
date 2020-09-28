import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from "./components/ExampleComponent";
import ContactsCreate from "./views/ContactsCreate";
import ContactsShow from "./views/ContactsShow";
import ContactsEdit from "./views/ContactsEdit";
import ContactsIndex from "./views/ContactsIndex";
import Logout from "./views/Logout";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: '/',
            component: ExampleComponent,
            meta: {
                title: 'Welcome'
            }
        },
        {
            path: '/contacts',
            component: ContactsIndex,
            meta: {
                title: 'Contacts'
            }
        },
        {
            path: '/contacts/create',
            component: ContactsCreate,
            meta: {
                title: 'Create Contact'
            }
        },
        {
            path: '/contacts/:id',
            component: ContactsShow,
            meta: {
                title: 'Contact'
            }
        },
        {
            path: '/contacts/:id/edit',
            component: ContactsEdit,
            meta: {
                title: 'Edit Contact'
            }
        },
        {
            path: '/logout',
            component: Logout
        },
        ],
    mode: 'history',

});
