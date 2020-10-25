<template>
    <div class="card w-1/4">
        <h2 class="text-2xl bold">Participants</h2>
        <div class="border border-gray-200 bg-gray-100 p-3 my-3 overflow-y-scroll h-40">
            <div v-for="p in eventUsers">
                <span :class="{ 'font-bold text-blue-600' : p.id === event.admin.id }">{{ p.name }}
                    <sup class="text-blue-600" v-if="p.id === event.admin.id">admin</sup>
                </span>
                <button v-if="event.can.delete && p.id !== event.admin.id" @click="deleteUser(p)">X</button><br/>
            </div>
        </div>
        <div v-if="event.can.update">
            <h3 class="text-xl">Select users to be added:</h3>
            <label>
                <select v-model="participants"
                        multiple
                        class="border border-gray-200 bg-gray-100 p-3 my-3 overflow-y-scroll w-full h-40"
                >
                    <option v-for="option in nonparticipants" :value="option">
                        {{ option.name }}
                    </option>
                </select>
            </label>
        <button class="py-3 px-4 my-3 rounded text-white bg-blue-600 text-sm mr-2 hover:opacity-75" @click="updateSelectedTags">Add Participants</button>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "EventUsers",
    props: [
        'event'
    ],
    data: function () {
        return {
            participants: []
        }
    },
    computed: {
        ...mapGetters(['users', 'eventUsers']),
        nonparticipants() {
            return this.users.filter(({id}) => !this.eventUsers.find(o => o.id == id));
        },

    },
    mounted() {
    },
    methods: {
        ...mapActions(['addEventUsers', 'deleteEventUsers']),
        updateSelectedTags() {
            this.addEventUsers({
                id: this.$route.params.id,
                data: this.participants
            })
        },
        deleteUser(user) {
            let userArray = []
            userArray.push(user)
            this.deleteEventUsers({
                id: this.$route.params.id,
                data: userArray
            })
        }
    }
}
</script>

<style scoped>

</style>
