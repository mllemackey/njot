<template>
    <div class="card relative shadow-md mb-6 bg-white break-words p-4 md:p-5 rounded w-full md:w-1/4">
        <h2 class="text-2xl bold">Participants</h2>
        <p class="font-bold text-blue-600">{{ event.admin.name }}
                    <sup class="text-blue-600">admin</sup>
                </p>
        <div class="border border-gray-200 bg-gray-100 p-3 mt-3 mb-0 md:mb-3 overflow-y-scroll h-48 leading-normal">
            <div v-if="eventUsers && eventUsers.length !== 0">
                <div v-for="p in eventUsers"
                     class="py-2 border-b border-b-1 border-gray-300">
                    <span>{{ p.name }} ({{ p.email }})</span>
                    <div v-if="event.can.delete && p.id !== event.admin.id" class="text-sm mt-1">
                        <button @click="deleteUser(p)"
                                class="mr-1 hover:text-blue-600">
                            <font-awesome-icon icon="times"/>
                            remove
                        </button>
                        <button class="hover:text-blue-600"
                                @click="markUserFunded(p)"
                                :title="p.pivot.funded ? 'mark not funded' : 'mark funded'">
                            <font-awesome-icon icon="dollar-sign"/>
                            {{ p.pivot.funded ? 'funded' : 'not funded' }}
                        </button>
                    </div>
                </div>
            </div>
            <div v-else>
                <p>No participants yet.</p>
            </div>
        </div>
        <div v-if="event.privacy === 1 && !canUpdateEvent" class="mt-3">
            <button v-if="!myEvent" class="py-3 px-4 my-3 rounded text-white bg-blue-600 text-sm mr-2 hover:opacity-75"
                    @click="enroll">Enroll
            </button>
            <button v-else class="py-3 px-4 my-3 rounded text-white bg-blue-600 text-sm mr-2 hover:opacity-75"
                    @click="deleteUser(null)">Unenroll
            </button>
        </div>
        <div v-if="canUpdateEvent" class="mt-6">
            <h3 class="text-xl">Select users to be added:</h3>
            <input type="text" v-model="search" placeholder="Search by name or email"
                   class="p-3 border-b w-64 text-gray-900 border-b py-2 px-4 my-2 shadow-md focus:outline-none focus:border-blue-400" />
            <label>
                <select v-model="participants"
                        multiple
                        class="border border-gray-200 bg-gray-100 p-3 my-3 overflow-y-scroll w-full h-40 leading-normal"
                >
                    <option v-for="option in filteredList" :value="option"
                            class="py-1">
                        {{ option.name }} ({{ option.email }})
                    </option>
                </select>
            </label>
            <button class="py-3 px-4 my-3 rounded text-white bg-blue-600 text-sm mr-2 hover:opacity-75"
                    @click="updateSelectedTags">Add Participants
            </button>
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
            participants: [],
            search: ""
        }
    },
    computed: {
        ...mapGetters(['users', 'eventUsers']),
        nonparticipants() {
            if (this.users.length === 0) {
                return []
            }
            return this.users.filter(({id}) => !this.eventUsers.find(o => o.id == id))
                .filter(({id}) => {
                    return this.event.admin.id !== id
                });
        },
        filteredList() {
            if (this.nonparticipants.length === 0) {
                return []
            }
            return this.nonparticipants.filter(user => {
                return user.name.toLowerCase().includes(this.search.toLowerCase()) ||
                    user.email.toLowerCase().includes(this.search.toLowerCase())
            })
        },
        canUpdateEvent() {
            if (!this.event || !this.event.can)
                return false
            return this.event.can.update
        },
        myEvent(){
            return this.event.users.find( (user) => user.id === window.user.id)
            // return this.event.use.find((user) => user.id === window.user.id)
        }
    },
    mounted() {
    },
    methods: {
        ...mapActions(['addEventUsers', 'deleteEventUsers', 'updateFunding']),
        updateSelectedTags() {
            this.addEventUsers({
                id: this.$route.params.id,
                data: this.participants
            })
        },
        enroll() {
            this.addEventUsers({
                id: this.$route.params.id,
                data: [window.user]
            })
        },
        deleteUser(user) {
            let userArray = []

            userArray.push(user === null ? window.user : user)
            this.deleteEventUsers({
                id: this.$route.params.id,
                data: userArray
            })
        },
        markUserFunded(user) {
            this.updateFunding({
                id: this.$route.params.id,
                data: {
                    'userId': user.id
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
