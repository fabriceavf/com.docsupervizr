<template>
    <AdminLte>
        <template #breadcrumb_title>
            Liste des taches
        </template>
        <template #breadcrumb_pages>
            <li class="breadcrumb-item active">
                Taches
            </li>
        </template>
        <template #content>
            <DataTable :fields="fields" :url="url">
                <template #datatable_header_btns>
                    <div class="mr-2">
                        <data-modal :indice="'new-tache'" addClass="btn-primary " taille="md">
                            <template #modal_btn>
                                <i class="fa fa-plus"></i> Nouvelle tache
                            </template>
                            <template #modal_title>
                                Nouvelle tache
                            </template>
                            <template #modal_body>
                                <CreateTache :villes="villes"/>
                            </template>
                        </data-modal>
                    </div>
                </template>
                <template #datatable_btns="slotProps">
                    <data-modal :indice="'tache'+ slotProps.id" addClass="btn-outline-dark " taille="md">
                        <template #modal_btn>
                            <i class="fa-solid fa-pen-to-square "></i>
                        </template>
                        <template #modal_title>
                            Tache ID00{{ slotProps.id }}
                        </template>
                        <template #modal_body>
                            <EditTache :formLine="slotProps.data" :villes="villes"/>
                        </template>
                    </data-modal>
                </template>
            </DataTable>
        </template>
    </AdminLte>
</template>

<script>
import DataModal from '@/components/DataModal.vue'
import CreateTache from './CreateTache.vue'
import EditTache from './EditTache.vue'
import DataTable from '@/components/DataTable.vue'
import AdminLte from '@/components/AdminLte'

export default {
    name: 'TacheView',
    components: {AdminLte, DataModal, CreateTache, EditTache, DataTable},
    data() {
        return {
            url: '/api/taches?',
            table: 'taches',
            fields: [
                {
                    label: '',
                    key: 'id'
                },
                {
                    key: 'type',
                    label: 'Type'
                },
                {
                    key: 'libelle',
                    label: 'Libelle'
                },
                {
                    key: 'ville.libelle',
                    label: 'Ville'
                }
            ],
            villes: []
        }
    },
    mounted() {
        this.getVilles()
    },
    methods: {
        getVilles() {
            // this.$store.commit('setIsLoading', true)
            this.axios.get('/api/villes').then((response) => {
                this.villes = response.data
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
