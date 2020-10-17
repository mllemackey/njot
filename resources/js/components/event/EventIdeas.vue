<template>
    <div class="w-3/4">
        <h2 class="text-2xl bold">Present Ideas</h2>
        <div class="border border-black p-3 m-3 overflow-y-scroll h-40">
            <div v-for="i in eventPresentIdeas"  class="border-b border-black py-2 my-2">
                <h3 class="text-lg text-blue-600 bold">{{ i.user.name}}</h3>
                <div class="flex">
                    <p class="w-5/6">{{ i.idea }}</p>

                    <button class="w-1/6 bg-blue-600 p-2 text-white" @click="vote()">
                        {{ i.voted }} <img src="/uploads/svg/heart-outline.svg" alt="add">
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "EventIdeas",
    props: [
        'event'
    ],
    computed: {
        ...mapGetters(['users', 'eventUsers', 'presentIdeas' ]),
        eventPresentIdeas(){
            return this.presentIdeas.filter( p => {
                  return p.event.id === this.event.data.event_id
            })
        }
    },
    data: () => ({
        votes: []
    }),
    methods: {
        ...mapActions(['addVotes', 'deleteVotes']),
        updateSelectedTags() {
            this.addVotes({
                id: this.$route.params.id,
                data: this.votes
            })
        },
        deleteVotes(user) {
            let userArray = []
            userArray.push(user)
            this.deleteEventUsers({
                id: this.$route.params.id,
                data: userArray
            })
        },
        vote(){
            // this.votes.push(auth()->)
        }
    }
}
</script>

<style scoped>

</style>
