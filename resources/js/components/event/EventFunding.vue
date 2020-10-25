<template>
    <div class="card w-full">
        <h2 class="text-2xl bold mb-3">Funding</h2>
        <div class="w-full">
            <div class="progress-wrapper shadow bg-gray-200 w-full">
                <div class="progress text-xs mb-3 leading-none" :style="'width:' + funded + '%'">
                    <div class="text-center text-sm text-white py-3">{{ funded }}%</div>
                </div>
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
