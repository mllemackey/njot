<template>
    <div class="event-show">
        <div v-if="loader" class="loader">
            <img src="/uploads/svg/loading.svg" alt="loading"/>
        </div>
        <template v-else>
            <EventHeader :event="event.data" />
            <EventInfo :event="event.data" />
            <div class="flex justify-around">
                <EventUsers :event="event" />
                <EventIdeas :event="event" />
            </div>
        </template>
    </div>
</template>

<script>
import EventInfo from "../components/event/EventInfo";
import EventHeader from "../components/event/EventHeader";
import EventUsers from "../components/event/EventUsers";
import {mapActions, mapGetters} from "vuex";
import EventIdeas from "../components/event/EventIdeas";

export default {
    name: "EventsShow",
    components: {
        EventUsers,
        EventIdeas,
        EventHeader,
        EventInfo
    },
    data: function () {
        return {
            loading: true
        }
    },
    computed: {
        ...mapGetters(['event', 'loader'])
    },
    mounted() {
        this.getEvent(this.$route.params.id)
        // axios.get('events/' + this.$route.params.id)
        //     .then(response => {
        //         this.event = response.data.data;
        //         this.loading = false
        //     })
        //     .catch(error => {
        //         this.loading = false
        //
        //         if( error.response.status === 404){
        //             this.$router.push('/events')
        //         }
        //     })

    },
    methods: {
        ...mapActions(['getEvent']),
        destroy(){
            axios.delete('events/' + this.$route.params.id)
            .then( response => {
                this.$router.push('/events');
            })
            .catch(error => {
                alert('Error. Unable to delete event.');
            })
        }
    }
}
</script>

<style scoped>

</style>
