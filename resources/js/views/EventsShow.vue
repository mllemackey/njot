<template>
    <div class="event-show">
        <div v-if="loader" class="loader">
            <img src="/uploads/svg/loading.svg"
                 alt="loading"
            />
        </div>
        <template v-else>
            <EventHeader :event="event" />
            <EventInfo :event="event" />
            <div class="flex flex-col md:flex-row
                justify-around items-stretch">
                <EventUsers :event="event" />
                <EventIdeas :event="event" />
            </div>
            <div>
                <EventFunding :event="event" />
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
import EventFunding from "../components/event/EventFunding";

export default {
    name: "EventsShow",
    components: {
        EventUsers,
        EventIdeas,
        EventHeader,
        EventInfo,
        EventFunding
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
