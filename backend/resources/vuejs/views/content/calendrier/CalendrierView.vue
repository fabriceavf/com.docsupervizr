<template>
  <AdminLte>
    <template #breadcrumb_title>
      Plannification des jours feries
    </template>
    <template #breadcrumb_pages>
      <li class="breadcrumb-item active">
        Jours feries
      </li>
    </template>
    <template #content>
      <div class="d-flex justify-content-center">
        <div class="mr-2">
          <data-modal :indice="'new-Joursferie'" addClass="btn-outline-primary " taille="xl">
            <template #modal_btn>
              <i class="fa fa-plus"></i> Jours feriés
            </template>
            <template #modal_title>
              Jours feriés
            </template>
            <template #modal_body>
              <CreateJoursferie/>
            </template>
          </data-modal>
        </div>
        <div class="mr-2">
          <data-modal addClass="btn-outline-primary " indice="new-absence" taille="xl">
            <template #modal_btn>
              <i class="fa fa-plus"></i> Absences
            </template>
            <template #modal_title>
              Absences prévenus
            </template>
            <template #modal_body>
              <CreateAbsence/>
            </template>
          </data-modal>
        </div>
        <div class="mr-2">
          <data-modal addClass="btn-outline-primary " indice="new-conge" taille="xl">
            <template #modal_btn>
              <i class="fa fa-plus"></i> Congés
            </template>
            <template #modal_title>
              Plannification des congés
            </template>
            <template #modal_body>
              <CreateConge/>
            </template>
          </data-modal>
        </div>
      </div>
      <div class="">
        <FullCalendar v-show="!showCalendrier" :key="key" :options="calendarOptions">
          <template v-slot:eventContent='arg'>
            <i>{{ arg.event.title }}</i>
          </template>
        </FullCalendar>
      </div>

    </template>
  </AdminLte>

</template>

<script>
import AdminLte from '@/components/AdminLte'
import DataTable from '@/components/DataTable.vue'
import CreateJoursferie from './jours/CreateJoursferie'
import CreateConge from './conges/CreateConge'
import CreateAbsence from './absences/CreateAbsence'
import DataModal from '@/components/DataModal.vue'

// import FullCalendar from '@fullcalendar/vue'
// import dayGridPlugin from '@fullcalendar/daygrid'
// // import timeGridPlugin from '@fullcalendar/timegrid'
// import interactionPlugin from '@fullcalendar/interaction'
// import $ from "jquery";

export default {
  name: 'JoursferieView',
  components: {AdminLte, DataTable, CreateJoursferie, CreateConge, CreateAbsence, DataModal},
  data() {
    return {
      key: 0,
      url: '/api/joursferies?',
      isLoading: false,
      showCalendrier: false,
      joursferies: [],
      absences: [],
      conges: [],
      fields: [
        {
          key: 'id',
          label: ''
        },
        {
          key: 'debut',
          sortable: true,
          label: 'Debut'
        },
        {
          key: 'fin',
          sortable: true,
          label: 'Fin'
        }
      ],
      calendarOptions: {
        plugins: [
          dayGridPlugin,
          interactionPlugin // needed for dateClick
        ],
        initialView: 'dayGridMonth',
        // initialEvents:  this.getJoursFeries,
        events: [
          {title: 'test 11', start: '2023-01-15', end: '2023-01-16'},
          {title: 'test 22', start: '2023-01-16', end: '2023-01-17'}
        ]
      }
    }
  },
  mounted() {
    this.getJoursFeries()
    this.getConges()
    this.getAbsences()
  },
  methods: {
    getJoursFeries() {
      let initialEvents = this.calendarOptions.events
      this.$store.state.isLoading = true;
      this.axios.get('/api/joursferies').then((response) => {
        this.joursferies = response.data
        for (let index = 0; index < response.data.length; index++) {
          const event = response.data[index];

          this.calendarOptions.events[index] = {
            title: event.raison,
            start: event.debut,
            end: event.fin
          }
        }
        this.calendarOptions.events = initialEvents.concat(this.calendarOptions.events)
        this.key++
        console.log(this.calendarOptions.events)
        this.$store.state.isLoading = false
      }).catch(error => {
        console.log(error)
        this.$store.state.isLoading = false
      })
    },
    getConges() {
      let initialEvents = this.calendarOptions.events
      this.$store.state.isLoading = true;
      this.axios.get('/api/conges').then((response) => {
        this.conges = response.data


        for (let index = 0; index < response.data.length; index++) {
          const event = response.data[index];

          this.calendarOptions.events[index] = {
            title: "congé de: " + event.user.name,
            start: event.debut,
            end: event.fin,
            eventBackgroundColor: "#fff"
          }
        }
        this.calendarOptions.events = initialEvents.concat(this.calendarOptions.events)
        this.key++
        console.log(this.calendarOptions.events)
        this.$store.state.isLoading = false
      }).catch(error => {
        console.log(error)
        this.$store.state.isLoading = false
      })
    },
    getAbsences() {
      let initialEvents = this.calendarOptions.events

      this.$store.state.isLoading = true;
      this.axios.get('/api/abscences').then((response) => {
        this.absences = response.data
        for (let index = 0; index < response.data.length; index++) {
          const event = response.data[index];

          this.calendarOptions.events[index] = {
            title: "Absence prévenu de: " + event.user.name,
            start: event.debut,
            end: event.fin
          }
        }
        this.calendarOptions.events = initialEvents.concat(this.calendarOptions.events)
        this.key++
        console.log(this.calendarOptions.events)
        this.$store.state.isLoading = false
      }).catch(error => {
        console.log(error)
        this.$store.state.isLoading = false
      })
    },
    getCalendarEvents() {
      let myevents = {};

      for (let index = 0; index < this.joursferies.length; index++) {
        const event = this.joursferies[index];

        myevents[index] = {
          id: index,
          title: event.raison,
          start: event.debut,
          end: event.fin
        }
      }


      this.calendarOptions.events = myevents
    }
  }
}
</script>
