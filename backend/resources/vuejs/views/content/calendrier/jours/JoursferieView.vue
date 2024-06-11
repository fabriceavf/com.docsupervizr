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
      <div class="d-flex justify-centent-center">
        <div class="mr-2">
          <data-modal :indice="'new-Joursferie'" addClass="btn-outline-primary " taille="md">
            <template #modal_btn>
              <i class="fa fa-plus"></i> Jour ferié
            </template>
            <template #modal_title>
              Nouveau jour ferié
            </template>
            <template #modal_body>
              <CreateJoursferie :employes="employes"/>
            </template>
          </data-modal>
        </div>
        <div class="mr-2">
          <data-modal :indice="'new-Joursferie'" addClass="btn-outline-primary " taille="md">
            <template #modal_btn>
              <i class="fa fa-plus"></i> Absences
            </template>
            <template #modal_title>
              Absences prévenus
            </template>
            <template #modal_body>
              <CreateJoursferie :employes="employes"/>
            </template>
          </data-modal>
        </div>
        <div class="mr-2">
          <data-modal :indice="'new-Joursferie'" addClass="btn-outline-primary " taille="md">
            <template #modal_btn>
              <i class="fa fa-plus"></i> Congés
            </template>
            <template #modal_title>
              Plannification des congés
            </template>
            <template #modal_body>
              <CreateJoursferie :employes="employes"/>
            </template>
          </data-modal>
        </div>
      </div>
      <div class="">
        <FullCalendar v-show="!showCalendrier" :options="calendarOptions"/>
      </div>

    </template>
  </AdminLte>

</template>

<script>
import AdminLte from '@/components/AdminLte'
import DataTable from '@/components/DataTable.vue'
import CreateJoursferie from './CreateJoursferie.vue'
import EditJoursferie from './EditJoursferie.vue'
// import Calendrier from './CalendrierView'
import DataModal from '@/components/DataModal.vue'

import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import $ from "jquery";

export default {
  name: 'JoursferieView',
  components: {AdminLte, DataTable, CreateJoursferie, EditJoursferie, DataModal, FullCalendar},
  data() {
    return {
      url: '/api/joursferies?',
      showCalendrier: false,
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
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        events: [
          {title: 'Noel', start: '2022-12-24', end: '2022-12-25'},
        ]
      }
    }
  },
  mounted() {
    // this.getEmployes()
  },
  methods: {
    toggleCalendrier() {
      this.showCalendrier = !this.showCalendrier
    },
    getJoursFeries() {
      this.axios.post('/api/joursferies', this.form).then(response => {
        this.isLoading = false
        this.restForm()
        $('#new-Joursferie').modal('hide')
        $('#refresh').click()
      }).catch(error => {
        console.log(error.response.data)
        this.isLoading = false
      })

    }
  }
}
</script>
