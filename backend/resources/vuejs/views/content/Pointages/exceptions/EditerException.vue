<template>
  <b-overlay :show="isLoading">
    <div>
      <h4 class="text-center">Informations Pointage ({{ this.form.pointeuse }})</h4>
      <p class="text-center">Programme de {{ this.form.faction_horaire }} </p>
      <hr>

      <p>
        <strong>Tache:</strong> {{ getTacheLibelle(this.form.programme.programmation.tache.libelle) }}
      </p>
      <p>
        <strong>Employe:</strong> {{ this.employe.nom }} {{ this.employe.prenom }}
      </p>

      <div class="row mb-3">
        <div class="col">
          <strong>Debut prévu:</strong><br>
          {{ this.form.debut_prevu }} <br>
          <strong>Fin prévu:</strong><br>
          {{ this.form.fin_prevu }}
        </div>
        <div class="col">
          <div v-if="form.debut_realise != form.debut_reel">
            <strong>Debut réel:</strong><br>
            {{ form.debut_reel }} <br>
          </div>
          <strong>Debut réalisé:</strong><br>
          {{ this.form.debut_realise }} <br>
          <strong>Fin réalisé:</strong><br>
          {{ this.form.fin_realise }}
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-6">
          <strong>Volume prévu:</strong> {{ this.form.volume_prevu }}
        </div>
        <div class="col-6">
          <strong>Volume réalisé:</strong> {{ this.form.volume_realise }}
        </div>
        <div class="col-6">
          <strong>Ecart:</strong> {{ ecartDiff(this.form.volume_prevu, this.form.volume_realise) }}
        </div>
      </div>
    </div>

    <form v-if="this.form.fin_realise && this.form.debut_realise" @submit.prevent="editLine()">
      <div class="form-group">
        <label>Motif <span class="text-danger">*</span></label>
        <textarea v-model="form.motif" class="form-control" required rows="5"></textarea>
      </div>

      <button class="btn btn-primary mr-2" type="submit">
        <i class="fas fa-floppy-disk"></i> Valider le dépassement
      </button>
      <button class="btn btn-danger" type="button" @click.prevent="refuserPointage()">
        <i class="fas fa-close"></i> Refuser
      </button>
    </form>

    <form v-if="!this.form.fin_realise" @submit.prevent="addPointage()">
      <p>Rajouter un pointage de fin manuellement</p>
      <div class="form-row">
        <div class="form-group col-6">
          <input :value="form.debut_realise" class="form-control" disabled type="text">
        </div>
        <div class="form-group col-6">
          <input v-model="fin" class="form-control" required type="time">
        </div>
      </div>
      <button class="btn btn-sm mt-2 btn-success" type="submit">
        <i class="fa-solid fa-save"></i> Rajouter
      </button>
    </form>
    <form v-if="!this.form.debut_realise" @submit.prevent="addPointage1()">
      <p>Rajouter un pointage de debut manuellement</p>
      <div class="form-row">
        <div class="form-group col-6">
          <input :value="getDate(this.form.debut_prevu)" class="form-control" disabled type="text">
        </div>
        <div class="form-group col-6">
          <input v-model="debut" class="form-control" required type="time">
        </div>
      </div>
      <button class="btn btn-sm mt-2 btn-success" type="submit">
        <i class="fa-solid fa-save"></i> Rajouter
      </button>
    </form>
  </b-overlay>
</template>
<script>
import moment from 'moment'
import $ from 'jquery'

export default {
  name: 'DetailsPointage',
  props: ['data', 'table'],
  data() {
    return {
      errors: [],
      employe: [],
      isLoading: false,
      fin: '',
      debut: '',
      firstPointage: '',
      form: {
        est_valide: '',
        motif: ''
      }
    }
  },
  mounted() {
    this.form = this.data[0]
    this.employe = this.data[0].user
    // this.getFirstPointage()
  },
  methods: {
    editLine() {
      this.isLoading = true
      this.form.est_valide = '1'
      this.axios.post('/api/pointages/' + this.form.id + '/update', this.form).then(response => {
        this.isLoading = false
        $('#refreshcalendrier').click()

        $('#close_modal_exception' + this.form.id).click()
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
      })
    },
    getDate(datetime) {
      return moment(String(datetime)).format('YYYY-MM-DD')
    },
    ecartDiff(prevu, realise) {
      const toHoursAndMinutes = function (totalMinutes) {
        const hours = Math.floor(totalMinutes / 60);
        const minutes = totalMinutes % 60;

        return `${padToTwoDigits(hours)}H:${padToTwoDigits(minutes.toFixed(0))}`;
      }
      const padToTwoDigits = function (num) {
        return num.toString().padStart(2, '0');
      }
      if ((prevu) && (realise)) {
        let volumeRealise = realise
        volumeRealise = volumeRealise.replace('m', '')
        volumeRealise = volumeRealise.split('h')
        volumeRealise = parseInt(volumeRealise[0].trim()) * 60 + parseInt(volumeRealise[1].trim())
        let volumePrevu = prevu
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
    },
    getTacheLibelle(data) {
      if (data) return data
      else return ''
    },
    getFirstPointage() {
      this.isLoading = true
      this.axios.get('api/transactions?filter[emp_code]=' + this.data[0].user.emp_code + '&filter[like]=punch_time/' + moment(String(this.data[0].debut_prevu)).format('YYYY-MM-DD') + '&sort=+punch_time').then(response => {
        this.isLoading = false
        this.firstPointage = response.data[0].punch_time
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
      })
    },
    refuserPointage() {
      this.isLoading = true
      this.form.est_valide = '3'
      this.axios.post('/api/pointages/' + this.form.id + '/update', this.form).then(response => {
        this.isLoading = false
        $('#close_modal_exception' + this.form.id).click()
        $('#refresh' + this.table).click()
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
      })
    },
    addPointage1() {
      this.isLoading = true
      const dateDebut = this.form.debut_prevu.split(' ')
      const nouveauPointage = dateDebut[0] + ' ' + this.debut + ':00'
      let reel = moment(nouveauPointage)
      let prevu = moment(this.form.debut_prevu)
      this.form.debut_reel = nouveauPointage
      this.form.debut_realise = nouveauPointage
      if (prevu.isAfter(reel)) {
        this.form.debut_realise = this.form.debut_prevu

      }
      this.axios.post('/api/pointages/' + this.form.id + '/update', this.form).then(response => {
        this.isLoading = false
        this.getPointage()
        // $('#close_modal_exception' + this.form.id).click()
        $('#refresh' + this.table).click()
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
      })
    },
    addPointage() {
      this.isLoading = true
      const dateDebut = this.form.fin_prevu.split(' ')
      const nouveauPointage = dateDebut[0] + ' ' + this.fin + ':00'
      this.form.fin_realise = nouveauPointage
      this.axios.post('/api/pointages/' + this.form.id + '/update', this.form).then(response => {
        this.isLoading = false
        this.getPointage()
        // $('#close_modal_exception' + this.form.id).click()
        $('#refresh' + this.table).click()
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
      })
    },
    getPointage() {
      this.isLoading = true
      this.axios.get('api/pointages/id/' + this.data[0].id).then(response => {
        this.isLoading = false
        this.form = response.data[0]
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
      })
    }
  }
}
</script>
