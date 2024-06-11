<template>
  <AdminLte>
    <template #breadcrumb_title>
      Exceptions (Pointages incomplets et dépassements)
    </template>
    <template #breadcrumb_pages>
      <li class="breadcrumb-item active">
        Pointages > Exceptions
      </li>
    </template>
    <template #content>
      <DataTable :fields="fields" :table="table" :url="url">
        <template #datatable_btns="slotProps">
          <data-modal :indice="'exception'+ slotProps.id" addClass="btn-outline-dark" taille="md">
            <template #modal_btn>
              <i class="fa-solid fa-pen-to-square "></i>
            </template>
            <template #modal_title>
              Exception ID00{{ slotProps.id }}
            </template>
            <template #modal_body>
              <Pointage :identifiant="slotProps.data[0].id"/>
              <!--                <EditerException :data="slotProps.data" :table="table"/>-->
            </template>
          </data-modal>
        </template>
      </DataTable>
    </template>
  </AdminLte>
</template>

<script>
import DataModal from '@/components/DataModal.vue'
import EditerException from './EditerException.vue'
import DataTable from '@/components/DataTable.vue'
import AdminLte from '@/components/AdminLte'
import Pointage from "@/components/Pointage";

export default {
  name: 'ExceptionView',
  components: {AdminLte, DataModal, EditerException, DataTable, Pointage},
  data() {
    return {
      url: '/api/pointagesActionExceptions&',
    //   url: '/api/pointages/action?action=exceptions&',
      table: 'exceptions',
      fields: [
        {
          label: '',
          key: 'id'
        },
        {
          key: 'debut_realise',
          sortable: 'true',
          formatter: this.formatJour,
          label: 'Date debut'
        },
        {
          key: 'fin_realise',
          sortable: 'true',
          formatter: this.formatJour,
          label: 'Date fin'
        },
        {
          key: 'volume',
          sortable: 'true',
          label: 'Dépassement',
          formatter: function (value, key, item) {
            const toHoursAndMinutes = function (totalMinutes) {
              const hours = Math.floor(totalMinutes / 60);
              const minutes = totalMinutes % 60;

              return `${padToTwoDigits(hours)}H:${padToTwoDigits(minutes.toFixed(0))}`;
            }
            const padToTwoDigits = function (num) {
              return num.toString().padStart(2, '0');
            }
            if ((item.volume_prevu) && (item.volume_realise)) {
              let volumeRealise = item.volume_realise
              volumeRealise = volumeRealise.replace('m', '')
              volumeRealise = volumeRealise.split('h')
              volumeRealise = parseInt(volumeRealise[0].trim()) * 60 + parseInt(volumeRealise[1].trim())
              let volumePrevu = item.volume_prevu
              volumePrevu = volumePrevu.replace('m', '')
              volumePrevu = volumePrevu.split('h')
              console.log('voici le volume prevu', volumePrevu)
              volumePrevu = parseInt(volumePrevu[0].trim()) * 60 + parseInt(volumePrevu[1].trim())
              let calcul = volumeRealise - volumePrevu
              if (calcul < 0) {
                calcul = 0
              }

              return toHoursAndMinutes(calcul)
            }
          }
        },
        {
          key: 'user.matricule',
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
