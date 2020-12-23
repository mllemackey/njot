<template>
    <div class="card relative shadow-md mb-6 bg-white break-words p-4 md:p-5 rounded w-full">
        <h2 class="text-2xl bold mb-3">Funding</h2>
        <div class="w-full mb-6">
            <div class="progress-wrapper shadow bg-gray-200 w-full">
                <div class="progress text-xs leading-none" :style="'width:' + funded + '%'">
                    <div class="text-center text-sm text-white py-3">{{ funded }}%</div>
                </div>
            </div>
        </div>
        <div v-if="bankAccount"
            class="flex flex-col justify-center items-center pt-3">
            <h3 class="text-lg text-blue-600">Fund Account</h3>
            <button
                :title="tooltip"
                class="cursor-pointer text-xl hover:text-blue-600"
                v-clipboard:copy="bankAccount"
                v-clipboard:success="onCopy"
                v-clipboard:error="onError"
            >
                {{ bankAccount }} <font-awesome-icon icon="copy" class="text-blue-600" />
            </button>
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
    data: function () {
        return {
            tooltip: 'Click to copy',
        }
    },
    computed: {
        ...mapGetters(['eventUsers', 'eventUsersFunded']),
        funded(){
            if(this.eventUsersFunded.length === 0 || this.eventUsers.length === 0) {
                return 0
            }
            return ((this.eventUsersFunded.length * 100) / this.eventUsers.length).toFixed(1)
        },
        bankAccount(){
            if(!this.event || !this.event.admin || !this.event.admin.bank_account)
                return ''
            return this.event.admin.bank_account
        }
    },
    methods: {
        onCopy: function (e) {
            this.tooltip =  e.text + " copied!"
        },
        onError: function (e) {
            alert('Failed to copy bank account number')
        }
    }
}
</script>

<style scoped>

</style>
