<template>
    <div>
        <div class="flex justify-between">
            <div class="cursor-pointer" @click="$router.back()">
                < Back
            </div>
        </div>
        <form @submit.prevent="submitForm"  enctype="multipart/form-data">
            <InputField name="name" label="User Name"
                        placeholder="User Name" @update:field="data.name = $event" :errors="errors" :data="form.name"/>
            <InputField name="email" label="User Email"
                        placeholder="User Email" @update:field="data.email = $event" :errors="errors" :data="form.email"/>
            <InputField name="company" label="Bank Account"
                        placeholder="Bank Account" @update:field="data.bank_account = $event" :errors="errors" :data="form.bank_account"/>
            <div class="relative pb-4">
                <label for="image" class="pt-2 uppercase text-xs font-bold absolute">Image</label>
                <input id="image" type="file" v-on:change="(e) => {this.onChangeFileUpload(e)}"
                       class="pt-8 w-full text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400" />
            </div>
            <div class="flex justify-end">
                <button class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
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
                'image': '',
            },
            data: {},
            errors: null
        }
    },
    mounted() {
        axios.get('users/' + this.$route.params.id)
            .then(response => {
                console.log(response.data)
                this.form = response.data;
            })
            .catch(error => {

                // if( error.response.status === 404){
                //     this.$router.push('/users/' + this.$route.params.id)
                // }
            })
    },
    methods: {
        onChangeFileUpload(e) {
            this.data.image = e.target.files[0];
        },
        submitForm: function () {
            let formData = new FormData()

            Object.entries(this.data).forEach(entry => {
                const [key, value] = entry;
                formData.append(key, value)
            });
            formData.append( '_method', 'PUT' );

            formData.forEach((value, key) => {
                console.log(key, '-', value)
            })

            axios.post('users/' + this.$route.params.id, formData, {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            })
                .then(response => {
                    console.log(response.data)
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
