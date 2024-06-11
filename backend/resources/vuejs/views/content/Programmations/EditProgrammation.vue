<template>
  <b-overlay :show="isLoading">
    <div class="form-row">
      <div class="form-group col-4">
        <label>Semaine </label>
        <input v-model="programmation.semaine" class="form-control" disabled type="week">
      </div>
      <div class="form-group col-4">
        <label>Tache </label>
        <input :value="programmation.tache.libelle" class="form-control" disabled type="text">
      </div>
      <div class="form-group col-4">
        <label>Superviseur </label>
        <input :value="programmation.superviseur" class="form-control" disabled type="text">
      </div>
    </div>
    <button id="refresh-agents" class="invisible" @click="getProgrammes()"></button>
    <hr class="my-2"/>
    <div class="div">
      <hr class="mb-3">
      <div v-if="programmeForm === 'replace' " class="row"
           style="text-align: center;display: flex;justify-content: center;"><h3>Remplacement de lagent
        {{ getSpecificEmployes(employes, form2.ancien) }}</h3></div>
      <div v-if="programmeForm === 'edit' " class="row"
           style="text-align: center;display: flex;justify-content: center;"><h3>Modification du programme de l'agent
        {{ getSpecificEmployes(employes, form.user_id) }}</h3></div>
      <div class="row" style="position: sticky; top: 0; background: #d5d5d5; opacity: 1; z-index: 1000000;">
        <div class="col-md-3">
          <p>Agents</p>
        </div>
        <div class="col-md-9 row text-center">
          <div class="col">
            <p>Dimanche <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Dimanche') }}</p>

          </div>
          <div class="col">
            <p>Lundi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Lundi') }}</p>
          </div>
          <div class="col">
            <p>Mardi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Mardi') }}</p>
          </div>
          <div class="col">
            <p>Mercredi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Mercredi') }}</p>
          </div>
          <div class="col">
            <p>Jeudi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Jeudi') }}</p>
          </div>
          <div class="col">
            <p>Vendredi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Vendredi') }}</p>
          </div>
          <div class="col">
            <p>Samedi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Samedi') }}</p>
          </div>
        </div>
      </div>


      <div v-if="programmes.length > 0" class="card-body p-0">
        <template v-for="programme in programmes">
          <div v-if="canShowProgramme(programme.id)" :key="programme.id" class="row ligne_agent">
            <div class="col-md-3 text-nowrap">
              <template v-if="canShowAdminButton(programmation)">
                <a class=" m-1" href="#" @click.prevent="showEditProgrammaForm(programme)">
                  <i class="fas fa-edit text-info"></i>
                </a>
                <a class=" m-1" href="#" @click.prevent="showRemplacement(programme)">
                  <i class="fas fa-copy text-warning"></i>
                </a>
                <a class=" m-1" href="#" @click.prevent="deleteProgramme(programme.id)">
                  <i class="fas fa-close text-danger"></i>
                </a>
              </template>
              <span v-b-tooltip.hover :title="getSpecificEmployes(employes, programme.user_id)" class="nom_agent">
                {{ getSpecificEmployes(employes, programme.user_id).substr(0, 23) }}...
              </span>

            </div>

            <div class="col-md-9 row text-center">
              <div class="col">
                <p>{{ getSpecifiHoraires(programme, 'dimanche') }}</p>
              </div>
              <div class="col">
                <p>{{ getSpecifiHoraires(programme, 'lundi') }}</p>
              </div>
              <div class="col">
                <p>{{ getSpecifiHoraires(programme, 'mardi') }}</p>
              </div>
              <div class="col">
                <p>{{ getSpecifiHoraires(programme, 'mercredi') }}</p>
              </div>
              <div class="col">
                <p>{{ getSpecifiHoraires(programme, 'jeudi') }}</p>
              </div>
              <div class="col">
                <p>{{ getSpecifiHoraires(programme, 'vendredi') }}</p>
              </div>
              <div class="col">
                <p>{{ getSpecifiHoraires(programme, 'samedi') }}</p>
              </div>
            </div>
          </div>

        </template>
      </div>

      <div v-if="programmation.statut !== 'Terminer'">
        <hr class="mb-3">
        <form v-if="programmeForm === 'edit' " class="row" @submit.prevent="editLine()">

          <div class="col-md-3">
            Agent
            <br/>
            <span style="opacity: 0">Separateur</span>
            <select v-model="form.user_id" class="form-control" disabled required>
              <option v-for="serv in getSpecificUsers()" :key="serv.id" :value="serv.id">{{ serv.matricule }}
                {{ serv.nom }} {{ serv.prenom }}
              </option>
            </select>

          </div>
          <div class="col-md-9 row text-center">
            <div class="col">
              Dimanche <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Dimanche') }}
              <select v-model="form.dimanche" class="form-control" required>
                <option v-for="ho in horaires1.dimanche" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
              </select>
            </div>
            <div class="col">
              Lundi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Lundi') }}
              <select v-model="form.lundi" class="form-control" required>
                <option v-for="ho in horaires1.lundi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
              </select>
            </div>
            <div class="col">
              Mardi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Mardi') }}
              <select v-model="form.mardi" class="form-control">
                <option v-for="ho in horaires1.mardi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
              </select>
            </div>
            <div class="col">
              Mercredi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Mercredi') }}
              <select v-model="form.mercredi" class="form-control" required>
                <option v-for="ho in horaires1.mercredi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
              </select>
            </div>
            <div class="col">
              Jeudi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Jeudi') }}
              <select v-model="form.jeudi" class="form-control" required>
                <option v-for="ho in horaires1.jeudi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
              </select>
            </div>
            <div class="col">
              Vendredi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Vendredi') }}
              <select v-model="form.vendredi" class="form-control" required>
                <option v-for="ho in horaires1.vendredi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
              </select>
            </div>
            <div class="col">
              Samedi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Samedi') }}
              <select v-model="form.samedi" class="form-control" required>
                <option v-for="ho in horaires1.samedi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
              </select>
            </div>
          </div>
          <div class="col-12 mt-3 submit-button">
            <button class="btn btn-primary" type="submit">
              <div v-if="isLoading === true" class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="sr-only">Chargement...</span>
              </div>
              <i class="fas fa-floppy-disk"></i> Mettre à jour
            </button>
            <button class="btn btn-danger" @click="annuler()">
              <div v-if="isLoading === true" class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="sr-only">Chargement...</span>
              </div>
              <i class="fas fa-close"></i> Annuler la modification
            </button>
          </div>
        </form>

        <form v-else-if="programmeForm === 'replace' " class="row" @submit.prevent="replaceLine()">

          <div class="col-md-3">
            Agent
            <br/>
            <span style="opacity: 0">Separateur</span>
            <select v-model="form2.user_id" class="form-control" required>
              <option v-for="serv in getSpecificUsers()" :key="serv.id" :value="serv.id">{{ serv.matricule }}
                {{ serv.nom }} {{ serv.prenom }}
              </option>
            </select>
          </div>
          <div class="col-md-9 row text-center">
            <div class="col">
              Dimanche <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Dimanche') }}
              <select v-model="form2.dimanche" class="form-control" required>
                <option v-for="ho in horaires1.dimanche" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
                <option value="">Annuler</option>
              </select>
            </div>
            <div class="col">
              Lundi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Lundi') }}
              <select v-model="form2.lundi" class="form-control" required>
                <option v-for="ho in horaires1.lundi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
                <option value="">Annuler</option>
              </select>
            </div>
            <div class="col">
              Mardi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Mardi') }}
              <select v-model="form2.mardi" class="form-control">
                <option v-for="ho in horaires1.mardi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
                <option value="">Annuler</option>
              </select>
            </div>
            <div class="col">
              Mercredi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Mercredi') }}
              <select v-model="form2.mercredi" class="form-control" required>
                <option v-for="ho in horaires1.mercredi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
                <option value="">Annuler</option>
              </select>
            </div>
            <div class="col">
              Jeudi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Jeudi') }}
              <select v-model="form2.jeudi" class="form-control" required>
                <option v-for="ho in horaires1.jeudi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
                <option value="">Annuler</option>
              </select>
            </div>
            <div class="col">
              Vendredi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Vendredi') }}
              <select v-model="form2.vendredi" class="form-control" required>
                <option v-for="ho in horaires1.vendredi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
                <option value="">Annuler</option>
              </select>
            </div>
            <div class="col">
              Samedi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Samedi') }}
              <select v-model="form2.samedi" class="form-control" required>
                <option v-for="ho in horaires1.samedi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
                <option value="">Annuler</option>
              </select>
            </div>
          </div>
          <div class="col-12 mt-3 submit-button">
            <button class="btn btn-primary" type="submit">
              <div v-if="isLoading === true" class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="sr-only">Chargement...</span>
              </div>
              <i class="fas fa-floppy-disk"></i> Valider le remplacement
            </button>

            <button class="btn btn-danger" @click="annuler()">
              <div v-if="isLoading === true" class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="sr-only">Chargement...</span>
              </div>
              <i class="fas fa-close"></i> Annuler le remplacement
            </button>
          </div>
        </form>

        <form v-else class="row" @submit.prevent="addLine()">
          <div class="col-md-3">
            Agent
            <br/>
            <span style="opacity: 0">Separateur</span>
            <!--select class="form-control" v-model="form.user_id"  ref="select_user" required>
              <option v-for="serv in getSpecificUsers()" :key="serv.id" :value="serv.id">{{serv.matricule}} {{serv.nom}} {{serv.prenom}}</option>
            </!--select-->
            <v-select :options="getSpecificUsers()" label="name" @input="setAgent"/>
          </div>
          <div class="col-md-9 row text-center">
            <div class="col">
              Dimanche <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Dimanche') }}
              <select v-model="form.dimanche" class="form-control" required>
                <option v-for="ho in horaires1.dimanche" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
              </select>
            </div>
            <div class="col">
              Lundi1 <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Lundi') }}
              <select v-model="form.lundi" class="form-control" required>
                <option v-for="ho in horaires1.lundi" :key="ho.id" :value="ho.id">{{ ho.libelle }} {{ index }}</option>
              </select>
            </div>
            <div class="col">
              Mardi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Mardi') }}
              <select v-model="form.mardi" class="form-control">
                <option v-for="ho in horaires1.mardi" :key="ho.id" :value="ho.id">{{ ho.libelle }} {{ index }}</option>
              </select>
            </div>
            <div class="col">
              Mercredi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Mercredi') }}
              <select v-model="form.mercredi" class="form-control" required>
                <option v-for="ho in horaires1.mercredi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
              </select>
            </div>
            <div class="col">
              Jeudi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Jeudi') }}
              <select v-model="form.jeudi" class="form-control" required>
                <option v-for="ho in horaires1.jeudi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
              </select>
            </div>
            <div class="col">
              Vendredi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Vendredi') }}
              <select v-model="form.vendredi" class="form-control" required>
                <option v-for="ho in horaires1.vendredi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
              </select>
            </div>
            <div class="col">
              samedi <br/>{{ getJoursNumberFromWeek(programmation.semaine, 'Samedi') }}
              <select v-model="form.samedi" class="form-control" required>
                <option v-for="ho in horaires1.samedi" :key="ho.id" :value="ho.id">{{ ho.libelle }}</option>
              </select>
            </div>
          </div>
          <div class="col-12 mt-3 submit-button">
            <button class="btn btn-primary" type="submit">
              <div v-if="isLoading === true" class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="sr-only">Chargement...</span>
              </div>
              <i class="fas fa-floppy-disk"></i> Ajouter un agent
            </button>
            <button class="btn btn-success" @click="close()">
              <div v-if="isLoading === true" class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="sr-only">Chargement...</span>
              </div>
              <i class="fas fa-check"></i> Enregistrer la programmation
            </button>
          </div>
        </form>
      </div>
    </div>
  </b-overlay>
</template>

<script>
import $ from 'jquery'
import moment from "moment/moment";
import VSelect from 'vue-select'

export default {
  name: 'EditProgrammations',
  components: {VSelect},
  props: ['data', 'data', 'gridApi', 'modalFormId',],
  data() {
    return {
      errors: [],
      programmeForm: 'create',
      employes: [],
      horaires: [],
      horaires1: {},
      isLoading: false,
      programmation: [],
      programmes: [],
      agentsOccuper: [],
      actual: 0,
      state: 'LISTING',
      form: {
        user_id: '',
        dimanche: '',
        lundi: '',
        mardi: '',
        mercredi: '',
        jeudi: '',
        vendredi: '',
        samedi: '',
        programmation_id: ''
      },
      form2: {
        ancien: '',
        user_id: '',
        dimanche: '',
        lundi: '',
        mardi: '',
        mercredi: '',
        jeudi: '',
        vendredi: '',
        samedi: '',
        programmation_id: ''
      }
    }
  },
  mounted() {
    this.getEmployes()
    this.getHoraires()
    this.getProgrammes()
    this.programmation = this.data
    this.programmation['date_debut'] = this.form['date_debut'].split(' ')[0]
    this.programmation['date_fin'] = this.form['date_fin'].split(' ')[0]
    this.agentsOccuper = this.getAgentsOccuper(this.programmation.semaine)
    this.form.programmation_id = this.programmation.id

  },
  updated() {


  },
  watch: {
    'form2.user_id': {
      handler: function (after, before) {
        console.log('voici le changement 2', after, before, this.horaires, this.getAgentsOccuper)
        Object.keys(this.agentsOccuper).forEach(key => {
          this.horaires1[key] = []
          console.log(key, this.agentsOccuper[key])
          try {
            if (this.agentsOccuper[key].includes(after)) {
              this.horaires1[key] = [{id: -1, libelle: 'En conges'}]
            } else {
              this.horaires1[key] = [...this.horaires, {id: -2, libelle: 'Repos'}]
            }

            if (this.horaires1[key].length === 1) {
              this.form2[key] = this.horaires1[key][0].id
            }
          } catch (e) {

          }

          console.log('voici le changement 2', key, after, this.horaires1)
        })
      },
      deep: true
    },
    'form.user_id': {

      handler: function (after, before) {
        console.log('voici le changement 1', this.form, after, before, this.horaires, Object.keys(this.agentsOccuper))
        let jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche']

        Object.keys(this.agentsOccuper).forEach(key => {
          this.horaires1[key] = []
          console.log(key, this.agentsOccuper[key])
          try {
            if (this.agentsOccuper[key].includes(after)) {
              console.log('il ya conges constacter')
              this.horaires1[key] = [{id: '-1', libelle: 'En conges'}]
            } else {
              this.horaires1[key] = [...this.horaires, {id: -2, libelle: 'Repos'}]
            }
            if (this.horaires1[key].length === 1) {
              this.form[key] = this.horaires1[key][0].id
            }
          } catch (e) {

          }


          console.log('voici le changement ', key, after, this.horaires1)
        })
      },
      deep: true
    }
  },
  methods: {
    getEmployes() {
      this.isLoading = true
      this.axios.get('/api/users/type_id/2').then((response) => {
        this.employes = response.data
        this.isLoading = false
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de la récuperation')
      })
    },
    validateProgramation(id) {
      this.axios.post('/programmations/valider/' + id).then(response => {
        this.isLoading = true
        this.gridApi.applyServerSideTransaction({
          remove: [
            this.form
          ]
        });
        this.$toast.success('Programmation validé')
      }).catch(error => {
        console.error('error lors de la validation', error)
        this.$toast.error('Erreur survenue lors de la validation')
      })
    },
    duplicateProgramation(id) {
      this.axios.post('/programmations/dupliquer/' + id).then(response => {
        this.gridApi.applyServerSideTransaction({
          remove: [
            this.form
          ]
        });
        this.$toast.success('Programmation dupliqué')
      }).catch(error => {
        console.error('error lors de la duplication', error)
        this.$toast.error('Erreur survenue lors de l\'enregistrement')
      })
    },
    getSpecificUsers() {
      let result = []
      if (this.programmeForm == 'replace') {
        let dejaUtiliser = []
        this.programmes.map(data => {
          dejaUtiliser.push(data.user_id)
        })
        let employees = this.employes.filter(function (data) {
          return !dejaUtiliser.includes(data.id)

        })
        result = employees


      } else {
        result = this.employes
      }
      return result

    },
    getSpecifiHoraires(programme, day) {
      const horairesForDay = this.horaires.filter(item => parseInt(item.id) === parseInt(programme[day]))
      console.log('voici les agents occuper==>', this.agentsOccuper)

      if (this.agentsOccuper[day + '_abscences'].includes(programme.user_id)) {
        return 'Programmer mais abscens'
      } else if (this.agentsOccuper[day + '_conges'].includes(programme.user_id)) {
        return 'Programmer mais en conges'
      } else {
        if (horairesForDay.length > 0) return horairesForDay[0].libelle
        else if (programme[day] === '') return 'Non programmer'
        else if (programme[day] === '0') return 'Remplacé'
        else if (programme[day] === '-1') return 'En conges'
        else if (programme[day] === '-2') return 'Repos'
        else return programme[day]
      }

    },
    getSpecifiHoraires1(programme, day) {
      try {
        const userID = programme.user_id
        const absentJours = this.agentsOccuper[day]
        if (Array.isArray(absentJours) && userID in absentJours) {
          return 'conges'
        }
      } catch (e) {
        console.error('une erreur sest produite', e)
      }

      const horairesForDay = this.horaires.filter(item => parseInt(item.id) === parseInt(programme[day]))
      if (horairesForDay.length > 0) return horairesForDay[0].libelle
      else if (programme[day] === 'Repos') return 'Repos'
      else return ''
    },
    getSpecificEmployes(employees, userId) {
      let userSelect = employees.filter(item => item.id === parseInt(userId))

      console.log('voici lusers a selectionner', userId, employees, userSelect)

      return userSelect.length > 0
          ? userSelect[0].nom + " " + userSelect[0].prenom
          : 'Agent'
    },
    addLine() {
      this.isLoading = true
      this.axios.post('/api/programmes', this.form)
          .then(response => {
            this.isLoading = false
            $('#refresh-agents').click()
            this.$toast.success('Programme ajouté')
            for (const key in this.form) {
              this.form[key] = ''
            }
            this.form.programmation_id = this.programmation.id
          }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de l\'enregistrement')
      })
    },
    editLine() {
      this.isLoading = true
      this.axios.post('/api/programmes/' + this.form.id + '/update', this.form).then(response => {
        this.isLoading = false
        $('#refresh-agents').click()
        this.$toast.success('Programme modifié')
        for (const key in this.form) {
          this.form[key] = ''
        }
        this.form.programmation_id = this.programmation.id
        this.programmeForm = 'create'
        this.state = 'LISTING'
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de l\'enregistrement')
      })
    },
    replaceLine() {
      this.isLoading = true
      this.axios.post('/api/programmationsActionRemplacer', this.form2).then(response => {
    //   this.axios.post('/api/programmations/action?action=remplacer', this.form2).then(response => {
        this.isLoading = false
        $('#refresh-agents').click()
        this.$toast.success('Programme remplacé')
        for (const key in this.form2) {
          this.form2[key] = ''
        }
        this.form2.programmation_id = this.programmation.id
        this.programmeForm = 'create'
        this.state = 'LISTING'
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de l\'enregistrement')
      })
    },
    getHoraires() {
      this.axios.get('/api/horaires/tache_id/' + this.data.tache_id).then((response) => {
        this.horaires = response.data
      })
    },
    getProgrammes() {
      this.axios.get('/api/programmes/programmation_id/' + this.data.id).then((response) => {
        this.programmes = response.data
      })
    },
    getAgentsOccuper(semaine) {
      this.axios.get('/api/congesActionAgentsDisponibles&semaine=' + semaine).then((response) => {
    //   this.axios.get('/api/conges/action?action=agentsDisponibles&semaine=' + semaine).then((response) => {
        this.agentsOccuper = response.data
      })
      return true
    },
    showEditProgrammaForm(programme) {
      this.actual = programme.id
      this.state = 'EDITING'
      this.programmeForm = 'edit'
      this.form = Object.assign({}, programme)
    },
    showRemplacement(programme) {
      this.actual = programme.id
      this.state = 'EDITING'
      this.programmeForm = 'replace'
      this.form2 = {
        ancien: programme.user_id,
        user_id: '',
        dimanche: programme.dimanche,
        lundi: programme.lundi,
        mardi: programme.mardi,
        mercredi: programme.mercredi,
        jeudi: programme.jeudi,
        vendredi: programme.vendredi,
        samedi: programme.samedi,
        programmation_id: programme.programmation_id
      }
    },
    deleteProgramme(id) {
      this.isLoading = true
      this.axios.post('/api/programmes/' + id + '/delete').then(response => {
        this.isLoading = false
        $('#refresh-agents').click()
        this.$toast.success('Programme retiré')
      }).catch(error => {
        this.errors = error.response.data.errors
        this.isLoading = false
        this.$toast.error('Erreur survenue lors de la suppression')
      })
    },
    canShowProgramme(id) {
      return this.state === 'LISTING' || this.actual === id
    },
    canShowAdminButton(programmation) {
      return programmation.statut !== 'Terminer' && this.state === 'LISTING'
    },
    annuler() {
      this.state = 'LISTING'
      this.programmeForm = 'create'
      this.actual = 0
      for (const [key, value] of Object.entries(this.form)) {
        this.form[key] = ''
        console.log(value)
      }
      // for (const [key, value] of Object.entries(this.form2)) {
      //   this.form[key]=''
      // }
    },
    getDateOfWeek(w, y) {
      const d = (1 + (w - 1) * 7) // 1st of January + 7 days for each week
      return new Date(y, 0, d)
    },
    getJoursNumberFromWeek(week, jour) {
      const date = {}
      date.Dimanche = moment(`${week}`).subtract(1, 'days')
      date.Lundi = moment(`${week}`).add(0, 'days')
      date.Mardi = moment(`${week}`).add(1, 'days')
      date.Mercredi = moment(`${week}`).add(2, 'days')
      date.Jeudi = moment(`${week}`).add(3, 'days')
      date.Vendredi = moment(`${week}`).add(4, 'days')
      date.Samedi = moment(`${week}`).add(5, 'days')
      return `${date[jour].format('DD/MM/YYYY')}`
    },
    getWeekHumans(week) {


    },
    close() {
      // $('#refresh' + this.table).click()
      this.state = 'LISTING'
      this.programmeForm = 'create'
      $('#close_modal_programmation' + this.programmation.id).click()
    },
    setAgent(value) {
      if (value) this.form.user_id = value.id
    }
  }
}
</script>

<style>
@import "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css";

.submit-button {
  display: flex;
  justify-content: space-around;
}

.nom_agent {
  cursor: pointer;

}

.ligne_agent {
  cursor: pointer

}

.ligne_agent:hover {
  color: #28a745

}
</style>
