<template>
    <div class="my-6">
        <div class="flex justify-between my-3 mb-6">
            <div class="cursor-pointer" @click="$router.back()">
                <font-awesome-icon :icon="['fas', 'arrow-left']" class="text-blue-600 mr-2" /> back
            </div>
        </div>
        <form @submit.prevent="submitForm"  enctype="multipart/form-data">
            <InputField name="name" label="User Name"
                        placeholder="User Name" @update:field="data.name = $event" :errors="errors" :data="form.name"/>
            <InputField name="email" label="User Email"
                        placeholder="User Email" @update:field="data.email = $event" :errors="errors" :data="form.email"/>
            <InputField name="company" label="Bank Account"
                        placeholder="Bank Account" @update:field="data.bank_account = $event" :errors="errors" :data="form.bank_account"/>
            <div class="bg-white w-full text-gray-900 border-b pb-2 pl-4 pr-4 focus:outline-none focus:border-blue-400">
                <label class="pt-2 block pr-4 pb-2 uppercase text-xs font-bold">Notifications</label>
                <input type="checkbox" id="mail" value="mail" v-model="form.notification_preference"  :change="onChangeNotificationPreference()">
                <label for="mail" class="mr-2">Mail</label>
                <input type="checkbox" id="database" value="database" v-model="form.notification_preference" :change="onChangeNotificationPreference()">
                <label for="database">Database</label>
            </div>
            <div class="relative pb-4">
                <label for="image" class="pt-2 uppercase text-xs font-bold absolute">Image</label>
                <input id="image" type="file" :change="(e) => {this.onChangeFileUpload(e)}"
                       class="pt-8 w-full text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400" />
            </div>
            <div class="flex justify-end">
                <button class="px-4 py-3 rounded text-sm font-bold text-white bg-red-500 mr-2">Cancel</button>
                <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Save</button>
            </div>
        </form>
    </div>
</template>

<script>
import InputField from "../components/InputField";

export default {
    name: "UserProfileEdit",
    components: {
        InputField
    },
    data: function () {
        return {
            form: {
                'name': '',
                'email': '',
                'bank_account': '',
                'notification_preference': [],
                'image': '',
            },
            data: {},
            errors: null
        }
    },
    mounted() {
        axios.get('users/' + this.$route.params.id)
            .then(response => {

                this.form = response.data;
            })
            .catch(error => {

            })
    },
    methods: {
        onChangeFileUpload(e) {
            this.data.image = e.target.files[0];
        },
        onChangeNotificationPreference() {
            this.data.notification_preference = this.form.notification_preference
        },
        submitForm: function () {
            let formData = new FormData()

            Object.entries(this.data).forEach(entry => {
                const [key, value] = entry;
                formData.append(key, value)
            });
            formData.append( '_method', 'PUT' );

            formData.forEach((value, key) => {
                console.log(key, ' *** ', value)
            })

            axios.post('users/' + this.$route.params.id, formData, {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            })
                .then(response => {
                    this.$router.push('/users/' + response.data.id)
                })
                .catch(errors => {

                });
        }
    }

}
</script>

<style scoped>

</style>
