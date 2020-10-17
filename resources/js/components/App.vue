<template>
    <div class="flex bg-gray-200">
        <Navigation></Navigation>
        <div class="flex flex-col flex-1">
            <div class="flex h-16 px-6 border-b border-gray-400 items-center justify-between">
                <div>
                    {{ title }}
                </div>
                <router-link :to="'/users/' + user.id"  class="flex items-center">
                    <UserCircle :name="user.name"/>
                </router-link>
            </div>
            <div
                class="mb-20 md:mb-0 xl:ml-4 xl:mr-4 xl:pb-6 px-2 sm:px-4 xl:px-0">
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
