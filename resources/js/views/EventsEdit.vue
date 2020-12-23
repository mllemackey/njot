<template>
    <div>
        <div class="flex justify-between py-6">
            <div class="cursor-pointer" @click="$router.back()">
                <font-awesome-icon :icon="['fas', 'arrow-left']" class="text-blue-600 mr-2" /> back
            </div>
        </div>
        <form @submit.prevent="submitForm" enctype="multipart/form-data" class="event-form" >
            <InputField name="name" label="Event Name" type="text"
                        placeholder="Event Name" @update:field="data.name = $event" :errors="errors" :data="form.name"/>
            <InputField name="description" label="Event Description" type="text"
                        placeholder="Event Description" @update:field="data.description = $event" :errors="errors"
                        :data="form.description"/>
            <InputField name="beneficier" label="Event Beneficier" type="text"
                        placeholder="Event Beneficier" @update:field="data.beneficier = $event" :errors="errors"
                        :data="form.beneficier"/>
            <InputField name="date" label="Date" type="text"
                        placeholder="MM/DD/YYYY" @update:field="data.date = $event" :errors="errors" :data="form.date"/>
            <InputField name="amount" label="Amount" type="text"
                        placeholder="Amount" @update:field="data.amount = $event" :errors="errors" :data="form.amount"/>

            <input type="radio" id="private" name="privacy" value="0" v-model="form.privacy"
                   @change="data.privacy = form.privacy">
            <label for="private">Private</label>
            <input type="radio" id="public" name="privacy" value="1" v-model="form.privacy" class="ml-3"
                   @change="data.privacy = form.privacy">
            <label for="public">Public</label><br>

            <div class="relative pb-4">
                <label for="image" class="pt-2 uppercase text-xs font-bold absolute">Image</label>
                <input id="image" type="file" v-on:change="(e) => {this.onChangeFileUpload(e)}"
                       class="pt-8 w-full text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400"/>
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
    name: "EventsEdit",
    components: {
        InputField
    },
    data: function () {
        return {
            form: {
                'name': '',
                'description': '',
                'beneficier': '',
                'date': '',
                'amount': '',
                'image': '',
                'privacy': '',
            },
            data: {},
            errors: null
        }
    },
    mounted() {
        axios.get('events/' + this.$route.params.id)
            .then(response => {
                this.form = response.data.data;
            })
            .catch(errors => {
                if (errors.response.status === 404) {
                }
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
            formData.append('_method', 'PUT');

            axios.post('events/' + this.$route.params.id, formData, {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }).then(response => {
                console.log(response.data)
                this.$router.push(response.data.url)
            }).catch(errors => {

            });
        }
    }

}
</script>

<style scoped>

</style>
