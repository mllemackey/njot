<template>
    <div class="event-info">
        <div class="card relative shadow-md mb-6 bg-white break-words flex flex-col md:flex-row items-stretch p-0 md:p-5 rounded">
            <div class="w-full h-64 md:w-64 md:h-64 bg-cover bg-center mb-6 md:mb-0" :style="{ 'background-image': 'url(' + '/' + event.image  + ')'}">
            </div>
            <div class="flex flex-col md:flex-row flex-1 justify-evenly items-stretch xl:pl-16">
                <div class="w-full md:w-1/5 px-4 pb-3">
                    <p class="font-bold uppercase text-sm mb-1">Name</p>
                    <p class="capitalize text-sm">{{ event.id }}. {{ event.name }}</p>
                </div>
                <div class="w-full md:w-1/5 px-4 pb-3">
                    <p class="font-bold uppercase text-sm mb-1">Description</p>
                    <p v-if="event.description" class="capitalize text-sm">{{ event.description }}</p>
                    <p v-else class="text-gray-400">No description</p>
                </div>
                <div class="w-full md:w-1/5 px-4 pb-3">
                    <p class="font-bold uppercase text-sm mb-1">Beneficier</p>
                    <p class="capitalize text-sm">{{ event.beneficier }}</p>
                </div>
                <div class="w-full md:w-1/5 px-4 pb-3">
                    <p class="font-bold uppercase text-sm mb-1">Date</p>
                    <p class="text-sm">{{ event.date }}</p>
                </div>
                <div class="w-full md:w-1/5 px-4 pb-3">
                    <p class="font-bold uppercase text-sm mb-1">Amount</p>
                    <p class="text-sm">{{ event.amount }} RSD</p>
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
