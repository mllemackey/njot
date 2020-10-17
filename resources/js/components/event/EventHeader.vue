<template>
    <div class="flex justify-between py-6">
        <div class="cursor-pointer" @click="$router.back()">
            < Back
        </div>
        <div class="relative">
            <router-link :to="'/events/' + event.event_id + '/edit'" class="px-4 py-2 rounded text-green-500 border border-green-500 text-sm font-bold mr-2">Edit</router-link>
            <a href="#" class="px-4 py-2 border border-red-500 rounded text-sm font-bold text-red-500" @click="modal = !modal">Delete</a>

            <div v-if="modal" class="absolute bg-blue-900 text-white rounded-lg z-20 p-8 w-64 right-0 mt-2 mr-6">
                <p>Are you sure you want to delete this record?</p>

                <div class="flex items-center mt-6 justify-end">
                    <button class="text-white pr-4" @click="modal = ! modal">Cancel</button>
                    <button class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white" @click="destroy">Delete</button>
                </div>
            </div>
        </div>
        <div v-if="modal" class="bg-black opacity-25 absolute right-0 left-0 top-0 bottom-0 z-10" @click="modal = ! modal"></div>
    </div>
</template>

<script>
export default {
    name: "EventHeader",
    props: [
        'event'
    ],
    data: function () {
        return {
            modal: false
        }
    },
    methods: {
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
