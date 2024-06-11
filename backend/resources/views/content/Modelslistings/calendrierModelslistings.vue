<!-- <template>
    <div>
        <v-calendar is-expanded :attributes="attributes" @dayclick="onDayClick"/>
    </div>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";

export default {
    name: 'CalendrierModelslistings',
    data() {
        return {
            days: [],
        };
    },
    computed: {
        dates() {
            return this.days.map(day => day.date);
        },
        attributes() {
            return this.dates.map(date => ({
                highlight: true,
                dates: date,
            }));
        },
    },
    methods: {
        onDayClick(day) {
            const idx = this.days.findIndex(d => d.id === day.id);
            if (idx >= 0) {
                this.days.splice(idx, 1);
            } else {
                this.days.push({
                    id: day.id,
                    date: day.date,
                });
            }
            let retour = this.days.map(data => data.id)
            this.$emit("selectDays", retour)
              console.log('date',retour)
        },
    },
};

</script> -->


<template>
    <div ref="parent">
        <FullCalendar :options="calendarOptions"/>
    </div>
</template>

<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

export default {
    name: 'Pointageagents',
    components: {
        FullCalendar
    },
    props: [
        'modellistingsData',
    ],
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                dateClick: this.handleDateClick,
                initialView: 'dayGridMonth',
                events: [],
                locale: "fr",
                selectable: true,
            },
            selectedDates: [] // Tableau pour stocker les dates sélectionnées
        }
    },
    mounted() {
        this.generateEvents();

    },
    methods: {

        handleDateClick(info) {
            const clickedDate = info.dateStr;


            // Vérifier si la date est déjà sélectionnée
            const index = this.selectedDates.indexOf(clickedDate);
            if (index > -1) {
                // Si la date est déjà sélectionnée, la supprimer du tableau
                this.selectedDates.splice(index, 1);
            } else {
                // Si la date n'est pas déjà sélectionnée, l'ajouter au tableau
                this.selectedDates.push(clickedDate);
            }

            // Mettre à jour les événements affichés dans le calendrier
            this.updateCalendarEvents();
            console.log('selectedDates', this.selectedDates)
            this.$emit("selectDays", this.selectedDates)
        },
        updateCalendarEvents() {
            // Réinitialiser les événements du calendrier
            this.calendarOptions.events = [];

            // Parcourir toutes les dates sélectionnées et ajouter des événements correspondants
            this.selectedDates.forEach(date => {
                this.calendarOptions.events.push({
                    title: 'Selectionner',
                    date: date
                });
            });
        },

        generateEvents() {

            const modellistingsDates = this.modellistingsData.date;
            const obj = JSON.parse(modellistingsDates);
            console.log('modellistingsDates', obj)
            this.selectedDates = obj;
            // const progammeDates = this.modellistingsData.Pointage2;
            const events = [];
            // Ajouter les événements à partir de modellistingsDates
            obj.forEach(date => {
                events.push({
                    title: 'Selectionner',
                    date: date.split(' ')[0]
                });
            });


            this.calendarOptions.events = events;
        },
    }
}
</script>


