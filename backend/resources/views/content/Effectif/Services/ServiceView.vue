<template>
    <AdminLte>
        <template #breadcrumb_title>
            Les services
        </template>
        <template #breadcrumb_pages>
            <li class="breadcrumb-item active">
                Effectif > Services
            </li>
        </template>
        <template #content>
            <DataTable :fields="fields" :table="table" :url="url">
                <template #datatable_header_btns>
                    <div class="mr-2">
                        <data-modal :indice="'new-service'" addClass="btn-primary " taille="sm">
                            <template #modal_btn>
                                <i class="fa fa-plus"></i> Nouveau service
                            </template>
                            <template #modal_title>
                                Nouveau service
                            </template>
                            <template #modal_body>
                                <CreateService :table="table"/>
                            </template>
                        </data-modal>
                    </div>
                </template>
                <template #datatable_btns="slotProps">
                    <data-modal :indice="'service'+ slotProps.id" addClass="btn-outline-dark " taille="sm">
                        <template #modal_btn>
                            <i class="fa-solid fa-pen-to-square "></i>
                        </template>
                        <template #modal_title>
                            Service ID00{{ slotProps.id }}
                        </template>
                        <template #modal_body>
                            <EditService :formLine="slotProps.data" :table="table"/>
                        </template>
                    </data-modal>
                </template>
            </DataTable>
        </template>
    </AdminLte>
</template>

<script>
import DataModal from '@/components/DataModal.vue'
import CreateService from './CreateService.vue'
import EditService from './EditService.vue'
import DataTable from '@/components/DataTable.vue'
import AdminLte from '@/components/AdminLte'

export default {
    name: 'ServiceView',
    components: {AdminLte, DataModal, CreateService, DataTable, EditService},
    data() {
        return {
            url: '/api/services?',
            table: 'services',
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
                    key: 'getFonctionsNumber',
                    formatter: 'getFonctionsNumber',
                    label: 'NB Fonctions'
                },
                {
                    key: 'getEmployesNumber',
                    formatter: 'getEmployesNumber',
                    label: 'NB Employes'
                }
            ]
        }
    }
}
</script>
