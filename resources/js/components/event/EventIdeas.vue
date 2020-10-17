<template>
    <div class="w-3/4 pl-6">
        <div class="card">
            <h2 class="text-2xl bold">Present Ideas</h2>
            <div v-if="eventPresentIdeas.length === 0">No present ideas yet.</div>
            <div v-else class="ideas border border-gray-200 bg-gray-100 p-3 my-3 overflow-y-scroll h-64">
                <div v-for="i in eventPresentIdeas" class="border-b border-gray-300 pb-4 my-2">
                    <h3 class="text-lg text-blue-600 bold">{{ i.user.name }}</h3>
                    <div class="flex items-start">
                        <p class="w-5/6  pr-6">{{ i.idea }}</p>

                        <button class="w-1/6 bg-blue-600 p-2 text-white text-sm rounded" @click="addVote(i.id)">
                            <font-awesome-icon v-if="i.iVoted" :icon="['fas', 'heart']" class="text-white text-base mr-2" /> ({{ i.voted }} votes)
                            <font-awesome-icon v-else :icon="['fas', 'heart']" class="text-blue-600 text-base mr-2" /> ({{ i.voted }} votes)
                        </button>
                    </div>
                </div>
            </div>
            <button class="py-3 px-4 rounded text-white bg-blue-600 text-sm mr-2 hover:opacity-75" @click="modal = true">
                Add New Present Idea
            </button>
        </div>
        <div v-if="modal" class="absolute z-20 m-auto inset-0 -translate-y-1/2 top-1/2">
            <div class="bg-blue-900 text-white rounded-lg p-8 w-64 my-0 mx-auto flex flex-col">
                <h4>Add New Idea</h4>
                <form @submit.prevent="addNewIdea" method="post">
                    <label for="idea" class="pt-2 uppercase text-xs font-bold absolute text-blue-600">Idea</label>
                    <textarea name="idea" id="idea" v-model="form.idea"
                              class="pt-8 w-full text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400"></textarea>
                    <InputField name="order_place" label="Idea Order Place" type="text"
                                placeholder="Idea Order Place" @update:field="form.order_place = $event"
                                :errors="errors"/>

                    <div class="flex justify-end">
                        <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700"
                                @click="modal = ! modal">Cancel
                        </button>
                        <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400" @click="addNewIdea">
                            Add New Idea
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="modal" class="bg-black opacity-25 absolute inset-0 z-10"
             @click="modal = ! modal"></div>

    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import InputField from "../InputField";

export default {
    name: "EventIdeas",
    components: {
        InputField
    },
    props: [
        'event'
    ],
    data: function () {
        return {
            modal: false,
            form: {
                'idea': '',
                'order_place': ''
            },
            votes: [],
            errors: null
        }
    },
    computed: {
        ...mapGetters(['users', 'eventUsers', 'presentIdeas']),
        eventPresentIdeas() {
            return this.presentIdeas.filter(p => {
                return p.event.id === this.event.data.event_id
            })
        }
    },
    methods: {
        ...mapActions(['vote', 'deleteVotes', 'createPresentIdea']),
        addVote(id) {
            this.vote({
                present_idea_id: id
            })
        },
        addNewIdea() {
            this.modal = !this.modal
            this.createPresentIdea({
                event_id: this.event.data.event_id,
                idea: this.form.idea,
                order_place: this.form.order_place
            })
        }
    }
}
</script>

<style scoped>

</style>
