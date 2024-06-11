<template>
    <div ref="parent">

        <FullCalendar :key="key" :options="calendarOptions"/>
    </div>
</template>


<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'

export default {
    name: 'Pointageagents',
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    props: [
        'usersData',
    ],
    data() {
        return {

            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin, timeGridPlugin],
                initialView: 'dayGridMonth',
                events: [],
                // eventColor: this.customizeEventContent,
                eventOrder: ['title', '-date'],
                // eventContent: this.customizeEventContent,
                locale: "fr",
                selectable: "true",
                height: 500
            }

        }
    },
    mounted() {
        this.generateEvents()

    },
    methods: {

        generateEvents() {
            if (this.usersData && this.usersData.jour_presences) {
                const pointageDates = this.usersData.jour_presences;

                const progammeDates = this.usersData.Pointage2;
                const events = [];
                // Ajouter les événements à partir de pointageDates
                pointageDates.forEach(data => {
                    let backgroundColor = '#e31d3b';
                    let borderColor = '#e31d3b';

                    // Condition sur data.present pour définir les couleurs
                    if (data.present === 'oui') {
                        backgroundColor = '#28a745';
                        borderColor = '#28a745';
                    }
                    events.push(
                        {
                            title: '1- ' + data.libelle,
                            date: data.date_debut.split(' ')[0],
                            backgroundColor: backgroundColor, // override!
                            display: 'list-item',
                            borderColor: borderColor
                        },
                        {
                            title: '2- ' + data.faction,
                            date: data.date_debut.split(' ')[0],
                            backgroundColor: backgroundColor, // override!
                            display: 'list-item',
                            borderColor: borderColor
                        },
                        {
                            title: '',
                            date: data.date_debut.split(' ')[0],
                            textColor: 'white',
                            backgroundColor: backgroundColor, // override!
                            display: 'background',
                            borderColor: borderColor
                        }
                    );
                });

                // Ajouter les événements à partir de progammeDates
                // progammeDates.forEach(date => {
                //     let title = '';
                //     let eventDate = '';

                //     // Vérifier les conditions pour déterminer les valeurs de title et date
                //     if (!date.debut_realise && date.debut_prevu.split(' ')[1] != "00:00:00") {
                //         title = date.debut_prevu.split(' ')[1],
                //             eventDate = date.debut_prevu.split(' ')[0];
                //     }

                //     events.push({
                //         title: title,
                //         date: eventDate
                //     });
                // });


                // progammeDates.forEach(date => {
                //     let title = '';
                //     let eventDate = '';

                //     // Vérifier les conditions pour déterminer les valeurs de title et date
                //     if (!date.fin_realise && date.fin_prevu.split(' ')[1] != "23:59:00") {
                //         title = date.fin_prevu.split(' ')[1],
                //             eventDate = date.fin_prevu.split(' ')[0];
                //     }
                //     events.push({
                //         title: title,
                //         date: eventDate
                //     });
                // });


                this.calendarOptions.events = events;
            }
        },
        // customizeEventContent(arg) {
        //     let backgroundColor = 'blue';

        //     // Customize background color based on the title value
        //     if (arg.event.title === '23:59:00') {
        //         backgroundColor = 'red';
        //     } else {
        //         backgroundColor = 'green';
        //     }
        //     return {
        //         html: `<div style="background-color: ${backgroundColor}">${arg.event.title}</div>`,
        //     };
        // },
        customizeEventContent(arg) {
            let backgroundColor = 'red';
            console.log('this.usersData=>', this.usersData.jour_presences, this.usersData.jour_presences.present);

            // // Vérifier si l'événement provient de pointageDates
            // if (this.usersData && this.usersData.jour_presences.some(title => title.includes(arg.event.title))) {
            //     backgroundColor = 'green';
            // }

            // Vérifier si l'événement provient de progammeDates
            // if (this.usersData && this.usersData.Pointage2) {
            //     const progammeDates = this.usersData.Pointage2;
            //     const eventDate = arg.event.date.split(' ')[0];

            //     const isDebutPrevu = progammeDates.some(date => {
            //         return date.debut_prevu.split(' ')[0] === eventDate && !date.debut_realise && date.debut_prevu.split(' ')[1] !== '00:00:00';
            //     });

            //     const isFinPrevu = progammeDates.some(date => {
            //         return date.fin_prevu.split(' ')[0] === eventDate && !date.fin_realise && date.fin_prevu.split(' ')[1] !== '23:59:00';
            //     });

            //     if (isDebutPrevu || isFinPrevu) {
            //         backgroundColor = 'green';
            //     }
            // }

            return {
                html: `<div style="background-color: ${backgroundColor}; ">${arg.event.title}</div>`,
            };
        }


    }
}
</script>


