<template>
    <AdminLte>
        <template #breadcrumb_title>
            Ventilations
        </template>
        <template #breadcrumb_pages>
            <li class="breadcrumb-item active">
                Ventilations
            </li>
        </template>
        <template #content>
            <DataTable :fields="fields" :url="url">
                <template #datatable_btns="slotProps">
                    <data-modal :indice="'ventilation'+ slotProps.id" addClass="btn-outline-dark" taille="md">
                        <template #modal_btn>
                            <i class="fa-solid fa-pen-to-square "></i>
                        </template>
                        <template #modal_title>
                            Ventilation ID00{{ slotProps.id }}
                        </template>
                        <template #modal_body>
                            <ShowVentilation :data="slotProps.data"/>
                        </template>
                    </data-modal>
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
        </template>
    </AdminLte>
</template>

<script>
import DataModal from '@/components/DataModal.vue'
import ShowVentilation from './ShowVentilation'
import DataTable from '@/components/DataTable.vue'
import AdminLte from '@/components/AdminLte'

export default {
    name: 'VentilationView',
    components: {AdminLte, DataModal, ShowVentilation, DataTable},
    data() {
        return {
            url: '/api/ventilations?',
            fields: [
                {
                    key: 'id',
                    label: ''
                },
                {
                    key: 'semaine',
                    sortable: 'true',
                    label: 'Semaine'
                },
                {
                    key: 'user.matricule',
                    sortable: 'true',
                    label: 'Matricule'
                },
                {
                    key: 'user.name',
                    sortable: 'true',
                    label: 'Employe'
                },
                {
                    key: 'programmation.tache.libelle',
                    sortable: 'true',
                    label: 'Tache'
                },
                {
                    key: 'total_programmer',
                    formatter: 'formatHeure',
                    label: 'T HP'
                },
                {
                    key: 'total_colecter',
                    formatter: 'formatHeure',
                    label: 'T HC'
                },
                {
                    key: 'total_depassement',
                    formatter: 'formatHeure',
                    label: 'T HS'
                },
                {
                    key: 'statut',
                    formatter: 'returnStatut',
                    label: 'Statut'
                }
            ]
        }
    }
}
</script>
