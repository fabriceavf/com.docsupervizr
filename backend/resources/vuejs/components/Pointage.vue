<template>
  <b-overlay :show="isLoading" :key="key" >

<!--{{pointage.est_valide}}-->
    <template  v-if="isNormal()">

      <b-alert v-if="pointage.etats=='NON_PREVU'" show variant="danger">POINTAGE NON PREVUS</b-alert>
      <b-alert v-if="isException()" show variant="secondary">Exception</b-alert>
      <b-alert v-if="isAbscence()" show variant="secondary">Abscences</b-alert>
      <div>
        <hr>
        <h4 class="text-center">Informations Pointage ({{ pointage.id }})</h4>
        <p class="text-center">Programme de ({{ pointage.faction_horaire }})</p>
        <hr>
        <div>
          <h4 class="text-center">Informations employé</h4>
          <hr>
          <div class="row">

            <div class="col-6">
              <strong>Code:</strong> {{pointage.user.emp_code}}
            </div>
            <div class="col-6">
              <strong>Matricule:</strong> {{pointage.user.matricule}}
            </div>
          </div>
          <div class="row">

            <div class="col-6">
              <strong>Nom:</strong> {{pointage.user.nom}}
            </div>
            <div class="col-6">
              <strong>Prenom:</strong> {{pointage.user.prenom}}
            </div>
          </div>

        </div>

        <br/>
        <div>
          <h4 class="text-center">Detail du pointage</h4>
          <hr>
          <div class="row">

            <div class="col-12" style="text-align: center">
              <strong>Tache:</strong> {{ getTacheLibelle(pointage.programme.programmation.tache.libelle) }}
            </div>
          </div>
          <div class="row" v-if="pointage.debut_reel!=pointage.debut_realise">

            <div class="col-12">
              <strong>Debut reel:</strong><br>
              {{pointage.debut_reel}} <br>
            </div>

          </div>
          <div class="row">

            <div class="col-6">
              <strong>Debut prévu:</strong><br>
              {{pointage.debut_prevu}} <br>
            </div>
            <div class="col-6">
              <strong>Debut realise:</strong><br>
              {{pointage.debut_realise}}
            </div>
          </div>

          <div class="row">

            <div class="col-6">
              <strong>Fin prevu:</strong><br/>
              {{pointage.fin_prevu}} <br>
            </div>
            <div class="col-6">
              <strong>Fin realise:</strong><br/>
              {{pointage.fin_realise}}
            </div>
          </div>

        </div>


        <div class="row mb-3" >
          <div class="col">
            <strong>Volume prevu:</strong><br/> {{toHoursAndMinutes(volumePrevu())}}
          </div>
          <div class="col">
            <strong>Volume realise:</strong><br/> {{toHoursAndMinutes(volumeRealise())}}
          </div>
        </div>
        <div class="row mb-3" >
          <div class="col">
            <strong>Total Heure(s) sup </strong><br/>{{toHoursAndMinutes(hs*60)}}
          </div>
        </div>
      </div>
      <template v-if="isAbscence()">
        <template v-if="parseInt(pointage.est_valide)!=2">
          <form v-if="isAbscence()" @submit.prevent="justifier()">
            <div class="form-group ">
              <label >Type</label>
              <select class="form-control" required  v-model="abscence_type">
                <option :value="type.id" v-for="type in typesabscences" >{{type.libelle}}</option>
              </select>
            </div>

            <div class="form-row" v-if="isVariable()">
              <div class="form-group col-6">
                <label >Début</label>
                <input type="date" class="form-control" v-model="abscence_debut" required>
              </div>
              <div class="form-group col-6">
                <label >Fin</label>
                <input type="date" class="form-control"  v-model="abscence_fin" required>
              </div>
            </div>

            <div class="form-group">
              <label >Motif <span class="text-danger">*</span></label>
              <textarea rows="3" v-model="abscence_motif" class="form-control"></textarea>
            </div>

            <!--          <div class="form-group">-->
            <!--            <label >Televerser un fichier </label>-->
            <!--&lt;!&ndash;            <input type="file" @change="previewFiles" class="form-control">&ndash;&gt;-->
            <!--          </div>-->

            <button class="btn btn-primary" type="submit">
              <i class="fas fa-floppy-disk"></i> Justifier l'absence
            </button>
          </form>

        </template>
        <template  v-else>

          <b-alert  variant="success" show>Ascences traiter</b-alert>
        </template>

      </template>
      <template v-if="isDepassement()">
        <form v-if="parseInt(pointage.est_valide)!=1 && parseInt(pointage.est_valide)!=3 && hsInFaction>0" @submit.prevent="editLine()">
          <div class="form-group">
            <label >Motif <span class="text-danger">*</span></label>
            <textarea rows="5" class="form-control" v-model="pointage.motif" required></textarea>
          </div>

          <button class="btn btn-primary mr-2" @click.prevent="valider()">
            <i class="fas fa-floppy-disk"></i> Valider le dépassement
          </button>
          <button type="button" class="btn btn-danger" @click.prevent="refuserPointage()">
            <i class="fas fa-close"></i> Refuser
          </button>
        </form>
        <b-alert  v-if="parseInt(pointage.est_valide)==1" variant="success" show>Depassement accepter</b-alert>
        <b-alert  v-if="parseInt(pointage.est_valide)==3" variant="danger" show>Depassement refuser</b-alert>
      </template>
      <form v-if="isManquant() && !pointage.fin_realise" @submit.prevent="addPointageFin()">
        <p >Rajouter un pointage de fin manuellement</p>
        <div class="form-row">
          <div class="form-group col-6">
            <input type="text" class="form-control" :value="pointage.debut_realise" disabled>
          </div>
          <div class="form-group col-6">
            <input type="time" class="form-control" v-model="fin" required>
          </div>
        </div>
        <button type="submit" class="btn btn-sm mt-2 btn-success">
          <i class="fa-solid fa-save"></i> Rajouter
        </button>
      </form>
      <form v-if="isManquant() && !pointage.debut_realise" @submit.prevent="addPointageDebut()">
        <p >Rajouter un pointage de debut manuellement</p>
        <div class="form-row">
          <div class="form-group col-6">
            <input type="text" class="form-control" :value="getDate(pointage.debut_prevu)" disabled>
          </div>
          <div class="form-group col-6">
            <input type="time" class="form-control" v-model="debut" required>
          </div>
        </div>
        <button type="submit" class="btn btn-sm mt-2 btn-success">
          <i class="fa-solid fa-save"></i> Rajouter
        </button>
      </form>
    </template>
    <template v-else>
      <b-alert v-if="pointage.etats=='NON_PREVU'" show variant="danger">POINTAGE NON PREVUS</b-alert>
    </template>


  </b-overlay>
</template>
<script>
import $ from 'jquery'
import moment from "moment/moment";
import traitePointage, {traitePointage1} from "@/libs/utils";

export default {
  name: 'Pointage',
  props: ['identifiant'],
  data () {
    return {
      typesabscences:[],
      key:0,
      errors: [],
      employe: [],
      pointage: {},
      isLoading: false,
      user:{},
      debut:'',
      fin:'',
      form: {
        user_id: 0,
        code: '',

      },
      abscence_libelle: '',
      abscence_user_id: '',
      abscence_motif: '',
      abscence_debut: '',
      abscence_fin: '',
      abscence_file:'',
      abscence_type:'',
      hs:0,
      hsBase:0,
      hsInFaction:0,
      hsHorsFaction:0,

    }
  },
  async created () {

    this.isLoading = true
    try{
      let traitement=await traitePointage1(this.identifiant)
      this.pointage=traitement.pointage
      this.hs=traitement.hs
      this.hsInFaction=traitement.hsInFaction
      this.hsHorsFaction=traitement.hsHorsFaction
      this.hsBase=traitement.hsBase
      console.log('voici le pointage',this.pointage)
    }
    catch (e) {

    }

    this.isLoading = false



  },
  mounted() {
    this.getTypesabscences()


  },
  methods: {
    isVariable(){
      let response=false
      try{
        let actual=this.typesabscences.filter(data=>parseInt(data.id)==parseInt(this.abscence_type))
        actual=actual[0]
        response=actual.variable_id==1
      }catch (e) {

      }
      return response

    },
    getTypesabscences () {
      this.axios.get('/api/typesabscences').then((response) => {
        this.typesabscences = response.data
      })
    },
    volumePrevu(){
     let volume=0;
     if(this.pointage.debut_prevu && this.pointage.fin_prevu ){
        volume= moment(this.pointage.fin_prevu,'YYYY-MM-DD H:m:s').unix()- moment(this.pointage.debut_prevu,'YYYY-MM-DD H:m:s').unix()
        volume=volume/60
         if(volume<0){
           volume=0
         }
     }
     return volume

    },
    volumeRealise(){
     let volume=0;
     if(this.pointage.debut_realise && this.pointage.fin_realise ){
       volume= moment(this.pointage.fin_realise,'YYYY-MM-DD H:m:s').unix()- moment(this.pointage.debut_realise,'YYYY-MM-DD H:m:s').unix()
        volume=volume/60
       if(volume<0){
         volume=0
       }
     }
     return volume

    },
    async getPointages(id){
      let that=this
      this.axios.get('/api/pointages/id/' + id,{
      })
        .then(response => {
          this.isLoading = false
          let myPointage={}
          if(Array.isArray(response.data) && response.data.length>=0){
            myPointage = response.data[0]
          }else if(Array.isArray(response.data) && response.data.length == 0){
            myPointage = {}
          }else{
            myPointage = response.data
          }
          this.pointage=myPointage



          this.isLoading = false


        }).catch(error => {
        this.pointage=myPointage
        console.error(error)
        this.errors = error.response.data.errors
        this.isLoading = false
      })
     this.$store.commit('setPointage',this.pointage)

     // this.$store.state.pointages[id]=this.pointage
     try{
       let traitement=await traitePointage1(id)
       this.pointage=traitement.pointage
       this.hs=traitement.hs
       this.hsInFaction=traitement.hsInFaction
       this.hsHorsFaction=traitement.hsHorsFaction
       this.hsBase=traitement.hsBase
     }
     catch (e) {

     }

    },
    justifier () {
      // alert('on veut justifier')
      this.isLoading = true
      console.log('this',this.data,this.pointage)
      this.isLoading = true
      let id=0;
      if(Array.isArray(this.data) && this.data.length>=0){
        id=this.data[0].id
      }
      let senData={}
      senData.user_id=this.pointage.user.id
      senData.libelle= this.abscence_libelle,
      senData.raison= this.abscence_motif,
      senData.debut= this.abscence_debut,
      senData.fin= this.abscence_fin,
      senData.typesabscence_id= this.abscence_type

      try{
        let abscencesSelectioner=this.typesabscences.filter(data=>parseInt(data.id)==parseInt(this.abscence_type))
        // console.log('voici les abscences selctionner ==>',abscencesSelectioner)

         abscencesSelectioner=abscencesSelectioner[0]
        let nbrs=0;
        if(abscencesSelectioner.variable_id==2){
          nbrs=parseInt(abscencesSelectioner.nombrejours)
          senData.debut= this.pointage.debut_prevu
          senData.fin= moment(this.pointage.debut_prevu,'YYYY-MM-DD H:m:s').add(nbrs,'days').format('YYYY-MM-DD HH:m:ss')
        }

      }catch (e) {

      }

      console.log('sendData',senData)


      this.axios.post('/api/abscences',  senData,{

      }).then(response => {
        this.isLoading = true
        let senData={}
        senData.est_valide=2
        this.axios.post('/api/pointages/' + this.pointage.id + '/update', senData).then(response => {
          this.isLoading = false

           try{
          let data={}
          if(Array.isArray(response.data) && response.data.length>=0){
            data = response.data[0]
          }else if(Array.isArray(response.data) && response.data.length == 0){
            data = {}
          }else{
            data = response.data
          }
          this.$store.state.pointages[data.id]=data
        }catch (e) {
          console.error(e)

        }
          this.getPointage(this.identifiant)
        })
          .catch(error => {
          console.error(error)
          this.errors = error.response.data.errors
          this.isLoading = false
        })

      }).catch(error => {
        console.error(error)
        this.errors = error.response.data.errors
        this.isLoading = false
      })
    },
    isAbscence(){
      let vide=0;
      if(!this.pointage.debut_realise){
        vide++
      }
      if(!this.pointage.fin_realise){
        vide++
      }
      return vide==2 &&( this.pointage.debut_prevu && this.pointage.fin_prevu )
    },
    isManquant(){
      let vide=0;
      if(!this.pointage.debut_realise){
        vide++
      }
      if(!this.pointage.fin_realise){
        vide++
      }
      return vide==1
    },
    isNormal(){
      let vide=0;
      if(!this.pointage.debut_realise){
        vide++
      }
      if(!this.pointage.fin_realise){
        vide++
      }
      return this.pointage.etats!="NON_PREVU" || (this.pointage.etats=="NON_PREVU" && vide < 1)
    },
    isTraiter(){
      let result=false

      if (parseInt(this.pointage.est_valide)==1){
        result=true
      }
      if (parseInt(this.pointage.est_valide)==2){
        result=true
      }
      if (parseInt(this.pointage.est_valide)==3){
        result=true
      }
      return result
    },
    isDepassement(){
      return  this.hs>0
    },
    valider () {
      this.isLoading = true
      this.pointage.est_valide = '1'
      this.axios.post('/api/pointages/' + this.pointage.id + '/update', this.pointage).then(response => {
        this.isLoading = false



         try{
          let data={}
          if(Array.isArray(response.data) && response.data.length>=0){
            data = response.data[0]
          }else if(Array.isArray(response.data) && response.data.length == 0){
            data = {}
          }else{
            data = response.data
          }
          this.$store.state.pointages[data.id]=data
        }catch (e) {
          console.error(e)

        }
        this.getPointage(this.identifiant)
      }).catch(error => {
        console.error(error)
        this.errors = error.response.data.errors
        this.isLoading = false
      })
    },
    getTacheLibelle (data) {
      if (data) return data
      else return ''
    },
    toHoursAndMinutes(totalMinutes) {
      const hours = Math.floor(totalMinutes / 60);
      const minutes = totalMinutes % 60;

      return `${this.padToTwoDigits(hours)}H:${this.padToTwoDigits(minutes.toFixed(0))}`;
    },
    padToTwoDigits(num) {
      return num.toString().padStart(2, '0');
    },
    isException(){
      let vide=0;
      let calcul=0
      try{
        if(!this.pointage.debut_realise){
          vide++
        }
        if(!this.pointage.fin_realise){
          vide++
        }

        let  volumeRealise = this.pointage.volume_realise
        volumeRealise = volumeRealise.replace('m','')
        volumeRealise = volumeRealise.split('h')
        volumeRealise =parseInt(volumeRealise[0].trim())*60+parseInt(volumeRealise[1].trim())
        let  volumePrevu = this.pointage.volume_prevu
        volumePrevu = volumePrevu.replace('m','')
        volumePrevu = volumePrevu.split('h')
        console.log('voici le volume prevu',volumePrevu)
        volumePrevu =parseInt(volumePrevu[0].trim())*60+parseInt(volumePrevu[1].trim())
        calcul = volumeRealise -volumePrevu
        if(calcul<0){
          calcul=0
        }
      }catch (e) {

      }

      return vide==1 || calcul>0
    },
    editLine () {
      this.isLoading = true
      this.pointage.est_valide = '1'
      this.axios.post('/api/pointages/' + this.pointage.id + '/update', this.pointage).then(response => {
        this.isLoading = false
        $('#refreshcalendrier').click()

        $('#close_modal_exception' + this.pointage.id).click()
      }).catch(error => {
        console.error(error)
        this.errors = error.response.data.errors
        this.isLoading = false
      })
    },
    getDate (datetime) {
      return moment(String(datetime)).format('YYYY-MM-DD')
    },
    ecartDiff (prevu, realise) {
      const toHoursAndMinutes = function (totalMinutes){
        const hours = Math.floor(totalMinutes / 60);
        const minutes = totalMinutes % 60;

        return `${padToTwoDigits(hours)}H:${padToTwoDigits(minutes.toFixed(0))}`;
      }
      const padToTwoDigits=function (num) {
        return num.toString().padStart(2, '0');
      }
      if ((prevu) && (realise)) {
        let  volumeRealise = realise
        volumeRealise = volumeRealise.replace('m','')
        volumeRealise = volumeRealise.split('h')
        volumeRealise =parseInt(volumeRealise[0].trim())*60+parseInt(volumeRealise[1].trim())
        let  volumePrevu = prevu
        volumePrevu = volumePrevu.replace('m','')
        volumePrevu = volumePrevu.split('h')
        console.log('voici le volume prevu',volumePrevu)
        volumePrevu =parseInt(volumePrevu[0].trim())*60+parseInt(volumePrevu[1].trim())
        let calcul = volumeRealise -volumePrevu
        if(calcul<0){
          calcul=0
        }

        return toHoursAndMinutes(calcul)
      }
    },
    refuserPointage () {
      this.isLoading = true
      this.pointage.est_valide = '3'
      this.axios.post('/api/pointages/' + this.pointage.id + '/update', this.pointage).then(response => {
        this.isLoading = false
         try{
          let data={}
          if(Array.isArray(response.data) && response.data.length>=0){
            data = response.data[0]
          }else if(Array.isArray(response.data) && response.data.length == 0){
            data = {}
          }else{
            data = response.data
          }
          this.$store.state.pointages[data.id]=data
        }catch (e) {
          console.error(e)

        }
        this.getPointage(this.identifiant)
      }).catch(error => {
        console.error(error)
        this.errors = error.response.data.errors
        this.isLoading = false
      })
    },
    addPointageDebut () {
      this.isLoading = true
      const dateDebut = this.pointage.debut_prevu.split(' ')
      const nouveauPointage = dateDebut[0] + ' ' + this.debut + ':00'
      let reel=moment(nouveauPointage)
      let prevu =moment(this.pointage.debut_prevu)
      this.pointage.debut_reel=nouveauPointage
      this.pointage.debut_realise=nouveauPointage
      if(prevu.isAfter(reel)){
        this.pointage.debut_realise=this.pointage.debut_prevu

      }
      this.axios.post('/api/pointages/' + this.pointage.id + '/update', this.pointage).then(response => {
        this.isLoading = false
         try{
          let data={}
          if(Array.isArray(response.data) && response.data.length>=0){
            data = response.data[0]
          }else if(Array.isArray(response.data) && response.data.length == 0){
            data = {}
          }else{
            data = response.data
          }
          this.$store.state.pointages[data.id]=data
        }catch (e) {
          console.error(e)

        }
        this.getPointage(this.identifiant)

      }).catch(error => {
        console.error(error)
        this.errors = error.response.data.errors
        this.isLoading = false
      })
    },
    addPointageFin () {
      this.isLoading = true
      const dateFin = this.pointage.fin_prevu.split(' ')
      const nouveauPointage = dateFin[0] + ' ' + this.fin + ':00'
      this.pointage.fin_realise=nouveauPointage
      this.axios.post('/api/pointages/' + this.pointage.id + '/update', this.pointage).then(response => {
        this.isLoading = false
         try{
          let data={}
          if(Array.isArray(response.data) && response.data.length>=0){
            data = response.data[0]
          }else if(Array.isArray(response.data) && response.data.length == 0){
            data = {}
          }else{
            data = response.data
          }
          this.$store.state.pointages[data.id]=data
        }catch (e) {
          console.error(e)

        }
        this.getPointage(this.identifiant)
      }).catch(error => {
        console.error(error)
        this.errors = error.response.data.errors
        this.isLoading = false
      })
    },
    async getPointage (id) {
      this.isLoading = true
      try{
        let traitement=await traitePointage1(id)
        this.pointage=traitement.pointage
        this.hs=traitement.hs
        this.hsInFaction=traitement.hsInFaction
        this.hsHorsFaction=traitement.hsHorsFaction
        this.hsBase=traitement.hsBase
        console.log('voici le pointage',this.pointage)
      }
      catch (e) {

      }

      this.isLoading = false
      // this.axios.get('api/pointages/id/' + id).then(response => {
      //   console.log('voici la reponse quand je recupere le pointage ',response.data)
      //   this.isLoading = false
      //   this.pointage = response.data[0]
      //   this.$store.state.pointages[id]=this.pointage
      //   this.key++
      // }).catch(error => {
      //   this.errors = error.response.data.errors
      //   this.isLoading = false
      // })
    }
  }
}
</script>
<style>
.row{
  padding:5px;
}
</style>
