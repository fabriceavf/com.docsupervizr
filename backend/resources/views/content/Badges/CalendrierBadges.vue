<template>
    <FullCalendar :options="calendarOptions"/>
</template>


<script>
import '@fullcalendar/core/vdom'

import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

export default {
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: 'dayGridMonth',
                // dateClick: this.handleSelect,
                events: [
                    {title: ' 1', date: '2023-05-10'},
                    {title: ' 2', date: '2023-05-11'},
                ],
                locale: "fr",
                selectable: "true"
            }
        }
    },
    methods: {
        //     handleDateClick: function (arg) {
        //         alert('date click! ' + arg.dateStr)
        //     },
        //     handleSelect(arg) {
        //         console.log(arg)
        //         this.calendarOptions.events = [
        //         this.calendarOptions.events,
        //     { title: 'Another Event', date: '2023-05-15' }
        //   ];
        //     },
    }
}
</script>
