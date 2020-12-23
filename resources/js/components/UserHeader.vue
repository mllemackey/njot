<template>
    <div class="flex justify-between py-6">
        <div class="cursor-pointer" @click="$router.back()">
            <font-awesome-icon :icon="['fas', 'arrow-left']" class="text-blue-600 mr-2" /> back
        </div>
        <div class="relative">
            <router-link :to="'/users/' + user.id + '/edit'" class="px-4 py-3 rounded text-white bg-blue-600 text-sm mr-2 hover:opacity-75">Edit</router-link>
            <a href="#" class="px-4 py-3 rounded text-sm font-bold text-white bg-red-500" @click="modal = !modal">Delete</a>

            <div v-if="modal" class="fixed bg-blue-900 text-white rounded-lg z-50 p-8 w-64 right-0 mt-2 mr-6">
                <p>Are you sure you want to delete your profile? <br/> This action cannot be undone.</p>

                <div class="flex items-center mt-6 justify-end">
                    <button class="text-white pr-4" @click="modal = ! modal">Cancel</button>
                    <button class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white" @click="destroy">Delete</button>
                </div>
            </div>
        </div>
        <div v-if="modal" class="bg-black opacity-25 fixed right-0 left-0 top-0 bottom-0 z-40" @click="modal = ! modal"></div>
    </div>
</template>

<script>
export default {
    name: "UserHeader",
    props: [
        'user'
    ],
    data: function () {
        return {
            modal: false
        }
    },
    computed:{

    },
    methods: {
        destroy(){
            axios.post('users/' + this.$route.params.id + '/delete', {
                'method' : 'DELETE'
            })
                .then( response => {
                    this.$router.push('/logout');
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>

<style scoped>

</style>
