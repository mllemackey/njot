<template>
    <div class="event-info flex flex-rows items-center p-6 hd:w-48 text-base text-grey mr-2 my-6 shadow-lg bg-white rounded">
        <div class="w-32 h-32 bg-cover" :style="{ 'background-image': 'url(' + '/' + event.image  + ')'}">
        </div>
        <div class="flex flex-row flex-1 justify-evenly items-center xl:pl-16">
            <div class="w-1/5 px-4">
                <p class="font-bold uppercase text-sm">Name</p>
                <p class="capitalize">{{ event.event_id }}.{{ event.name }}</p>
            </div>
            <div class="w-1/5 px-4">
                    <p class="font-bold uppercase text-sm">Description</p>
                    <p v-if="event.description" class="capitalize">{{ event.description }}</p>
                    <p v-else class="text-gray-400">No description</p>
            </div>
            <div class="w-1/5 px-4">
                <p class="font-bold uppercase text-sm">Beneficier</p>
                <p class="capitalize">{{ event.beneficier }}</p>
            </div>
            <div class="w-1/5 px-4">
                <p class="font-bold uppercase text-sm">Date</p>
                <p>{{ event.date }}</p>
            </div>
            <div class="w-1/5 px-4">
                <p class="font-bold uppercase text-sm">Amount</p>
                <p>{{ event.amount }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import InputField from "../InputField";

export default {
    name: "EventInfo",
    components: {
        InputField
    },
    props: [
        'event'
    ],
    mounted() {

    }
}
</script>

<style scoped>

</style>
