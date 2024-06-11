<template>
  <b-overlay :show="isLoading">

    <div v-if="horaires=='Repos'">


      <button class="btn btn-success" style="padding:2px!important">
        <span class="depassement">
         Repos
        </span>

      </button>


    </div>
    <div v-else>

      <button v-if="isDepassement() && isTraiter() " class="btn btn-success" style="padding:2px!important">
        <span class="depassement">
               <i v-if="parseInt(this.pointage.est_valide)==1" class="fa-solid fa-circle-check"></i>
        <i v-if="parseInt(this.pointage.est_valide)==3" class="fa-solid fa-circle-xmark"></i>
        {{ getSpecifiHoraires() }}
        </span>

      </button>
      <button v-else-if="isDepassement() && !isTraiter() " class="btn btn-danger" style="padding:2px!important">
        {{ getSpecifiHoraires() }}
      </button>
      <button v-else-if="isAbscence() && isTraiter() " class="btn btn-success" style="padding:2px!important">
        {{ getSpecifiHoraires() }}
      </button>
      <button v-else-if="isAbscence() && !isTraiter() " class="btn btn-danger" style="padding:2px!important">
        {{ getSpecifiHoraires() }}
      </button>
      <button v-else-if="isManquant() " class="btn btn-warning" style="padding:2px!important">
        {{ getSpecifiHoraires() }}
      </button>
      <button v-else class="btn btn-success" style="padding:2px!important">
        {{ getSpecifiHoraires() }}
      </button>
    </div>
  </b-overlay>

</template>

<script>
import {traitePointage1} from "@/libs/utils";

export default {
  name: "ventilationsHoraires",
  props: ['pointages', 'programme', 'day', 'agentsOccuper'],
  data() {
    return {
      isLoading: false,
      type: '',
      pointage: {},
      hs: 0,
      hsBase: 0,
      hsInFaction: 0,
      hsHorsFaction: 0,
      traitement: {}

    }
  },
  async mounted() {
    this.isLoading = true
    console.log('voici le pointages', this.pointages)
    try {
      this.traitement = await traitePointage1(this.pointages)
      this.pointage = this.traitement.pointage
      this.hs = this.traitement.hs
      this.hsInFaction = this.traitement.hsInFaction
      this.hsHorsFaction = this.traitement.hsHorsFaction
      this.hsBase = this.traitement.hsBase
    } catch (e) {
    }

    this.isLoading = false


  },
   computed: {$routeData:function(){let router = {meta:{}};try{router=window.routeData}catch (e) {};return router; },
        routeData:function () {
            let router={meta:{}}
            if(window.router){
                try{ router=window.router; }catch (e) { }
            }


            return router
        },
    horaires: function () {
      let retour = this.programme[this.day + '_horaire']
      // console.log('Abscences eeror ==>',this.agentsOccuper,this.day)
      try {
        if (this.agentsOccuper[this.day + '_abscences'].includes(this.programme.user_id)) {
          retour = 'Abscens'
        } else if (this.agentsOccuper[this.day + '_conges'].includes(this.programme.user_id)) {
          retour = 'Conges'
        } else if (this.agentsOccuper[this.day + '_feries']) {
          retour = 'Feries'
        } else {
          if (this.programme[this.day + '_horaire'] === '') retour = 'Non programmer'
          else if (this.programme[this.day + '_horaire'] === '0') retour = 'Remplacé'
          else if (this.programme[this.day + '_horaire'] === '-1') retour = 'Conges'
          else if (this.programme[this.day + '_horaire'] === '-2') retour = 'Repos'
          else retour = this.programme[this.day + '_horaire']
        }
      } catch (e) {
        console.error('voici lerreur qu niveua de la selection du programme de la journee dans la ventilation ==>', e)
      }
      // // console.log('voici les agents occuper ==>', this.agentsOccuper, day,retour,programme[day+ '_horaire'])


      return retour
    },
    analyse: function () {
      let traitement = {...this.traitement, 'horaire': this.horaires}
      return {'traitement': traitement, 'pointage_id': this.pointages, 'programme_id': this.programme.id}
    },
  },
  watch: {
    'horaires': {
      handler: function (after, before) {
        // console.log('la donnes a changer ',after,before)
      },
      deep: true
    },
    'analyse': {
      handler: function (after, before) {
        // console.log('la donnes a changer apres analyse ',after,before)
        this.$emit('traitementPointages', after)
      },
      deep: true
    },
  },
  methods: {

    isAbscence() {
      let vide = 0;
      if (!this.pointage.debut_realise) {
        vide++
      }
      if (!this.pointage.fin_realise) {
        vide++
      }
      return vide == 2 && (this.pointage.debut_prevu && this.pointage.fin_prevu)
    },
    isManquant() {
      let vide = 0;
      if (!this.pointage.debut_realise) {
        vide++
      }
      if (!this.pointage.fin_realise) {
        vide++
      }
      return vide == 1
    },
    isTraiter() {
      let result = false

      if (parseInt(this.pointage.est_valide) == 1) {
        result = true
      }
      if (parseInt(this.pointage.est_valide) == 2) {
        result = true
      }
      if (parseInt(this.pointage.est_valide) == 3) {
        result = true
      }
      return result
    },
    isDepassement() {
      return this.hs > 0
    },
    getSpecifiHoraires() {

      return this.toHoursAndMinutes(this.hs * 60)

    },
    toHoursAndMinutes(totalMinutes) {
      const hours = Math.floor(totalMinutes / 60);
      const minutes = totalMinutes % 60;

      return `${this.padToTwoDigits(hours)}H:${this.padToTwoDigits(minutes.toFixed(0))}`;
    },
    padToTwoDigits(num) {
      return num.toString().padStart(2, '0');
    },
  }
}
</script>

<style scoped>
.depassement {
  display: flex;
  gap: 5px;
  justify-content: center;
  align-items: center;
}
</style>
