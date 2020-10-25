<template>
    <div class="w-3/4 pl-6">
        <div class="card">
            <h2 class="text-2xl bold">Present Ideas</h2>
            <div v-if="eventPresentIdeas.length === 0">No present ideas yet.</div>
            <div v-else class="ideas border border-gray-200 bg-gray-100 p-3 my-3 overflow-y-scroll h-64">
                <div v-for="i in eventPresentIdeas" class="border-b border-gray-300 pb-4 my-2">
                    <h3 class="text-lg text-blue-600 bold">{{ i.user.name }}</h3>
                    <div class="flex items-start">
                        <div class="w-5/6  pr-6">
                            <p>{{ i.idea }}</p>
                            <p>{{ i.order_place }}</p>
                            <div v-if="i.can.update" class="mt-3">
                                <button @click="openEditModal(i)" class="text-blue-600 underline mr-3">Edit</button>
                                <button @click="deleteIdea(i.id)" class="text-blue-600 underline">Delete</button>
                            </div>
                        </div>
                        <button v-if="i.can.vote" class="w-1/6 bg-blue-600 p-2 text-white text-sm rounded hover:bg-blue-400" @click="addVote(i.id)">
                            <font-awesome-icon v-if="i.iVoted" :icon="['fas', 'heart']" class="text-white text-base mr-2" />
                            <font-awesome-icon v-else :icon="['fas', 'heart']" class="text-white text-base opacity-25 mr-2" />
                            ({{ i.voted }} votes)
                        </button>
                        <div v-else class="w-1/6 text-blue-600 p-2 text-center text-sm rounded">
                            <font-awesome-icon :icon="['fas', 'heart']" class="text-blue-600 text-base mr-2" />
                            ({{ i.voted }} votes)
                        </div>

                    </div>
                </div>
            </div>
            <button class="py-3 px-4 rounded text-white bg-blue-600 text-sm mr-2 hover:opacity-75" @click="modal = true">
                Add New Present Idea
            </button>
        </div>
        <div v-if="modal" class="fixed flex justify-center items-center z-50 m-auto inset-0 -translate-y-1/2 top-1/2">
            <div class="bg-blue-700 text-white rounded-lg p-8 w-full max-w-xl my-0 mx-auto flex flex-col">
                <h4 class="mb-6 text-2xl bold">Add New Idea</h4>
                <form @submit.prevent="edit_id ? editIdea : addNewIdea" method="post" class="event-form">
                    <label for="idea" class="pt-2 pl-4 pr-4 uppercase text-xs font-bold absolute text-gray-700">Idea</label>
                    <textarea name="idea" id="idea" v-model="form.idea"
                              class="pt-8 w-full text-gray-900 pb-2 focus:outline-none focus:border-blue-700 pl-4 pr-4 resize-none"></textarea>
                    <label for="order_place" class="pt-2 uppercase text-xs font-bold absolute text-blue-600">Order Place</label>
                    <input name="order_place" type="text" id="order_place" v-model="form.order_place"
                           class="pt-8 w-full text-gray-900 pb-2 focus:outline-none focus:border-blue-700" />

                    <div class="flex justify-end">
                        <button class="px-4 py-3 rounded text-sm font-bold text-white bg-red-500 mr-5"
                                @click="modal = ! modal">Cancel
                        </button>
                        <button v-if="edit_id != null" class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400" @click="editIdea">
                            Edit Present Idea
                        </button>
                        <button v-else class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400" @click="addNewIdea">
                            Add New Idea
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="modal" class="bg-black opacity-75 fixed left-0 top-0 inset-0 z-40"
             @click="modal = ! modal"></div>

    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import InputField from "../InputField";
import _ from 'lodash'

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
            edit_id: null,
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
            let eventIdeas =  this.presentIdeas.filter(p => {
                return p.event.id === this.event.id
            })

            return _.orderBy(eventIdeas, [function(o) { return o.voted; }], 'desc');
        },
        loggedUser(){
            return window.user.name
        }
    },
    methods: {
        ...mapActions(['vote', 'createPresentIdea','editPresentIdea','deletePresentIdea']),
        addVote(id) {
            this.vote({
                present_idea_id: id
            })
        },
        addNewIdea() {
            this.modal = !this.modal
            this.createPresentIdea({
                event_id: this.event.id,
                idea: this.form.idea,
                order_place: this.form.order_place
            })
            this.form.idea = ''
            this.form.order_place = ''
        },
        openEditModal(i){
            this.edit_id = i.id
            this.form.idea = i.idea
            this.form.order_place = i.order_place
            this.modal = true
        },
        editIdea(){
            this.editPresentIdea({
                present_idea_id: this.edit_id,
                data: {
                    idea: this.form.idea,
                    order_place: this.form.order_place
                }
            })
            this.modal = !this.modal
            this.edit_id = null
            this.form.idea = ''
            this.form.order_place = ''
        },
        deleteIdea(id){
            console.log(id)
            this.deletePresentIdea({
                present_idea_id: id
            })
            console.log('c')
        }
    }
}
</script>

<style scoped>

</style>
