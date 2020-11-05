<template>
    <div>
        <div v-if="loader" class="loader">
            <img src="/uploads/svg/loading.svg" alt="loading"/>
        </div>
        <div v-else>
            <input type="text" v-model="search" placeholder="Search event"/>
            <div v-if="filteredList.length === 0">No events found. <a href="/events/create">Create new one!</a></div>

            <div v-for="event in filteredList">
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
    data: function () {
        return {
            search: ""
        }
    },
    computed: {
        eventsToShow(){
            let array = {
                'publicEvents': this.publicEvents,
                'userEvents': this.userEvents,
                'administratedEvents': this.administratedEvents,
            }

            return array[this.api]
        },
        filteredList() {
            return this.eventsToShow.filter(event => {
                return event.name.toLowerCase().includes(this.search.toLowerCase()) ||
                    event.beneficier.toLowerCase().includes(this.search.toLowerCase())
            })
        },
        ...mapGetters(['loader', 'publicEvents', 'userEvents', 'administratedEvents'])
    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
