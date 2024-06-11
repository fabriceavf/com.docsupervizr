<template>
    <AdminLte>
        <template #breadcrumb_title>
            Pointages brutes (En temps réel)
        </template>
        <template #breadcrumb_pages>
            <li class="breadcrumb-item active">
                Pointages > Brutes
            </li>
        </template>
        <template #content>
            <DataTable :fields="fields" :url="url"/>
        </template>
    </AdminLte>
</template>

<script>
import DataTable from '@/components/DataTable.vue'
import AdminLte from '@/components/AdminLte'
import moment from 'moment'

export default {
    name: 'BruteView',
    components: {AdminLte, DataTable},
    data() {
        return {
            url: '/api/transactions?sort=-punch_time&',
            fields: [
                {
                    label: 'ID',
                    sortable: 'true',
                    key: 'bio_id'
                },
                {
                    key: 'emp_code',
                    sortable: 'true',
                    label: 'Code'
                },
                {
                    key: 'punch_time',
                    sortable: 'true',
                    formatter: function (row) {
                        if (row) return moment(String(row)).format('DD/MM/YYYY HH:mm')
                    },
                    label: 'Jour'
                },
                {
                    key: 'first_name',
                    sortable: 'true',
                    label: 'Nom'
                },
                {
                    key: 'last_name',
                    sortable: 'true',
                    label: 'Prenom'
                },
                {
                    key: 'card_no',
                    sortable: 'true',
                    label: 'Badge'
                },
                {
                    key: 'area_alias',
                    sortable: 'true',
                    label: 'Departement'
                },
                {
                    key: 'terminal_alias',
                    sortable: 'true',
                    label: 'Pointeuse'
                }
            ]
        }
    }
}
</script>
