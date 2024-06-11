<script src="../main.js"></script>
<template>
  <AdminLte>
    <template #content>
      <BreadCrumb>
        <template #breadcrumb_title>
          Calendrier


        </template>
        <template #breadcrumb_pages>
          <li class="breadcrumb-item active">
            Calendrier
          </li>
        </template>
      </BreadCrumb>
      <div class="row">
        <div class="col-md-10">
          <date-picker
              v-model="selectionDate"
              :columns="$screens({ default: 1, lg: 4, md: 3 })"
              :rows="3"
              is-expanded
              locale="fr"
              show-weeknumbers>
          </date-picker>

        </div>
        <div class="col-md-2">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title"> Détails du jours</h5>
            </div>
            <div class="card-body">
              <p v-if="selectionDate == null"> Pas de jours selectionné</p>
              <div v-if="selectionDate != null">
                <p>
                  <strong>Date: </strong> {{ formatDate(this.selectionDate) }}
                </p>
                <p>
                  <strong>Evenement: </strong>
                </p>
                <data-modal id="btn" :indice="'agent'" addClass="btn-primary btn-sm btn-block" taille="md">
                  <template #modal_btn>
                    <i class="fa-solid fa-plus"></i> Ajouter un évenement
                  </template>
                  <template #modal_title>
                    Ajouter un évenement
                  </template>
                  <template #modal_body>
                    <form>
                      <textarea class="form-control" placeholder="Tapez la description de l'évenement ici..."
                                rows="5"></textarea>

                      <div class="form-check mt-2">
                        <input id="defaultCheck1" class="form-check-input" type="checkbox" value="">
                        <label class="form-check-label" for="defaultCheck1">
                          Activer pour chaque années
                        </label>
                      </div>

                      <button class="btn btn-sm mt-2 btn-outline-primary" type="submit">
                        <i class="fa-solid fa-save"></i> Soumettre
                      </button>
                    </form>
                  </template>
                </data-modal>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </AdminLte>
</template>
<!--<template>-->

<!--</template>-->
<script>
import DatePicker from 'v-calendar/lib/components/date-picker.umd'
import DataModal from '@/components/DataModal.vue'
import moment from 'moment'
import BreadCrumb from '@/components/BreadCrumb'
import AdminLte from '@/components/AdminLte'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

export default {
  name: 'CalendrierView',
  data() {
    return {
      selectionDate: new Date(),
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth'
      }
    }
  },
  components: {

    DatePicker, DataModal, BreadCrumb, AdminLte

  },
  methods: {
    formatDate(data) {
      return moment(String(data)).format('DD/MM/YYYY')
    }

  }
}
</script>
