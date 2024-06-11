<template>
    <AdminLte>
        <template #breadcrumb_title>
            Plannification des abscences
        </template>
        <template #breadcrumb_pages>
            <li class="breadcrumb-item active">
                abscences
            </li>
        </template>
        <template #content>
            <DataTable :fields="fields" :table="table" :url="url">
                <template #datatable_header_btns>
                    <div class="mr-2">
                        <data-modal :indice="'new-abscence'" addClass="btn-primary " taille="md">
                            <template #modal_btn>
                                <i class="fa fa-plus"></i> Nouvelle plannification
                            </template>
                            <template #modal_title>
                                Plannifier des abscences
                            </template>
                            <template #modal_body>
                                <CreateAbscence :employes="employes" :table="table"/>
                            </template>
                        </data-modal>
                    </div>
                </template>
                <template #datatable_btns="slotProps">
                    <data-modal :indice="'abscence'+ slotProps.id" addClass="btn-outline-dark mr-2" taille="md">
                        <template #modal_btn>
                            <i class="fa-solid fa-pen-to-square "></i>
                        </template>
                        <template #modal_title>
                            abscence ID00{{ slotProps.id }}
                        </template>
                        <template #modal_body>
                            <EditAbscence :employes="employes" :formLine="slotProps.data" :table="table"/>
                        </template>
                    </data-modal>
                </template>
                <template #datatable_statut="slotProps">
          <span v-if="slotProps.statut == ''" class="badge badge-danger">
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
import AdminLte from '@/components/AdminLte'
import DataTable from '@/components/DataTable.vue'
import CreateAbscence from './CreateAbscence.vue'
import EditAbscence from './EditAbscence.vue'
import DataModal from '@/components/DataModal.vue'
import moment from 'moment'

export default {
    name: 'abscenceView',
    components: {AdminLte, DataTable, CreateAbscence, EditAbscence, DataModal},
    data() {
        return {
            url: '/api/abscences?',
            table: 'abscences',
            employes: [],
            fields: [
                {
                    key: 'id',
                    label: ''
                },
                {
                    key: 'user.name',
                    sortable: true,
                    label: 'Employé'
                },
                {
                    key: 'solder',
                    sortable: true,
                    label: 'Avec ou sans solde'
                },
                {
                    key: 'debut',
                    sortable: true,
                    formatter: function (row) {
                        return moment(String(new Date(row))).format('DD/MM/YYYY ')
                    },
                    label: 'Depart'
                },
                {
                    key: 'fin',
                    sortable: true,
                    formatter: function (row) {
                        return moment(String(new Date(row))).format('DD/MM/YYYY ')
                    },
                    label: 'Retour'
                }
            ]
        }
    },
    mounted() {
        this.getEmployes()
    },
    methods: {
        getEmployes() {
            // this.$store.commit('setIsLoading', true)
            this.axios.get('/api/employes?sort=-nom').then((response) => {
                this.employes = response.data
                // this.$store.commit('setIsLoading', false)
            }).catch(error => {
                console.log(error.response.data)
                // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        }
    }
}
</script>
