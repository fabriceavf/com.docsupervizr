<template>
    <b-overlay :show="isLoading">
        <div :key="getHs()">


        </div>
    </b-overlay>

</template>

<script>
import moment from "moment";
import traitePointage from "@/utils";
import {mapState} from "vuex";

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
    computed: {
        $routeData: function () {
            let router = {meta: {}};
            try {
                if (typeof window.routeData != 'undefined') {
                    router = window.routeData
                }
            } catch (e) {
            }

            return router;
        },
        ...mapState({
            pointages: (state) => state.pointages,
            personnal: function () {
                let point = Object.values(this.pointages)
                let that = this
                return point.filter(function (data) {
                    // // console.log('on veut filtrer ==>',data.programme_id,that.programme.id)
                    return that.allPointage.includes(data.id)
                })

            }
        })

    },
    mounted() {
        this.isLoading = true
        this.isLoading = false
        this.allPointage = this.allPointages.filter(elements => {
            return elements !== null;
        }).map(data => parseInt(data))
        // console.log('voici les pointages ', this.allPointage)
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
            for (let i = 0; i < this.personnal.length; i++) {

                let _hs = 0
                let _vp = 0
                let _vr = 0
                let _hsInFaction = 0
                let _hsHorsFaction = 0
                let _hsBase = 0
                try {
                    let traitement = traitePointage(this.personnal[i])
                    let est_valide = parseInt(traitement.pointage.est_valide) === 1
                    _hs = traitement.hs
                    _vp = traitement.vp
                    _vr = traitement.vr
                    _hsInFaction = est_valide ? traitement.hsInFaction : 0
                    _hsHorsFaction = est_valide ? traitement.hsHorsFaction : 0
                    _hsBase = traitement.hsBase

                } catch (e) {

                }
                // hs0 += _hsBase + _hsInFaction + _hsHorsFaction
                hs0 += _hs
                vp += _vp
                vr += _vr

                let day = moment(this.personnal[i].debut_prevu, 'YYYY-MM-DD H:m:s').locale('fr').format('dddd')
                console.log('voici le jour', day, this.agentsOccuper[day + '_feries'])

                if (this.agentsOccuper[day + '_feries']) {
                    hs60 += _hsBase + _hsInFaction
                    hs130 += _hsHorsFaction

                } else if (this.personnal[i].etats == "NON_PREVU") {
                    hs30 += _hsBase + _hsInFaction;
                    hs115 += _hsHorsFaction;
                } else {
                    hs15 += _hsBase + _hsInFaction
                    hs26 += _hsBase + _hsInFaction
                    hs55 += _hsHorsFaction
                }


            }
            if (hs15 >= 8) {
                hs15 = 8
            }
            hs26 = hs26 - 8
            if (hs26 < 0) {
                hs26 = 0
            }

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
                retour = this.hs

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
