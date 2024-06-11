<template>
  <AdminLte>
    <template #breadcrumb_title>
      Les ventilations
    </template>
    <template #breadcrumb_pages>
      <li class="breadcrumb-item active">
        ventilations
      </li>
    </template>
    <template #content>
      <div class="row">
        <div class="col-sm-12">
          <DataTable :fields="fields" :table="table" :url="url">
            <template #datatable_header_btns>
              <div class="mr-2">
                <data-modal :indice="'new-ventilation'" addClass="btn-primary " taille="lg">
                  <template #modal_btn>
                    <i class="fa fa-plus"></i> Telecharger la matrice
                  </template>
                  <template #modal_title>
                    Telecharger la matrice
                  </template>
                  <template #modal_body>
                    <Creatematrices/>
                  </template>
                </data-modal>
              </div>
            </template>
            <template #datatable_btns="slotProps">
              <div class="d-flex">
                <data-modal :indice="'ventilation'+ slotProps.id" addClass="btn-outline-dark mr-2" newClass="test1"
                            taille="xl">
                  <template #modal_btn>
                    <i class="fa-solid fa-pen-to-square "></i>
                  </template>
                  <template #modal_title>
                    ventilation ID00{{ slotProps.id }}
                  </template>
                  <template #modal_body>
                    <Editventilation :data="slotProps.data" :table="table"/>
                  </template>
                </data-modal>
              </div>
            </template>
            <template #datatable_statut="slotProps">
          <span v-if="slotProps.statut == 'En attente'" class="badge badge-danger">
            <i class="fa fa-close"></i> En attente...
          </span>
              <span v-else-if="slotProps.statut == 'Terminé'" class="badge badge-success">
            <i class="fa fa-check"></i> Terminé
          </span>
              <span v-else-if="slotProps.statut == 'En cours'" class="badge badge-secondary">
            <i class="fa fa-chevron-right"></i> En cours...
          </span>
            </template>
          </DataTable>
        </div>

      </div>
    </template>
  </AdminLte>
</template>

<script>
import AdminLte from '@/components/AdminLte'
import DataModal from '@/components/DataModal.vue'
import Editventilation from './EditVentilation.vue'
import Copyventilation from './CopyVentilation'
import Createventilation from './CreateVentilation.vue'
import DataTable from '@/components/DataTable.vue'
import moment from 'moment'
import Pointage from "@/components/Pointage";
import Creatematrices from "@/views/matrices/CreateMatrices.vue";

export default {
  name: 'ventilationView',
  components: {
    Creatematrices,
    AdminLte,
    DataModal,
    Editventilation,
    Createventilation,
    Copyventilation,
    DataTable,
    Pointage
  },
  data() {
    return {
      url: '/api/programmationsActionGetVentilations&sort=+semaine&',
    //   url: '/api/programmations/action?action=getVentilations&sort=+semaine&',
      table: 'ventilations',
      employes: [],
      fields: [
        {
          key: 'id',
          label: ''
        },
        {
          key: 'semaine',
          formatter: function (week) {
            let date1 = moment(`${week}`);
            // console.log('week',week,date1)
            let dimanche = moment(`${week}`).subtract(1, 'days')
            let samedi = moment(`${week}`).add(5, 'days')
            return `${dimanche.format('DD-MM-YYYY')} au ${samedi.format('DD-MM-YYYY')}`
          },
          sortable: true,
          label: 'Semaine'
        },
        {
          key: 'tache.libelle',
          sortable: true,
          label: 'Tache'
        },
        {
          key: 'taux',
          sortable: true,
          formatter: function (row, label, all) {
            let traiter = parseInt(all.nbrs_tout_pointages) - parseInt(all.nbrs_pointage_non_traiter)
            let taux = traiter * 100 / all.nbrs_tout_pointages
            return ` ${parseFloat(taux).toFixed(0)} % ( ${all.nbrs_tout_pointages - all.nbrs_pointage_non_traiter}/${all.nbrs_tout_pointages} )`
          },
        },
        // {
        //   key: 'created_at',
        //   formatter: function (row) {
        //     if (row) return moment(String(row)).format('DD/MM/YYYY HH:mm')
        //   },
        //   label: 'Créé le'
        // },
        // {
        //   key: 'user.name',
        //   label: 'Ajouté par'
        // }
      ]
    }
  },
  methods: {

    getWeekHumans(week) {
      alert('la fonctyion eest appeler')

    },
  }
}
</script>
