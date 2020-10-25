<template>
    <div class="event-info">
        <div class="card flex flex-rows items-stretch">
            <div class="w-64 h-64 bg-cover" :style="{ 'background-image': 'url(' + '/' + event.image  + ')'}">
            </div>
            <div class="flex flex-row flex-1 justify-evenly items-stretch xl:pl-16">
                <div class="w-1/5 px-4">
                    <p class="font-bold uppercase text-sm mb-1">Name</p>
                    <p class="capitalize text-sm">{{ event.id }}. {{ event.name }}</p>
                </div>
                <div class="w-1/5 px-4">
                    <p class="font-bold uppercase text-sm mb-1">Description</p>
                    <p v-if="event.description" class="capitalize text-sm">{{ event.description }}</p>
                    <p v-else class="text-gray-400">No description</p>
                </div>
                <div class="w-1/5 px-4">
                    <p class="font-bold uppercase text-sm mb-1">Beneficier</p>
                    <p class="capitalize text-sm">{{ event.beneficier }}</p>
                </div>
                <div class="w-1/5 px-4">
                    <p class="font-bold uppercase text-sm mb-1">Date</p>
                    <p class="text-sm">{{ event.date }}</p>
                </div>
                <div class="w-1/5 px-4">
                    <p class="font-bold uppercase text-sm mb-1">Amount</p>
                    <p class="text-sm">{{ event.amount }}</p>
                </div>
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
