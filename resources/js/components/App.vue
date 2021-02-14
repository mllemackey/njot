<template>
    <div class="main-content flex flex-col md:flex-row">
        <Navigation></Navigation>
        <div class="flex flex-col flex-1 md:ml-56">
            <div v-if="modal" class="bg-black opacity-25 fixed right-0 left-0 top-0 bottom-0 z-40" @click="modal = ! modal"></div>
            <div class="nav-main flex h-16 px-6 items-center justify-between md:fixed w-full z-10 left-0 top-0 pl-0 md:pl-56 bg-gray-100 md:bg-blue-700">
                <div class="ml-4 mb:ml-6 font-bold text-xl text-blue-600 md:text-white">
                    {{ title }}
                </div>
                <div class="flex">
                    <a href="#" class="flex py-2 mx-2 hover:text-blue-200 relative" @click="modal = !modal">
                        <span v-if="userNotifications.countUnread !== 0" class="absolute top-0 rounded p-1 bg-red-500 text-white rounded-full w-5 h-5 -ml-3 leading-none text-center">{{ userNotifications.countUnread }}</span>
                        <font-awesome-icon :icon="['fas', 'bell']" class="text-3xl" />
                    </a>
                    <router-link :to="'/users/' + user.id"  class="flex items-center">
                        <UserCircle :name="user.name"/>
                    </router-link>
                </div>
            </div>
            <div v-if="modal" id="notification-modal" class="fixed bg-white text-blue-900 rounded-lg z-50 py-8 right-0 mt-16 mr-6 w-1/6">
                <div class="flex justify-between py-3 px-8 items-baseline">
                    <h4 class="font-bold text-xl">Notifications</h4>
                    <a @click="markAllUsersNotificationsRead" class="cursor-pointer">Mark All Read</a>
                </div>
                <div v-if="userNotifications.notifications && userNotifications.notifications.length === 0" class="px-8 ">
                    <p>No notifications</p>
                </div>
                <div v-else>
                    <div v-for="notification in userNotifications.notifications" class="py-4 px-8 border-b border-gray-500" :class="{ 'bg-blue-100' : !notification.read_at }">
                        <a :href="notification.redirect_url"  @click="markRead(notification)">
                            <p>{{ notification.text }}</p>
                            <p class="text-gray-500 text-base">{{ notification.created_at }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mb-4 xl:ml-6 xl:mr-6 xl:pb-6 mx-4 xl:px-0 md:mt-24">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import UserCircle from "./UserCircle";
import Navigation from "../views/Navigation";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "App",
    components: {Navigation, UserCircle},
    props: [
        "user"
    ],
    data: function () {
        return {
            title: '',
            modal: false
        }
    },
    computed: {
        ...mapGetters(['userNotifications'])
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
        this.getUsers();
        this.getEvents();
        this.getUserEvents();
        this.getUserNotifications();
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
            'getUsers',
            'getEvents',
            'getUserEvents',
            'getUserNotifications',
            'getPresentIdeas',
            'markAllUsersNotificationsRead',
            'markUsersNotificationRead'
        ]),
        markRead(notification) {
            this.markUsersNotificationRead({
                id: notification.id,
                data: {
                    'id': notification.id
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
