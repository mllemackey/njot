<template>
    <div class="w-1/4">
        <h2 class="text-2xl bold">Participants</h2>
        <div class="border border-black p-3 m-3 overflow-y-scroll h-40">
            <span v-for="p in eventUsers">
                {{ p.name }} <button v-if="p.id != event.data.admin" @click="deleteUser(p)">X</button><br/>
            </span>
        </div>
        <div>
            <label>
                <select v-model="participants"
                        multiple
                >
                    <option v-for="option in nonparticipants" :value="option">
                        {{ option.name }}
                    </option>
                </select>
            </label>
        </div>
        <button class="p-3 m-3 bg-blue-600 text-white hover:opacity-75" @click="updateSelectedTags">Add Participants</button>
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
        }

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
