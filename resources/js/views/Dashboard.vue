<template>
    <div>
        <h2>Explore more Events!</h2>
        <div v-if="loader" class="loader">
            <img src="/uploads/svg/loading.svg" alt="loading"/>
        </div>
        <div v-else>
            <div v-if="publicEvents && publicEvents.length === 0">No events yet. <a href="/events/create">Get Started</a></div>

            <div v-for="event in publicEvents">
                <router-link :to="'/events/' + event.id">
                    <EventInfo :event="event"/>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import EventInfo from "../components/event/EventInfo";

export default {
    name: "Dashboard",
    components: { EventInfo },
    computed: {
        ...mapGetters(['loader', 'publicEvents'])
    }
}
</script>

<style scoped>

</style>
