<template>
  <b-overlay :show="isLoading">

    <div :key="getHs()">
      <button v-if="getHs() >0 " class="btn btn-success" style="padding:2px!important">
        {{ toHoursAndMinutes(getHs() * 60) }}
      </button>
      <button v-else class="btn btn-secondary" style="padding:2px!important">
        {{ toHoursAndMinutes(getHs() * 60) }}
      </button>

    </div>
  </b-overlay>

</template>

<script>

export default {
  name: "ventilationsHoraires",
  props: ['programme', 'agentsOccuper', 'type', 'allPointages'],
  data() {
    return {
      isLoading: false,
      pointage: {},
      hs: 0,
      hsBase: 0,
      hsInFaction: 0,
      hsHorsFaction: 0,
      hs15: 0,
      hs30: 0,
      hs115: 0,
      hs60: 0,
      hs130: 0,
      hs26: 0,
      hs55: 0,
      vp: 0,
      allPointage: []

    }
  },
   computed: {$routeData:function(){let router = {meta:{}};try{router=window.routeData}catch (e) {};return router; },
        routeData:function () {
            let router={meta:{}}
            if(window.router){
                try{ router=window.router; }catch (e) { }
            }


            return router
        },},
  mounted() {
    this.isLoading = true
    this.isLoading = false
    this.allPointage = this.allPointages.filter(elements => {
      return elements !== null;
    }).map(data => parseInt(data))
    // console.log('voici les pointages envoyer', this.allPointages)
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
    getSpecifiHoraires(heure) {

      return this.toHoursAndMinutes(heure * 60)

    },
    toHoursAndMinutes(totalMinutes) {
      const hours = Math.floor(totalMinutes / 60);
      const minutes = totalMinutes % 60;

      return `${this.padToTwoDigits(hours)}H:${this.padToTwoDigits(minutes.toFixed(0))}`;
    },
    padToTwoDigits(num) {
      return num.toString().padStart(2, '0');
    },
    getHs() {

      let hs0 = 0;
      let vp = 0;
      let vr = 0;
      let hs15 = 0;
      let hs30 = 0;
      let hs115 = 0;
      let hs60 = 0;
      let hs130 = 0;
      let hs26 = 0;
      let hs55 = 0;
      this.allPointages.forEach(data => {
        // // console.log('Voici les pointages traiter ==>',data)
        let _horaire = ''
        let _etats = ''
        let _hs = 0
        let _vp = 0
        let _vr = 0
        let _hsInFaction = 0
        let _hsHorsFaction = 0
        let _hsBase = 0
        let est_valide = false
        try {
          _hs = data.hs
        } catch (e) {
        }
        try {
          _vp = data.vp
        } catch (e) {
        }
        try {
          _vr = data.vr
        } catch (e) {
        }
        try {
          est_valide = parseInt(data.pointage.est_valide) === 1
        } catch (e) {
        }
        try {
          _hsInFaction = est_valide ? data.hsInFaction : 0
        } catch (e) {
        }
        try {
          _hsHorsFaction = est_valide ? data.hsHorsFaction : 0
        } catch (e) {
        }
        try {
          _hsBase = data.hsBase
        } catch (e) {
        }
        try {
          _horaire = data.horaire
        } catch (e) {
        }
        try {
          _etats = data.pointage.etats
        } catch (e) {
        }
        // // console.log('est')
        // je retire les heures sup pourvoir les ajouter en fonction des regles de remplissage
        _vr -= _hs
        vr += _vr

        if (!est_valide) {
          _hsBase = 0
          _hsInFaction = 0
          _hsHorsFaction = 0
        }

        vr += _hsBase;
        if (vr <= 40) {
          _hsBase = 0
        }
        vr += _hsInFaction;
        if (vr <= 40) {
          _hsInFaction = 0
        }
        vr += _hsHorsFaction;
        if (vr <= 40) {
          _hsHorsFaction = 0
        }


        // hs0 += _hsBase + _hsInFaction + _hsHorsFaction
        hs0 += _hs
        vp += _vp

        if (vr < 40) {

        }


        hs15 += _hsBase;
        if (hs15 >= 8) {
          _hsBase = hs15 - 8
          hs15 = 8
        } else {
          _hsBase = 0
        }
        hs15 += _hsInFaction;
        if (hs15 >= 8) {
          _hsInFaction = hs15 - 8
          hs15 = 8
        } else {
          _hsInFaction = 0
        }
        hs15 += _hsHorsFaction;
        if (hs15 >= 8) {
          _hsHorsFaction = hs15 - 8
          hs15 = 8
        } else {
          _hsHorsFaction = 0
        }

        if (_horaire == 'Feries') {
          hs60 += _hsBase + _hsInFaction
          hs130 += _hsHorsFaction

        } else if (_horaire == "Repos") {
          vp -= _vp
          hs30 += _hsBase + _hsInFaction;
          hs115 += _hsHorsFaction;
        } else {
          let totalHeureSup = _hsBase + _hsInFaction
          hs15 += totalHeureSup
          if (hs15 > 8) {
            hs26 += hs15 - 8
            hs15 = 8
          }
          if (hs15 >= 8) {
            hs55 += _hsHorsFaction
          }


        }


      })
      if (vr < 40) {
        hs0 = 0
        hs15 = 0
        hs26 = 0
        hs30 = 0
        hs55 = 0
        hs115 = 0
        hs60 = 0
        hs130 = 0
        hs26 = 0
      }

      // if (hs15 >= 8) {
      //   hs15 = 8
      // }
      // hs26 = hs26 - 8
      // if (hs26 < 0) {
      //   hs26 = 0
      // }

      this.vp = vp;
      this.vr = vr;
      this.hs = hs0;
      this.hs15 = hs15;
      this.hs30 = hs30;
      this.hs115 = hs115;
      this.hs60 = hs60;
      this.hs130 = hs130;
      this.hs26 = hs26;
      this.hs55 = hs55;


      let retour = this.hs
      if (parseInt(this.type) == 15) {
        retour = this.hs15

      }
      if (parseInt(this.type) == 26) {
        retour = this.hs26

      }
      if (parseInt(this.type) == 30) {
        retour = this.hs30

      }
      if (parseInt(this.type) == 115) {
        retour = this.hs115

      }
      if (parseInt(this.type) == 60) {
        retour = this.hs60

      }
      if (parseInt(this.type) == 130) {
        retour = this.hs130

      }
      if (parseInt(this.type) == 126) {
        retour = this.hs126

      }
      if (parseInt(this.type) == 55) {
        retour = this.hs55

      }
      if (parseInt(this.type) == 0) {
        retour = this.hs15 + this.hs26 + this.hs55 + this.hs30 + this.hs115 + this.hs60 + this.hs130

      }
      if (parseInt(this.type) == -1) {
        retour = this.vp
      }
      if (parseInt(this.type) == -2) {
        retour = this.vr
      }


      return retour
    }
  }
}
</script>

<style scoped>


</style>
