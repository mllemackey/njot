<template>
    <div class="card w-full">
        <h2 class="text-2xl bold mb-3">Funding</h2>
        <div class="w-full">
            <div class="shadow w-full bg-grey-light">
                <div class="bg-blue-600 text-xs leading-none py-1" :style="'width:' + funded + '%'"></div>
                <p class="text-center text-red-500">{{ funded }}%</p>
            </div>
        </div>
        <div>
            <h3 class="text-xl">Fund Account</h3>
            <a title="Click to copy" class="cursor-pointer" @click="copy">{{ event.admin.bank_account }}</a>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "EventFunding",
    props: [
        'event'
    ],
    computed: {
        ...mapGetters(['eventUsers', 'eventUsersFunded']),
        funded(){
                return (this.eventUsersFunded.length * 100) / this.eventUsers.length
        }
    },
    methods: {
        copy(){

        }
    }
}
</script>

<style scoped>

</style>
