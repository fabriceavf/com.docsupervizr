<template>
  <AdminLte>
    <template #breadcrumb_title>
      Liste du personnel
    </template>
    <template #breadcrumb_pages>
      <li class="breadcrumb-item active">
        Personnel
      </li>
    </template>
    <template #content>
      <DataTable :fields="fields" :table="table" :url="url">
        <template #datatable_btns="slotProps">
          <data-modal :indice="'enrolement'+ slotProps.id" addClass="btn-outline-dark " taille="lg">
            <template #modal_btn>
              <i class="fa-solid fa-pen-to-square "></i>
            </template>
            <template #modal_title>
              Employe ID00{{ slotProps.id }}
            </template>
            <template #modal_body>
              <EditEmploye :fonctions="fonctions" :formLine="slotProps.data" :pays="pays" :table="table"/>
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
import EditEmploye from './EditEnrolement.vue.vue'
import AdminLte from '@/components/AdminLte'
import moment from 'moment'

export default {
  name: 'EnrolementView',
  components: {AdminLte, DataModal, EditEmploye, DataTable},
  data() {
    return {
      url: '/api/users?filter[type]=employe&filter[actif]=1&',
      table: 'employes',
      fields: [
        {
          key: 'id',
          label: ''
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
        },
        {
          key: 'created_at',
          sortable: 'true',
          formatter: function (row) {
            return moment(String(new Date(row))).format('DD/MM/YYYY HH:mm')
          },
          label: 'Date d\'enrolement'
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
      this.isLoading = true
      this.axios.get('/api/nations').then((response) => {
        this.pays = response.data
        this.isLoading = false
      }).catch(error => {
        console.log(error.response.data)
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },
    getFonctions() {
      this.isLoading = true
      this.axios.get('/api/fonctions').then((response) => {
        this.fonctions = response.data
        this.isLoading = false
      }).catch(error => {
        console.log(error.response.data)
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    }
  }
}
</script>
