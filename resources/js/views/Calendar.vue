<template>
<div class="flex flex-col flex-grow">
    <calendar-view
        :show-date="showDate"
        :items="items"
        itemTop="2.4em"
        @click-item="onClickItem"
    >
        <calendar-view-header
            slot="header"
            slot-scope="t"
            :header-props="t.headerProps"
            @input="setShowDate" />
    </calendar-view>
</div>
</template>

<script>
import { CalendarView, CalendarViewHeader } from "vue-simple-calendar"
import {mapGetters} from "vuex";

export default {
    name: "Calendar",
    components: {
        CalendarView,
        CalendarViewHeader,
    },
    data: function() {
        return {
            showDate: new Date()
        }
    },
    computed: {
        ...mapGetters(['userEvents', 'administratedEvents']),
        items(){
            return this.userEvents.concat(this.administratedEvents);
        }
    },
    methods: {
        setShowDate(d) {
            this.showDate = d;
        },
        onClickItem(e) {
            this.$router.push(e.originalItem.url)
        },
    }


}
</script>

<style>

.cv-day{
    padding: 10px;
}
.cv-week {
    min-height: 100px;
}

.cv-day.today{
    background: #2b6cb0;
    color: white;
}
.cv-item.hasUrl.isHovered{
    cursor: pointer;
    background-color: #2b6cb0;
    color: white;
}
</style>
