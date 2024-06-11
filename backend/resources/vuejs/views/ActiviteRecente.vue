<template>
  <AdminLte>
    <template #breadcrumb_title>
      Activités récentes
    </template>
    <template #breadcrumb_pages>
      <li class="breadcrumb-item active">
        Activités récentes
      </li>
    </template>
    <template #content>
      <DataTable :fields="fields" :table="table" :url="url"/>
    </template>
  </AdminLte>
</template>

<script>
import DataTable from '@/components/DataTable.vue'
import AdminLte from '@/components/AdminLte'

export default {
  name: 'BruteView',
  components: {AdminLte, DataTable},
  data() {
    return {
      url: '/api/activites_recentes?',
      table: 'activites_recentes',
      fields: [
        {
          label: '',
          key: 'id'
        },
        {
          key: 'created_at',
          sortable: 'true',
          label: 'Date'
        },
        {
          key: 'user.name',
          sortable: 'true',
          label: 'Utilisateur'
        },
        {
          key: 'module',
          sortable: 'true',
          label: 'Module'
        },
        {
          key: 'action',
          label: 'Action réalisé'
        },
        {
          key: 'qte',
          label: 'Repetition'
        }
      ]
    }
  }
}
</script>
