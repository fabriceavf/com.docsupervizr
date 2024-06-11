<template>
    <div>
        <b-modal :id="formId" :size="formWidth">
            <template #modal-title>
                <div v-if="formState=='showDetailDay'">Details</div>
            </template>

            <div v-if="formState=='showDetailDay'">
                {{ programmes.id }}
                <DetailDaysView
                    :key="programmes.id"
                    :data="programmes"
                    @refresh="refresh"
                ></DetailDaysView>

            </div>


            <template #modal-footer>
                <div></div>
            </template>
        </b-modal>
        <b-overlay :show="isLoading">
            <template>
                <div :style="style" disabled @click="detailDay()">
                    <span> {{ resultat }} </span>

                </div>
                test

            </template>


        </b-overlay>

    </div>


</template>

<script>
import DetailDaysView from "./../Programmations/DetailDaysView.vue";
import moment from "moment";
import {getPointageState} from '@/libs/utils.js'

export default {
    name: 'CalculHS',
    components: {DetailDaysView},
    props: [],
    data() {
        return {
            formId: "programmations",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            status: 'non',
            isLoading: false,
            cloturer: false
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
        programmes: function () {


            let programmes = []
            try {
                this.params.dates.forEach(data => {
                    let _programmes = this.params.data.programmes.filter(ele => {
                        let _date = ele.date.split(' ')[0]
                        return _date == data
                    })
                    programmes.push(_programmes[0])
                })

            } catch (e) {
            }
            console.log('voici le programmes actual dans les calculHs', programmes)

            return programmes
        },
        thp: function () {
            let retour = 0
            this.programmes.forEach(data => {
                let debutPrevu = moment(data.debut_prevu, 'YYYY-MM-DD H:m:s').unix()
                let finPrevu = moment(data.fin_prevu, 'YYYY-MM-DD H:m:s').unix()
                retour += (finPrevu - debutPrevu) / 60
            })


            return retour
        },
        thc: function () {
            let retour = 0
            this.programmes.forEach(data => {
                let etat = getPointageState(data)
                switch (etat) {
                    case 'DEPASSEMENTNONTRAITER':
                        retour += data.volume_horaire - data.hs_in_faction - data.hs_hors_faction
                        break;
                    case 'DEPASSEMENTREFUSER':
                        retour += data.volume_horaire - data.hs_in_faction - data.hs_hors_faction
                        break;
                    default:
                        retour += data.volume_horaire

                }

            })
            retour = retour * 60


            return retour
        },
        ths: function () {
            let retour = 0
            this.programmes.forEach(data => {
                if (data.DayStatut != 'feries' && data.DayStatut != 'conges' && data.DayStatut != 'repos') {
                    let etat = getPointageState(data)
                    switch (etat) {
                        case 'DEPASSEMENTACCEPTER':
                            retour += data.hs_in_faction
                            break;
                        case 'ABSCENCESJUSTIFIER':
                            retour += data.hs_in_faction
                            break;
                        default:
                    }
                }

            })
            if (this.thc < 40 * 60) {
                retour = 0
            }
            retour = retour * 60
            return retour
        },
        thsHorsFaction: function () {
            let retour = 0
            this.programmes.forEach(data => {
                if (data.DayStatut != 'feries' && data.DayStatut != 'conges' && data.DayStatut != 'repos') {
                    let etat = getPointageState(data)
                    switch (etat) {
                        case 'DEPASSEMENTACCEPTER':
                            retour += data.hs_hors_faction
                            break;
                        case 'ABSCENCESJUSTIFIER':
                            retour += data.hs_hors_faction
                            break;
                        default:
                    }
                }

            })
            if (this.thc < 40 * 60) {
                retour = 0
            }
            retour = retour * 60
            return retour
        },
        thsFeriesInFaction: function () {
            let retour = 0
            this.programmes.forEach(data => {
                if (data.DayStatut == 'feries') {
                    let etat = getPointageState(data)
                    switch (etat) {
                        case 'DEPASSEMENTACCEPTER':
                            retour += data.hs_in_faction
                            break;
                        case 'ABSCENCESJUSTIFIER':
                            retour += data.hs_in_faction
                            break;
                        default:
                    }
                }

            })
            retour = retour * 60
            return retour
        },
        thsFeriesHorsFaction: function () {
            let retour = 0
            this.programmes.forEach(data => {
                if (data.DayStatut == 'feries') {
                    let etat = getPointageState(data)
                    switch (etat) {
                        case 'DEPASSEMENTACCEPTER':
                            retour += data.hs_hors_faction
                            break;
                        case 'ABSCENCESJUSTIFIER':
                            retour += data.hs_hors_faction
                            break;
                        default:
                    }
                }

            })
            retour = retour * 60
            return retour
        },
        thsCongesInFaction: function () {
            let retour = 0
            this.programmes.forEach(data => {
                if (data.DayStatut == 'conges') {
                    let etat = getPointageState(data)
                    switch (etat) {
                        case 'DEPASSEMENTACCEPTER':
                            retour += data.hs_in_faction
                            break;
                        case 'ABSCENCESJUSTIFIER':
                            retour += data.hs_in_faction
                            break;
                        default:
                    }
                }

            })
            retour = retour * 60
            return retour
        },
        thsCongesHorsFaction: function () {
            let retour = 0
            this.programmes.forEach(data => {
                if (data.DayStatut == 'conges') {
                    let etat = getPointageState(data)
                    switch (etat) {
                        case 'DEPASSEMENTACCEPTER':
                            retour += data.hs_hors_faction
                            break;
                        case 'ABSCENCESJUSTIFIER':
                            retour += data.hs_hors_faction
                            break;
                        default:
                    }
                }

            })
            retour = retour * 60
            return retour
        },
        thsReposInFaction: function () {
            let retour = 0
            this.programmes.forEach(data => {
                if (data.DayStatut == 'repos') {
                    let etat = getPointageState(data)
                    switch (etat) {
                        case 'DEPASSEMENTACCEPTER':
                            retour += data.hs_in_faction
                            break;
                        case 'ABSCENCESJUSTIFIER':
                            retour += data.hs_in_faction
                            break;
                        default:
                    }
                }

            })
            retour = retour * 60
            return retour
        },
        thsReposHorsFaction: function () {
            let retour = 0
            this.programmes.forEach(data => {
                if (data.DayStatut == 'repos') {
                    let etat = getPointageState(data)
                    switch (etat) {
                        case 'DEPASSEMENTACCEPTER':
                            retour += data.hs_hors_faction
                            break;
                        case 'ABSCENCESJUSTIFIER':
                            retour += data.hs_hors_faction
                            break;
                        default:
                    }
                }

            })
            retour = retour * 60
            return retour
        },
        hs15: function () {
            let hs = this.ths + this.thsHorsFaction
            let retour = 8 * 60
            if (hs < 8 * 60) {
                retour = hs
            }


            return retour
        },
        hs26: function () {
            let retour = 0
            let hs = this.ths + this.thsHorsFaction
            try {
                retour = hs - this.hs15
            } catch (e) {

            }


            return retour
        },
        hs55: function () {
            let retour = 0
            retour = retour * 60
            return retour
        },
        hs30: function () {
            let retour = 0
            this.programmes.forEach(data => {

                let etat = getPointageState(data)
                switch (etat) {
                    case 'DEPASSEMENTACCEPTER':
                        if (this.thc > 40 * 60) {
                            retour += data.hs_hors_faction + data.hs_in_faction
                        }
                        break;
                    case 'ABSCENCESJUSTIFIER':
                        if (this.thc > 40 * 60) {
                            retour += data.hs_hors_faction + data.hs_in_faction
                        }
                        break;
                    default:
                }
            })
            retour = retour * 60


            return retour
        },
        hs115: function () {
            let retour = 0
            this.programmes.forEach(data => {
                if (data.DayStatut == 'repos' || data.DayStatut == 'feries') {
                    let etat = getPointageState(data)
                    switch (etat) {
                        case 'DEPASSEMENTNONTRAITER':
                            retour += data.volume_horaire - data.hs_in_faction - data.hs_hors_faction
                            break;
                        case 'DEPASSEMENTREFUSER':
                            retour += data.volume_horaire - data.hs_in_faction - data.hs_hors_faction
                            break;
                        default:
                            retour += data.volume_horaire
                    }
                }

            })
            retour = retour * 60

            return retour
        },
        hs60: function () {
            let retour = 0
            this.programmes.forEach(data => {

                let etat = getPointageState(data)
                switch (etat) {
                    case 'DEPASSEMENTACCEPTER':
                        if (this.thc > 40 * 60) {
                            retour += data.hs_hors_faction + data.hs_in_faction
                        }
                        break;
                    case 'ABSCENCESJUSTIFIER':
                        if (this.thc > 40 * 60) {
                            retour += data.hs_hors_faction + data.hs_in_faction
                        }
                        break;
                    default:
                }
            })
            retour = retour * 60


            return retour
        },
        hs130: function () {
            let retour = 0
            this.programmes.forEach(data => {

                let etat = getPointageState(data)
                switch (etat) {
                    case 'DEPASSEMENTACCEPTER':
                        if (this.thc > 40 * 60) {
                            retour += data.hs_hors_faction + data.hs_in_faction
                        }
                        break;
                    case 'ABSCENCESJUSTIFIER':
                        if (this.thc > 40 * 60) {
                            retour += data.hs_hors_faction + data.hs_in_faction
                        }
                        break;
                    default:
                }
            })
            retour = retour * 60


            return retour
        },
        resultat: function () {
            let type = this.params.type
            let retour = 0

            if (type == 'THP') {
                retour = this.thp
            }
            if (type == 'THC') {
                retour = this.thc
            }
            if (type == 'THS') {
                retour = this.ths + this.thsHorsFaction + this.thsFeriesInFaction + this.thsFeriesHorsFaction + this.thsCongesInFaction + this.thsCongesHorsFaction + this.thsReposInFaction + this.thsReposHorsFaction

            }
            if (type == 'HS15') {
                retour = this.hs15

            }
            if (type == 'HS26') {
                retour = this.hs26

            }

            if (type == 'HS55') {
                retour = this.hs55

            }
            if (type == 'HS30') {
                retour = this.thsReposInFaction

            }
            if (type == 'HS115') {
                retour = this.thsReposHorsFaction

            }
            if (type == 'HS60') {
                retour = +this.thsFeriesInFaction

            }
            if (type == 'HS130') {
                retour = this.thsFeriesHorsFaction

            }


            return this.toHoursAndMinutes(retour)
        },
        isPresent: function () {
            return this.pointages.length > 1

        },
        volumeHoraire: function () {
            let volume = 0;
            try {
                volume = (this.programmes.hs_in_faction + this.programmes.hs_hors_faction) * 60
            } catch (e) {
            }
            return this.toHoursAndMinutes(volume)
        },
        style: function () {
            let style = ["padding: 5px", "justify-content: center", "text-align: center", "color: #fff"]

            if (
                this.params.type == 'THP' ||
                this.params.type == 'THC' ||
                this.params.type == 'THS'
            ) {

                style.push("background: #82868b")
            } else {
                style.push("background: #69b76d")
            }
            return style.join(';')
        },
        state() {
            return getPointageState(this.programmes)

        },

    },
    watch: {
        'programmes': {
            // handler: function (after, before) {
            //     console.log('voici les params1 ==>', after, before)
            // },
            // deep: true
        },
    },
    created() {
        this.id = "ListingsTraitements" + Date.now()
        this.formId = 'CalculHS' + "_" + Date.now()


    },
    mounted() {
        console.log('calculHs ==>', this.params.dates)
    },
    methods: {
        toHoursAndMinutes(totalMinutes) {
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;

            return `${this.padToTwoDigits(hours)}H:${this.padToTwoDigits(minutes.toFixed(0))}`;
        },
        padToTwoDigits(num) {
            return num.toString().padStart(2, '0');
        },
        btnClickedHandler() {
            this.params.clicked(this.params.data);
        },
        addPresence() {
            this.isLoading = true
            let data = {}
            data.user_id = this.params.data.id_user
            data.date_id = this.params.data.id_date
            data.presence = 'oui'
            this.axios.post('/api/listingsetatsActionPresence', data)
                // this.axios.post('/api/listingsetats/action?action=presence', data)
                .then(response => {
                    this.status = 'oui'
                })
                .finally(() => {
                    this.isLoading = false
                })
        },
        addAbscence() {

            this.isLoading = true
            let data = {}
            data.user_id = this.params.data.id_user
            data.date_id = this.params.data.id_date
            data.presence = 'non'
            this.axios.post('/api/listingsetatsActionPresence', data)
                // this.axios.post('/api/listingsetats/action?action=presence', data)
                .then(response => {
                    this.status = 'non'
                })
                .finally(() => {
                    this.isLoading = false
                })
        },
        canAdmin() {
            // fonction utiliser pour verifier si je peux encore changer le status dun agent
            return this.params.etats == 'manuel'
        },
        closeForm() {
            this.tableKey++
        },
        openCreate() {
            this.showForm('showDetailDay', {}, this.gridApi)
        },
        refresh() {
            this.params.refresh()
        },
        detailDay() {
            console.log('voici les pointage ===>', this.pointages)
            this.showForm('showDetailDay', {}, this.gridApi)
        },
        showForm(type, data, gridApi, width = 'lg') {
            this.formKey++
            this.formWidth = width
            this.formState = type
            this.formData = data
            this.formGridApi = gridApi
            this.$bvModal.show(this.formId)
        },
    }
}
</script>
<style>
.danger {
    padding: 5px;
    background: #dc8282;

    justify-content: center;
    text-align: center;
    color: #fff;
    /*border-radius: 5px;*/
}

.present {

    /*border-radius: 5px;*/
}
</style>
