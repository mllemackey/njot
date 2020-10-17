<template>
    <div>
        <div v-if="loader" class="loader">
            <img src="/uploads/svg/loading.svg" alt="loading"/>
        </div>
        <div v-else>
            <div v-if="userEvents && userEvents.length === 0">No events yet. <a href="/events/create">Get Started</a></div>

            <div v-for="event in userEvents">
                <router-link :to="'/events/' + event.data.event_id">
                    <EventInfo :event="event.data"/>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import EventInfo from "./event/EventInfo";
import {mapGetters} from "vuex";

export default {
    name: "EventsList",
    components: {
        EventInfo
    },
    computed: {
        ...mapGetters(['loader', 'userEvents'])
    },
    mounted() {
        // axios.get(this.api)
        //     .then(response => {
        //
        //         this.events = response.data.data ? response.data.data : response.data;
        //
        //         this.loading = false;
        //     })
        //     .catch(error => {
        //         this.loading = false;
        //
        //         alert('Unable to fetch events');
        //     })
    }
}
</script>

<style scoped>

</style>
