<template>
    <AdminLte>
        <template #breadcrumb_title>
            Absences
        </template>
        <template #breadcrumb_pages>
            <li class="breadcrumb-item active">
                Pointages > Absences
            </li>
        </template>
        <template #content>
            <DataTable :fields="fields" :table="table" :url="url">
                <template #datatable_btns="slotProps">
                    <data-modal :indice="'pointage'+ slotProps.id" addClass="btn-outline-dark" taille="md">
                        <template #modal_btn>
                            <i class="fa-solid fa-pen-to-square "></i>
                        </template>
                        <template #modal_title>
                            Absence ID00{{ slotProps.id }}
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
import EditerAbsence from './EditerAbsence.vue'
import DataTable from '@/components/DataTable.vue'
import AdminLte from '@/components/AdminLte'
import moment from 'moment'
import Pointage from "@/components/Pointage";

export default {
    name: 'AbsenceView',
    components: {AdminLte, DataModal, EditerAbsence, DataTable, Pointage},
    data() {
        return {
            // url: '/api/pointages?filter[null]=debut_realise&sort=+debut_prevu',
            url: '/api/pointagesActionAbscences&',
            // url: '/api/pointages/action?action=abscences&',
            table: 'absences',
            fields: [
                {
                    label: '',
                    key: 'id'
                },
                {
                    key: 'debut_prevu',
                    sortable: 'true',
                    formatter: function (row) {
                        if (row) return moment(String(row)).format('DD/MM/YYYY HH:mm')
                    },
                    label: 'Debut prévu'
                },
                {
                    key: 'fin_prevu',
                    sortable: 'true',
                    formatter: function (row) {
                        if (row) return moment(String(row)).format('DD/MM/YYYY HH:mm')
                    },
                    label: 'Fin prévu'
                },
                {
                    key: 'programme.user.matricule',
                    sortable: 'true',
                    label: 'Matricule'
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
                    key: 'programme.user.fonction.service.libelle',
                    sortable: 'true',
                    label: 'Service'
                }
            ]
        }
    }
}
</script>
