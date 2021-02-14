<template>
    <div class="event-info">
        <div class="card relative shadow-md mb-6 bg-white break-words flex flex-col md:flex-row items-stretch p-0 md:p-5 rounded hover:bg-blue-100"
        :class="{'border border-blue-500': administrated}">
            <span v-if="administrated" class="absolute right-0 p-3 text-white bottom-0 m-3 bg-blue-500">admin</span>
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
    computed: {
        administrated(){
            if(this.event && this.event.can)
                return this.event.can.update
            return false
        }
    }
}
</script>

<style scoped>

</style>
