<template>
    <div class="my-6">
        <UserHeader :user="user" />
        <div class="flex flex-col justify-center items-center text-center p-6 hd:w-48 mr-2 my-6 shadow-lg bg-white rounded">
            <div v-if="user.image" class="w-32 h-32 bg-cover rounded-full py-6"
                 :style="{ 'background-image': 'url(' + user.image  + ')'}">
            </div>
            <UserCircle v-else :name="user.name" class="w-32 h-32 py-6 text-4xl"/>
            <div class="w-full md:w-1/5 px-4 py-6">
                <p class="font-bold uppercase text-sm">Name</p>
                <p class="capitalize">{{ user.name }}</p>
            </div>
            <div class="w-full md:w-1/5 px-4 py-6">
                <p class="font-bold uppercase text-sm">Email</p>
                <p v-if="user.email">{{ user.email }}</p>
                <p v-else class="text-gray-400">No email</p>
            </div>
            <div class="w-full md:w-1/5 px-4 py-6">
                <p class="font-bold uppercase text-sm">Bank Account</p>
                <p v-if="user.bank_account" class="capitalize">{{ user.bank_account }}</p>
                <p v-else class="text-gray-400">No bank account added</p>
            </div>
            <div class="w-full md:w-1/5 px-4 py-6">
                <p class="font-bold uppercase text-sm">Notifications</p>
                <p v-for="notification in user.notification_preference" class="capitalize">{{ notification }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import UserCircle from "../components/UserCircle";
import UserHeader from "../components/UserHeader";

export default {
    name: "UserProfile",
    components: {
        UserCircle,
        UserHeader
    },
    data: function () {
        return {
            user: {
                'name': '',
                'image': '',
                'email': '',
                'bank_account': ''
            }
        }
    },
    mounted() {
        axios.get('users/' + this.$route.params.id)
            .then(response => {
                this.user = response.data
            })
            .catch(error => {

            })
    }
}
</script>

<style scoped>

</style>
