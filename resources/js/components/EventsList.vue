<template>
    <div>
        <div v-if="loader" class="loader">
            <img src="/uploads/svg/loading.svg" alt="loading"/>
        </div>
        <div v-else>
            <div class="flex justify-between items-baseline">
                <input type="text" v-model="search" placeholder="Search event"
                       class="p-3 border-b w-64 text-gray-900 border-b py-2 px-4 mb-4 shadow-md focus:outline-none focus:border-blue-400"/>
                <div class="">
                    <input type="checkbox" id="myevents" value="true" v-model="myevents">
                    <label for="myevents" class="mr-2">Show Only My Events</label>
                </div>
            </div>

            <div v-if="filteredList.length === 0" class="my-3">
                No events found. <a href="/events/create" class="text-blue-500 underline">Create new one!</a>
            </div>

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
            search: "",
            myevents: false
        }
    },
    computed: {
        eventsToShow() {
            let array = {
                'publicEvents': this.publicEvents,
                'userEvents': this.userEvents
            }

            return array[this.api]
        },
        loc(){
          return location
        },
        filteredList() {
            return this.eventsToShow.filter(event => {
                return (this.myevents ? event.admin.id === window.user.id : true) &&
                    (event.name.toLowerCase().includes(this.search.toLowerCase()) ||
                        event.beneficier.toLowerCase().includes(this.search.toLowerCase()))
            })
        },
        ...mapGetters(['loader', 'publicEvents', 'userEvents'])
    }
}
</script>

<style scoped>

</style>
