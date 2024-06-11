<template>
  <AdminLte>
    <template #breadcrumb_title>
      Liste des enrolements
    </template>
    <template #breadcrumb_pages>
      <li class="breadcrumb-item active">
        Enrolements
      </li>
    </template>
    <template #content>
      <DataTable :fields="fields" :table="table" :url="url">
        <template #datatable_header_btns>
          <div class="mr-2">
            <data-modal id="btn" :indice="'new-enrolement'" addClass="btn-primary " taille="lg">
              <template #modal_btn>
                <i class="fa fa-plus"></i> Nouvel employé
              </template>
              <template #modal_title>
                Enroler un nouvel employé
              </template>
              <template #modal_body>
                <CreateEnrolement :fonctions="fonctions" :pays="pays" :table="table"/>
              </template>
            </data-modal>
          </div>
        </template>
        <template #datatable_btns="slotProps">
          <data-modal :indice="'enrolement'+ slotProps.id" addClass="btn-outline-dark " taille="lg">
            <template #modal_btn>
              <i class="fa-solid fa-pen-to-square "></i>
            </template>
            <template #modal_title>
              Enrolement ID00{{ slotProps.id }}
            </template>
            <template #modal_body>
              <EditEnrolement :fonctions="fonctions" :formLine="slotProps.data" :pays="pays" :table="table"/>
            </template>
          </data-modal>
        </template>
      </DataTable>
    </template>
  </AdminLte>
</template>

<script>
import DataModal from '@/components/DataModal.vue'
import DataTable from '@/components/DataTable.vue'
import CreateEnrolement from './CreateEnrolement.vue'
import EditEnrolement from './EditEnrolement.vue.vue'
import AdminLte from '@/components/AdminLte'
import moment from 'moment'

export default {
  name: 'EnrolementView',
  components: {AdminLte, DataModal, DataTable, CreateEnrolement, EditEnrolement},
  data() {
    return {
      url: '/api/users?filter[type]=employe&filter[actif]=0&',
      table: 'enrolements',
      fields: [
        {
          key: 'id',
          label: ''
        },
        {
          key: 'created_at',
          sortable: 'true',
          formatter: function (row) {
            return moment(String(new Date(row))).format('DD/MM/YYYY HH:mm')
          },
          label: 'Date d\'enrolement'
        },
        {
          key: 'matricule',
          sortable: 'true',
          title: 'Matricule'
        },
        {
          key: 'nom',
          sortable: 'true',
          label: 'Nom'
        },
        {
          key: 'prenom',
          sortable: 'true',
          label: 'Prenom'
        },
        {
          key: 'fonction.libelle',
          sortable: 'true',
          label: 'Fonction'
        },
        {
          key: 'fonction.service.libelle',
          sortable: 'true',
          label: 'Service'
        },
        {
          key: 'user.name',
          sortable: 'true',
          label: 'Enrolé par'
        }
      ],
      pays: [],
      fonctions: []
    }
  },
  mounted() {
    this.getContries()
    this.getFonctions()
  },
  methods: {
    getContries() {
      this.$store.state.isLoading = true
      this.axios.get('/api/nations').then((response) => {
        this.pays = response.data
        this.$store.state.isLoading = false
      }).catch(error => {
        console.log(error.response.data)
        this.$store.state.isLoading = false
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },
    getFonctions() {
      this.$store.state.isLoading = true
      this.axios.get('/api/fonctions').then((response) => {
        this.fonctions = response.data
        this.$store.state.isLoading = false
      }).catch(error => {
        console.log(error.response.data)
        this.$store.state.isLoading = false
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    }
  }
}
</script>
