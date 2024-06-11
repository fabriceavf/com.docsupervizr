<template>
  <b-overlay :show="this.isLoading">
    <div v-if="(errors.length !== 0)" class="alert alert-danger" role="alert">
      <ul>
        <li v-for="(err , index) in errors" :key="index">
          {{ index }} {{ err[0][0] }}
        </li>
      </ul>
    </div>
    <form v-if="step == 1" @submit.prevent="next()">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Matricule</label>
          <input v-model="form.matricule" :class="{'is-invalid': errors.matricule }" _required class="form-control"
                 type="text">
        </div>
        <div class="form-group col-md-6">
          <label>Nom</label>
          <input v-model="form.nom" :class="{'is-invalid': errors.nom }" _required class="form-control" type="text">
        </div>
        <div class="form-group col-md-6">
          <label>Prenom</label>
          <input v-model="form.prenom" :class="{'is-invalid': errors.prenom }" _required class="form-control"
                 type="text">
        </div>
        <div class="form-group col-md-3">
          <label>Date de naissance</label>
          <input v-model="form.date_naissance" :class="{'is-invalid': errors.date_naissance }" _required
                 class="form-control" type="date">
        </div>
        <div class="form-group col-md-3">
          <label>Sexe</label>
          <select v-model="form.sexe" :class="{'is-invalid': errors.sexe }" _required class="form-control">
            <option selected value="Masculin">Masculin</option>
            <option value="Feminin">Feminin</option>
          </select>
        </div>
        <!--div class="form-group col-md-4">
            <label >Nationalite</label>
            <select class="form-control" :class="{'is-invalid': errors.nationalite }" v-model="form.nationalite" required>
                <option v-for="nation in this.pays" :key="nation.id" :value="nation.libelle">{{nation.libelle}}</option>
            </select>
        </§div>
        <div-- class="form-group col-md-4">
          <label>Situation matrimoniale</label>
          <select class="form-control" :class="{'is-invalid': errors.situation_matri }" v-model="form.situation_matri" required>
            <option value="Celibataire" selected>Celibataire</option>
            <option value="Marié" >Marié</option>
          </select>
        </div-->
        <div class="form-group col-md-6">
          <label>Fonction</label>
          <select v-model="form.fonction_id" :class="{'is-invalid': errors.fonction_id }" class="form-control">
            <option v-for="fonction in this.fonctions" :key="fonction.id" :value="fonction.id">{{ fonction.libelle }}
            </option>
          </select>
        </div>
        <div class="form-group col-md-6">
          <label>Telephone </label>
          <input v-model="form.telephone1" :class="{'is-invalid': errors.telephone1 }" class="form-control" type="text">
        </div>
        <!--div class="form-group col-md-4">
            <label >Telephone 2</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.telephone2 }" v-model="form.telephone2">
        </div>
        <div class="form-group col-md-4">
            <label >Nombre d'enfant</label>
            <input type="number" min="0" class="form-control" :class="{'is-invalid': errors.nb_enfant }" v-model="form.nb_enfant">
        </div>
        <div class="form-group col-md-4">
            <label >Numero CNSS</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.num_cnss }" v-model="form.num_cnss">
        </div>
        <div class="form-group col-md-4">
            <label >CNAMGS</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.num_cnamgs }" v-model="form.num_cnamgs">
        </div-->
        <div class="form-group col-md-6">
          <label>Numero Badge</label>
          <input v-model="form.num_badge" :class="{'is-invalid': errors.num_badge }" class="form-control" type="text">
        </div>
        <div class="form-group col-md-6">
          <label>Code employé (Pointeuse)</label>
          <input v-model="form.code_employe" :class="{'is-invalid': errors.code_employe }" class="form-control" min="0"
                 type="number">
        </div>
      </div>
      <button class="btn btn-primary" type="submit">Suivant</button>
    </form>

    <!--form v-if="step == 2" @submit.prevent="next()">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Matricule</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.matricule }" v-model="form.matricule">
            </div>
            <div class="form-group col-md-6">
                <label >Type de contrat </label>
                <select  class="form-control" :class="{'is-invalid': errors.contrat }" v-model="form.contrat">
                    <option value="CDD" selected>Contrat de travail à durée déterminée (CDD) </option>
                    <option value="CDI" >Contrat de travail à durée indéterminée (CDI) </option>
                    <option value="CET" >Contrat pour l'execution d'une tache (CET)</option>
                    <option value="Stage" >Contrat de stage </option>
                </select>
            </div>
            <div class="form-group col-md-6">
              <label >Fonction</label>
              <select  class="form-control" :class="{'is-invalid': errors.fonction_id }" v-model="form.fonction_id">
                  <option v-for="fonction in this.fonctions" :key="fonction.id" :value="fonction.id">{{fonction.libelle}}</option>
              </select>
            </div>

            <div class="form-group col-md-6">
                <label >Code employé (Pointeuse)</label>
                <input type="number" min="0" class="form-control" :class="{'is-invalid': errors.code_employe }" v-model="form.code_employe">
            </div>
            <div class="form-group col-md-6">
                <label >Numero Badge</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.num_badge }" v-model="form.num_badge">
            </div>
            <div class="form-group col-md-6">
                <label >Date d'embauche</label>
                <input type="date" class="form-control" :class="{'is-invalid': errors.date_embauche }" v-model="form.date_embauche">
            </div>
        </div>

        <button type="button" @click.prevent="prev()" class="btn btn-secondary mr-2">Précédent</button>
        <button type="submit" class="btn btn-primary" >Suivant</button>
    </form-->

    <form v-if="step == 2" @submit.prevent="saveEnrolement()">

      <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
        <label class="btn btn-secondary active">
          <input v-model="mode" checked type="radio" value="fichier"> Selectionner le fichier
        </label>
        <label class="btn btn-secondary">
          <input v-model="mode" type="radio" value="camera"> Utiliser la webcam
        </label>
      </div>

      <div v-show="mode === 'camera'" class="row">
        <div class="col-md-6 row">
          <div class="col-md-6">
            <video id="webcam" autoplay playsinline style="height: 50vh;width: 100%;object-fit: fill;"></video>
            <audio id="snapSound" preload="auto" src="audio/snap.wav"></audio>
          </div>
          <div class="col-md-6">
            <canvas id="canvas" height="100%" width="100%"></canvas>
          </div>
        </div>

        <div class="col-md-6">
          <div class="container">
            <div class="justify-content-center">
              <a class="btn btn-sm btn-outline-dark mr-2" href="#" @click.prevent="take_picture()">
                <i class="fas fa-camera"></i> Capturer
              </a>
              <a class="btn btn-sm btn-outline-primary" href="#" @click="save_picture()">
                <i class="fas fa-save"></i> Sauvegarder
              </a>
            </div>
          </div>
        </div>
      </div>

      <div v-show="mode === 'fichier'" class="row">
        <div class="col-md-6 mb-3">
          <input id="select_file" style="display:none" type="file" v-on:change="onFileChange"/>
          <img v-if="url" :src="url" class="w-100 rounded">
          <img v-else class="w-100 rounded" src="../../assets/default_photo.jpg">
        </div>

        <div class="col-md-6">
          <div class="container">
            <a href="#" @click.prevent="select_file_open()">
              <i class="fas fa-image"></i> Sélectionner une photo dans votre galerie
            </a>
          </div>
        </div>
      </div>

      <button class="btn btn-secondary mr-2" type="button" @click.prevent="prev()">Précédent</button>
      <button class="btn btn-primary" type="submit">Terminer</button>
    </form>
  </b-overlay>
</template>

<script>
import Webcam from 'webcam-easy'
import $ from 'jquery'

export default {
  name: 'CreateEnrolement',
  props: ['fonctions', 'pays', 'table'],
  data() {
    return {
      mode: 'fichier',
      fichier: false,
      camera: true,
      step: 1,
      webcam_object: null,
      url: null,
      errors: [],
      isLoading: false,
      form: {
        name: '',
        nom: '',
        prenom: '',
        date_naissance: '',
        sexe: '',
        nationalite: '',
        situation_matri: '',
        telephone: '',
        nb_enfant: '',
        num_cnss: '',
        num_cnamgs: '',
        matricule: '',
        contrat: '',
        fonction_id: '',
        code_employe: '',
        num_badge: '',
        date_embauche: '',
        photo: '',
        type: 'employe'
      }
    }
  },
  mounted() {
    let webcameasy = document.createElement('script')
    webcameasy.setAttribute('src', 'https://unpkg.com/webcam-easy/dist/webcam-easy.min.js')
    document.body.appendChild(webcameasy)
  },
  created() {
    this.run_webcam()
  },
  methods: {
    prev() {
      this.step--
    },
    next() {
      this.step++
    },
    permuterMode() {
      if (this.fichier == true) this.camera = false
      if (this.camera == true) this.fichier == false
    },
    saveEnrolement() {
      this.isLoading = true
      const config = {
        headers: {'Content-Type': 'multipart/form-data'}
      }

      this.axios.post('/api/users', this.form, config).then(response => {
        this.isLoading = false
        this.resetForm()
        $('#close_modal_new-enrolement').click()
        $('#refresh' + this.table).click()
        this.$toast.success('Nouvel employé enrolé')
        console.log(response.data)
      }).catch(error => {
        this.isLoading = false
        this.errors = error.response.data.errors
        this.$toast.error('Erreur survenue lors de l\'enregistrement')
      })
    },
    run_webcam() {
      const webcamElement = document.getElementById('webcam')
      const canvasElement = document.getElementById('canvas')
      const snapSoundElement = document.getElementById('snapSound')
      const webcam = new Webcam(webcamElement, 'enviroment', canvasElement, snapSoundElement)

      webcam.start()
          .then(result => {
            console.log('webcam started')
          })
          .catch(err => {
            console.log(err)
          })
      this.webcam_object = webcam
    },
    select_file_open() {
      document.getElementById('select_file').click()
    },
    onFileChange(e) {
      const file = e.target.files[0]
      this.url = URL.createObjectURL(file)
      this.form.photo = e.target.files[0]
    },
    take_picture() {
      this.picture = this.webcam_object.snap();
    },
    save_picture() {
      this.webcam_object.stop();
      this.url = document.getElementById("canvas").toDataURL("image/jpeg");
    },
    resetForm() {
      this.form = {
        name: '',
        nom: '',
        prenom: '',
        date_naissance: '',
        sexe: '',
        nationalite: '',
        situation_matri: '',
        telephone: '',
        nb_enfant: '',
        num_cnss: '',
        num_cnamgs: '',
        matricule: '',
        contrat: '',
        fonction_id: '',
        code_employe: '',
        num_badge: '',
        date_embauche: '',
        photo: '',
        type: 'employe'
      }
      this.url = ''
    }
  }
}
</script>
