<template>
    <div class="main-content flex flex-col md:flex-row">
        <Navigation></Navigation>
        <div class="flex flex-col flex-1 md:ml-56">
            <div class="nav-main flex h-16 px-6 items-center justify-between md:fixed w-full z-10 left-0 top-0 pl-0 md:pl-56 bg-gray-100 md:bg-blue-700">
                <div class="ml-4 mb:ml-6 font-bold text-xl text-blue-600 md:text-white">
                    {{ title }}
                </div>
                <router-link :to="'/users/' + user.id"  class="flex items-center">
                    <UserCircle :name="user.name"/>
                </router-link>
            </div>
            <div class="mb-4 xl:ml-6 xl:mr-6 xl:pb-6 px-4 xl:px-0 md:mt-24">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import UserCircle from "./UserCircle";
import Navigation from "../views/Navigation";
import {mapActions} from "vuex";

export default {
    name: "App",
    components: {Navigation, UserCircle},
    props: [
        "user"
    ],
    data: function () {
        return {
            title: ''
        }
    },
    created() {

        this.title = this.$route.meta.title;

        axios.defaults.headers.common = {'Authorization': `Bearer ${this.user.api_token}`}
        window.axios.interceptors.request.use(
            (config) => {
                if (config.method === 'get') {
                    config.url = config.url + '?api_token=' + this.user.api_token;
                }
                return config;
            }
        )
    },
    mounted() {
        this.getEvents();
        this.getUserEvents();
        this.getUsers();
        this.getPresentIdeas();
    },
    watch: {
        $route(to, from) {
            this.title = to.meta.title
        },
        title() {
            document.title = this.title + ' | Njot'
        }
    },
    methods: {
        ...mapActions([
            'getEvents',
            'getUserEvents',
            'getUsers',
            'getPresentIdeas',
        ])
    }
}
</script>

<style scoped>

</style>
