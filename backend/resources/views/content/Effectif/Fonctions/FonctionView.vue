<template>
    <AdminLte>
        <template #breadcrumb_title>
            Les fonctions
        </template>
        <template #breadcrumb_pages>
            <li class="breadcrumb-item active">
                Effectif > fonctions
            </li>
        </template>
        <template #content>
            <DataTable :fields="fields" :table="table" :url="url">
                <template #datatable_header_btns>
                    <div class="mr-2">
                        <data-modal :indice="'new-fonction'" addClass="btn-primary " taille="sm">
                            <template #modal_btn>
                                <i class="fa fa-plus"></i> Nouvelle fonction
                            </template>
                            <template #modal_title>
                                Nouvelle fonction
                            </template>
                            <template #modal_body>
                                <CreateFonction :services="services" :table="table"/>
                            </template>
                        </data-modal>
                    </div>
                </template>
                <template #datatable_btns="slotProps">
                    <data-modal :indice="'fonction'+ slotProps.id" addClass="btn-outline-dark " taille="sm">
                        <template #modal_btn>
                            <i class="fa-solid fa-pen-to-square "></i>
                        </template>
                        <template #modal_title>
                            Fonction ID00{{ slotProps.id }}
                        </template>
                        <template #modal_body>
                            <EditFonction :formLine="slotProps.data" :services="services" :table="table"/>
                        </template>
                    </data-modal>
                </template>
            </DataTable>
        </template>
    </AdminLte>
</template>

<script>
import DataModal from '@/components/DataModal.vue'
import EditFonction from './EditFonction.vue'
import CreateFonction from './CreateFonction.vue'
import DataTable from '@/components/DataTable.vue'
import AdminLte from '@/components/AdminLte'

export default {
    name: 'FonctionView',
    components: {AdminLte, DataModal, CreateFonction, DataTable, EditFonction},
    data() {
        return {
            url: '/api/fonctions?',
            table: 'fonctions',
            services: [],
            employes: [],
            fields: [
                {
                    key: 'id',
                    label: ''
                },
                {
                    key: 'code',
                    sortable: 'true',
                    label: 'Code'
                },
                {
                    key: 'libelle',
                    sortable: 'true',
                    label: 'Libelle'
                },
                {
                    key: 'service.libelle',
                    sortable: 'true',
                    label: 'Service'
                },
                {
                    key: 'getEmployesNumber',
                    formatter: function (value, key, item) {
                        // return this.employes.filter(line => line.fonction_id === item.id).length
                        return 0
                    },
                    label: 'Qté Employes'
                },
                {
                    key: 'getEmployesHommeNumber',
                    formatter: function (value, key, item) {
                        // return this.employes.filter(line => line.fonction_id === item.id).length
                        return 0
                    },
                    label: 'Qté Homme'
                },
                {
                    key: 'getEmployesFemmeNumber',
                    formatter: function (value, key, item) {
                        // return this.employes.filter(line => line.fonction_id === item.id).length
                        return 0
                    },
                    label: 'Qté Femme'
                }
            ]
        }
    },
    mounted() {
        this.getServices()
        this.getEmployes()
    },
    methods: {
        getServices() {
            // this.$store.commit('setIsLoading', true)
            this.axios.get('/api/services').then((response) => {
                this.services = response.data
                // // this.$store.commit('setIsLoading', false)
            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        getEmployes() {
            // this.$store.commit('setIsLoading', true)
            this.axios.get('/api/users?filter[type]=employe&filter[actif]=1').then((response) => {
                this.employes = response.data
                // // this.$store.commit('setIsLoading', false)
            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        }
    }
}
</script>
