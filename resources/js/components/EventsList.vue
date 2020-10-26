<template>
    <div>
        <div v-if="loader" class="loader">
            <img src="/uploads/svg/loading.svg" alt="loading"/>
        </div>
        <div v-else>
            <div v-if="userEvents && userEvents.length === 0">No events yet. <a href="/events/create">Get Started</a></div>

            <div v-for="event in eventsToShow">
                <router-link :to="'/events/' + event.id">
                    <EventInfo :event="event"/>
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
    props: [
        'api'
    ],
    computed: {
        eventsToShow(){
            let array = {
                'publicEvents': this.publicEvents,
                'userEvents': this.userEvents,
                'administratedEvents': this.administratedEvents,
            }

            return array[this.api]
        },
        ...mapGetters(['loader', 'publicEvents', 'userEvents', 'administratedEvents'])
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
