<template>
<div>
    <form @submit.prevent="submitForm" method="post" class="event-form">
        <InputField name="name" label="Event Name" type="text"
                    placeholder="Event Name" @update:field="form.name = $event" :errors="errors"/>
        <InputField name="description" label="Event Description" type="text"
                    placeholder="Event Description" @update:field="form.description = $event" :errors="errors"/>
        <InputField name="beneficier" label="Event Beneficier" type="text"
                    placeholder="Event Beneficier" @update:field="form.beneficier = $event" :errors="errors"/>
        <InputField name="date" label="Date" type="text"
                    placeholder="MM/DD/YYYY" @update:field="form.date = $event" :errors="errors"/>
        <InputField name="amount" label="Amount" type="text"
                    placeholder="Amount" @update:field="form.amount = $event" :errors="errors"/>

        <input type="radio" id="private" name="privacy" value="0" v-model="form.privacy">
        <label for="private">Private</label>
        <input type="radio" id="public" name="privacy" value="1" v-model="form.privacy" class="ml-3">
        <label for="public">Public</label><br>

        <div class="relative pb-4">
            <label for="image" class="pt-2 uppercase text-xs font-bold absolute">Image</label>
            <input id="image" type="file" v-on:change="(e) => {this.onChangeFileUpload(e)}"
                   class="pt-8 w-full text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400" />
        </div>

        <div class="flex justify-end">
            <button class="px-4 py-3 rounded text-sm font-bold text-white bg-red-500 mr-2">Cancel</button>
            <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Add New Event</button>
        </div>
    </form>
</div>
</template>

<script>
import InputField from "../components/InputField";
import {mapActions} from "vuex";

export default {
    name: "EventsCreate",
    components:{
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
            errors: null
        }
    },
    methods: {
        ...mapActions(['createEvent']),
        onChangeFileUpload(e) {
            this.form.image = e.target.files[0];
        },
        submitForm: function () {
            let data = new FormData()
            this.form.image !== '' ? data.append('image', this.form.image) : ''
            data.append('amount', this.form.amount)
            data.append('date', this.form.date)
            data.append('beneficier', this.form.beneficier)
            data.append('description', this.form.description)
            data.append('name', this.form.name)
            data.append('privacy', this.form.privacy)

            this.createEvent(data).then(response => {
                console.log(response.data)
                this.$router.push(response.data.url)
            });
        }
    }

}
</script>

<style scoped>

</style>
