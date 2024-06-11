<template>
  <AdminLte>
    <template #breadcrumb_title>
      Journal des pointages
    </template>
    <template #breadcrumb_pages>
      <li class="breadcrumb-item active">
        Pointages > Journal
      </li>
    </template>
    <template #content>
      <DataTable :fields="fields" :url="url">
        <template #datatable_btns="slotProps">
          <data-modal :indice="'pointage'+ slotProps.id" addClass="btn-outline-dark" taille="md">
            <template #modal_btn>
              <i class="fa-solid fa-pen-to-square "></i>
            </template>
            <template #modal_title>
              Pointage ID00{{ slotProps.id }}
            </template>
            <template #modal_body>

              <Pointage :identifiant="slotProps.data[0].id"/>
            </template>
          </data-modal>
        </template>
      </DataTable>
    </template>
  </AdminLte>
</template>

<script>
import DataModal from '@/components/DataModal.vue'
import EditerJournal from './EditerJournal.vue'
import DataTable from '@/components/DataTable.vue'
import AdminLte from '@/components/AdminLte'
import moment from 'moment'
import Pointage from "@/components/Pointage";


export default {
  name: 'ServiceView',
  components: {AdminLte, DataModal, EditerJournal, DataTable, Pointage},
  data() {
    return {
      url: '/api/pointages?sort=-debut_prevu&',
      fields: [
        {
          label: '',
          key: 'id'
        },
        {
          label: 'Matricule',
          sortable: 'true',
          key: 'user.matricule'
        },
        {
          key: 'user.nom',
          sortable: 'true',
          label: 'Nom'
        },
        {
          key: 'user.prenom',
          sortable: 'true',
          label: 'Prenom'
        },
        {
          key: 'debut_prevu',
          formatter: function (row, el, all) {
            console.log('voci la ligne', row, el, all)
            let periode = ""
            if (all.debut_prevu && all.fin_prevu) {
              periode = '' + moment(String(all.debut_prevu)).format('DD/MM/YYYY HH:mm') + " a " + moment(String(all.fin_prevu)).format('DD/MM/YYYY HH:mm')
            }
            return periode
          },
          label: 'Programme'
        },
        {
          key: 'debut_realise',
          sortable: 'true',
          formatter: function (row) {
            if (row) return moment(String(row)).format('DD/MM/YYYY HH:mm')
          },
          label: 'Debut'
        },
        {
          key: 'fin_realise',
          sortable: 'true',
          formatter: function (row) {
            if (row) return moment(String(row)).format('DD/MM/YYYY HH:mm')
          },
          label: 'Fin'
        },
        {
          key: 'programme.programmation.tache.libelle',
          sortable: 'true',
          label: 'Tache'
        },
        {
          key: 'user.fonction.service.libelle',
          sortable: 'true',
          label: 'Service'
        },
        {
          key: 'pointeuse',
          sortable: 'true',
          label: 'Pointeuse'
        }
      ]
    }
  }
}
</script>
