<template>
    <div :key="key">

        <b-overlay v-show="modal==1" :show="isLoading">
            <div class="form-row">
                <div class="form-group col-4">
                    <label>Semaine </label>
                    <input v-model="ventilation.semaine" class="form-control" disabled type="week">
                </div>
                <div class="form-group col-4">
                    <label>Tache </label>
                    <input :value="ventilation.tache.libelle" class="form-control" disabled type="text">
                </div>
                <div class="form-group col-4">
                    <label>Superviseur </label>
                    <input :value="ventilation.superviseur" class="form-control" disabled type="text">
                </div>
            </div>
            <div class="row">
        <span>Semaine du {{
                getJoursNumberFromWeek(ventilation.semaine, 'Dimanche')
            }} au {{ getJoursNumberFromWeek(ventilation.semaine, 'Samedi') }}</span>
            </div>


            <hr class="mb-3">


            <table>
                <thead style="position: sticky; top: 0; background: #d5d5d5; opacity: 1; z-index: 1000;">
                <th>
                    Agents

                </th>
                <th>
                    <p>Dimanche <br/></p>

                </th>
                <th>
                    <p>Lundi
                        <!--            <br/>{{getJoursNumberFromWeek(ventilation.semaine,'Lundi')}}-->
                    </p>
                </th>
                <th>
                    <p>Mardi
                        <!--            <br/>{{getJoursNumberFromWeek(ventilation.semaine,'Mardi')}}-->
                    </p>
                </th>
                <th>
                    <p>Mercredi
                        <!--            <br/>{{getJoursNumberFromWeek(ventilation.semaine,'Mercredi')}}-->
                    </p>
                </th>
                <th>
                    <p>Jeudi
                        <!--            <br/>{{getJoursNumberFromWeek(ventilation.semaine,'Jeudi')}}-->
                    </p>
                </th>
                <th>
                    <p>Vendredi
                        <!--            <br/>{{getJoursNumberFromWeek(ventilation.semaine,'Vendredi')}}-->
                    </p>
                </th>
                <th>
                    <p>Samedi
                        <!--            <br/>{{getJoursNumberFromWeek(ventilation.semaine,'Samedi')}}-->
                    </p>
                </th>
                <th>
                    <p>TH Prog <br/></p>
                </th>
                <th>
                    <p>TH Collect <br/></p>
                </th>
                <th>
                    <p>TH Sup <br/></p>
                </th>

                <th>
                    <p>HS 15% <br/></p>
                </th>
                <th>
                    <p>HS 26% <br/></p>
                </th>
                <th>
                    <p>HS 55% <br/></p>
                </th>
                <th>
                    <p>HS 30% <br/></p>
                </th>
                <th>
                    <p>HS 115% <br/></p>
                    <th>
                        <p>HS 60% <br/></p>
                    </th>
                    <th>
                        <p>HS 130% <br/></p>
                    </th>
                </thead>
                <tbody v-if="programmes.length > 0" class="card-body p-0">
                <tr v-for="programme in programmes" :key="`${allKey[programme.id]}`">
                    <td><span
                    >
                {{ getSpecificEmployes(employes, programme.user_id) }}
              </span></td>
                    <td @click="showDetail(programme.dimanche_pointage,programme.id)"
                    >
                        <div>
                            <ventilationsHoraires :pointages="programme.dimanche_pointage"/>
                        </div>
                    </td>
                    <td @click="showDetail(programme.lundi_pointage,programme.id)"
                    >
                        <div>
                            <ventilationsHoraires :pointages="programme.lundi_pointage"/>
                        </div>
                    </td>
                    <td @click="showDetail(programme.mardi_pointage,programme.id)"
                    >
                        <div>
                            <ventilationsHoraires :pointages="programme.mardi_pointage"/>
                        </div>
                    </td>
                    <td @click="showDetail(programme.mercredi_pointage,programme.id)"
                    >
                        <div>
                            <ventilationsHoraires :pointages="programme.mercredi_pointage"/>
                        </div>
                    </td>
                    <td @click="showDetail(programme.jeudi_pointage,programme.id)"
                    >
                        <div>
                            <ventilationsHoraires :pointages="programme.jeudi_pointage"/>
                        </div>
                    </td>
                    <td @click="showDetail(programme.vendredi_pointage,programme.id)"
                    >
                        <div>
                            <ventilationsHoraires :pointages="programme.vendredi_pointage"/>
                        </div>
                    </td>
                    <td @click="showDetail(programme.samedi_pointage,programme.id)"
                    >
                        <div>
                            <ventilationsHoraires :pointages="programme.samedi_pointage"/>
                        </div>
                    </td>
                    <td>
                        <ventilationsHs :agentsOccuper="agentsOccuper"
                                        :allPointages="getAllPointagesForProgrammes(programme)"
                                        :programme="programme" :type="-1"/>
                        <br/>
                    </td>
                    <td>
                        <ventilationsHs :agentsOccuper="agentsOccuper"
                                        :allPointages="getAllPointagesForProgrammes(programme)"
                                        :programme="programme" :type="-2"/>
                        <br/>
                    </td>
                    <td>
                        <ventilationsHs :agentsOccuper="agentsOccuper"
                                        :allPointages="getAllPointagesForProgrammes(programme)"
                                        :programme="programme" :type="0"/>
                        <br/>
                    </td>
                    <td>
                        <ventilationsHs :agentsOccuper="agentsOccuper"
                                        :allPointages="getAllPointagesForProgrammes(programme)"
                                        :programme="programme" :type="15"/>

                        <!--            {{ getHeures15(programme) }} -->
                        <br/>
                    </td>
                    <td>

                        <ventilationsHs :agentsOccuper="agentsOccuper"
                                        :allPointages="getAllPointagesForProgrammes(programme)"
                                        :programme="programme" :type="26"/>
                        <!--            {{ getHeures26(programme) }} -->
                        <br/>
                    </td>
                    <td>

                        <ventilationsHs :agentsOccuper="agentsOccuper"
                                        :allPointages="getAllPointagesForProgrammes(programme)"
                                        :programme="programme" :type="55"/>
                        <!--            {{ getHeures55(programme) }} -->
                        <br/>
                    </td>
                    <td>

                        <ventilationsHs :agentsOccuper="agentsOccuper"
                                        :allPointages="getAllPointagesForProgrammes(programme)"
                                        :programme="programme" :type="30"/>
                        <!--            {{ getHeures30(programme) }} -->
                        <br/>
                    </td>
                    <td>

                        <ventilationsHs :agentsOccuper="agentsOccuper"
                                        :allPointages="getAllPointagesForProgrammes(programme)"
                                        :programme="programme" :type="115"/>
                        <!--            {{ getHeures115(programme) }} -->
                        <br/>
                    </td>
                    <td>

                        <ventilationsHs :agentsOccuper="agentsOccuper"
                                        :allPointages="getAllPointagesForProgrammes(programme)"
                                        :programme="programme" :type="60"/>
                        <!--            {{ getHeures60(programme) }} -->
                        <br/>
                    </td>
                    <td>

                        <ventilationsHs :agentsOccuper="agentsOccuper"
                                        :allPointages="getAllPointagesForProgrammes(programme)"
                                        :programme="programme" :type="130"/>
                        <!--            {{ getHeures130(programme) }} -->
                        <br/>
                    </td>


                </tr>
                </tbody>

            </table>

            <div>


            </div>


        </b-overlay>
        <div v-show="modal==2" style="display: flex;flex-direction: column;gap:10px">

            <button id="backButton" class="btn btn-primary" @click="hideDetail()"><i class="fa-solid fa-backward"></i>
                Retour
            </button>

            <Pointage v-if="pointage" :key="modal" :identifiant="pointage"/>
            <b-alert v-if="pointage==0" show variant="danger">Aucun pointage</b-alert>


        </div>
    </div>

</template>

<script>
import $ from 'jquery'
import moment from "moment/moment";
import Pointage from "@/components/Pointage";
import ventilationsHoraires from "@/views/Ventilations/ventilationsHoraires.vue";
import ventilationsHs from "@/views/Ventilations/ventilationsHs.vue";

require('bootstrap-select')
require('select2')


export default {
    name: 'Editventilation',
    components: {Pointage, ventilationsHoraires, ventilationsHs},

    props: ['data', 'table'],
    data() {
        return {
            key: 0,
            modal: 1,
            pointage: 0,
            actualProgramme: 0,
            errors: [],
            programmeForm: 'create',
            employes: [],
            allKey: {},
            horaires: [],
            horaires1: {},
            isLoading: false,
            ventilation: [],
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
                ventilation_id: ''
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
                ventilation_id: ''
            }
        }
    },
    mounted() {
        $('.modal-dialog').css('max-width', 'none')
        $('.modal-dialog').css('width', '90%')

        // console.log('data',this.data[0])
        this.getEmployes()
        this.getHoraires()
        this.getProgrammes()
        this.hideDetail = this.hideDetail.bind(this)
        this.ventilation = this.data[0]
        let that = this

        this.agentsOccuper = this.getAgentsOccuper(this.ventilation.semaine)
        this.form.ventilation_id = this.ventilation.id


    },
    updated() {


    },
    beforeUnmount() {
        // console.log('on veut se deconnecter')
        $('.modal-dialog').css('max-width', 'none')
        $('.modal-dialog').css('width', '400px')
    },
    methods: {
        getPointages(id) {
            let that = this
            // console.log('voici le pointage 1 store ',id)

            if (this.$store.state.pointages[id]) {
                this.pointage = this.$store.state.pointages[id]
                // this.isLoading = false
            } else {
                this.axios.get('/api/pointages/id/' + id, {})
                    .then(response => {
                        // this.isLoading = false
                        let myPointage = {}
                        if (Array.isArray(response.data) && response.data.length >= 0) {
                            myPointage = response.data[0]
                        } else if (Array.isArray(response.data) && response.data.length == 0) {
                            myPointage = {}
                        } else {
                            myPointage = response.data
                        }
                        this.pointage = myPointage


                        // this.isLoading = false


                    }).catch(error => {
                    this.pointage = {}
                    console.error(error)
                    this.errors = error.response.data.errors
                    // this.isLoading = false
                })
            }
        },
        showDetail(pointage, programme_id) {
            $('.modal-title').empty()
            $('.modal-header').hide()
            let that = this
            $('.modal-dialog').css('max-width', 'none')
            $('.modal-dialog').css('width', '400px')
            this.pointage = pointage ?? 0
            this.actualProgramme = programme_id
            this.modal = 2
        },
        hideDetail() {

            $('.modal-header').show()
            $('.modal-dialog').css('max-width', 'none')
            $('.modal-dialog').css('width', '90%')
            $('.modal-title').empty()
            $('.modal-title').text("Ventilations " + this.data[0].id)
            this.getProgrammes()
            this.modal = 1
            // this.key++
            this.allKey[this.actualProgramme]++
        },
        getEmployes() {
            this.isLoading = true
            this.axios.get('/api/employes').then((response) => {
                this.employes = response.data
                // this.isLoading = false
            }).catch(error => {
                this.errors = error.response.data.errors
                // this.isLoading = false
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        validateProgramation(id) {
            this.axios.post('/ventilations/valider/' + id).then(response => {
                this.isLoading = true
                $('#close_modal_ventilation' + id).click()
                $('#refresh' + this.table).click()
                this.$toast.success('ventilation validé')
            }).catch(error => {
                console.error('error lors de la validation', error)
                this.$toast.error('Erreur survenue lors de la validation')
            })
        },
        duplicateProgramation(id) {
            this.axios.post('/ventilations/dupliquer/' + id).then(response => {
                $('#close_modal_ventilation' + id).click()
                $('#refresh' + this.table).click()
                this.$toast.success('ventilation dupliqué')
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
        toHoursAndMinutes(totalMinutes) {
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;

            return `${this.padToTwoDigits(hours)}H:${this.padToTwoDigits(minutes.toFixed(0))}`;
        },
        padToTwoDigits(num) {
            return num.toString().padStart(2, '0');
        },
        getSpecifiHoraires(programme, day) {
            // let pointages=this.ge

            const horairesForDay = this.horaires.filter(item => parseInt(item.id) === parseInt(programme[day]))
            // console.log('on veut determiner le programme en fonction du jour',programme,day)
            let hs15 = 0;
            let hs30 = 0;
            let hs115 = 0;
            let hs60 = 0;
            let hs130 = 0;
            let hs26 = 0;
            let hs55 = 0;

            let hs_base = programme[`${day}_programmer`] - 8 * 60
            if (hs_base < 0 || programme[`${day}_collecter`] < 8 * 60) {
                hs_base = 0
            }
            let depassement_collecter = this.toHoursAndMinutes(programme[`${day}_collecter`])
            let depassement_programmer = this.toHoursAndMinutes(programme[`${day}_programmer`])

            let hs_hors_base = programme[`${day}_collecter`] - 8 * 60 - hs_base
            hs_hors_base = hs_hors_base > 0 ? hs_hors_base : 0;

            // les repos
            let i = 0
            if (i === 0 && programme[day + '_pointage'] === '0' && programme.total_depassement[day]) {
                i++
                hs30 = hs_base
                hs115 = hs_hors_base
            }
            // les jours feries
            if (i == 0 && this.agentsOccuper[day + '_feries'] && programme.total_depassement[day]) {
                i++
                hs60 = hs_base
                hs130 = hs_hors_base
            }

            // les jours normal
            if (i == 0 && programme.total_depassement[day]) {
                i++
                hs55 = hs_hors_base
            }

            hs15 = hs_base
            hs26 = hs_base


            let style = "black"
            let className = ""
            if (programme[`${day}_collecter`] - programme[`${day}_programmer`] > 0) {
                style = "green"
                className = "btn btn-success"
            }


            let depassementRender = {
                className: className,
                collecter: depassement_collecter,
                programmer: depassement_programmer,
                hsbase: hs_base,
                hscollecter: hs_hors_base,
                hs_base: hs_base,
                hs_hors_base: hs_hors_base,
                hs15: hs15,
                hs30: hs30,
                hs115: hs115,
                hs60: hs60,
                hs130: hs130,
                hs26: hs26,
                hs55: hs55,
                depassement: this.toHoursAndMinutes(hs_hors_base),
            }
            return depassementRender


        },
        getSpecificEmployes(employees, userId) {
            const userSelect = employees.filter(item => item.id === parseInt(userId))

            return userSelect.length > 0
                ? userSelect[0].name
                : 'Agent'
        },
        async getHeuresSup(programme) {
            let hs15 = 0;
            let hs30 = 0;
            let hs115 = 0;
            let hs60 = 0;
            let hs130 = 0;
            let hs26 = 0;
            let hs55 = 0;


            let jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];

            for (const day of jours) {
                let hs = 0
                let hsInFaction = 0
                let hsHorsFaction = 0
                let hsBase = 0
                try {
                    // let traitement=await traitePointage1(programme[day+'_pointage'])
                    // let est_valide=parseInt(traitement.pointage.est_valide)===1
                    // hs=traitement.hs
                    // hsInFaction=est_valide?traitement.hsInFaction:0
                    // hsHorsFaction=est_valide?traitement.hsHorsFaction:0
                    // hsBase=traitement.hsBase

                } catch (e) {

                }

                if (this.agentsOccuper[day + '_feries']) {
                    hs60 += hsInFaction
                    hs130 += hsHorsFaction
                } else {
                    hs15 += hsBase + hsInFaction
                    hs30 += hsBase + hsInFaction
                    hs115 += hsHorsFaction
                }

            }

            return {
                hs15: hs15,
                hs30: hs30,
                hs115: hs115,
                hs60: hs60,
                hs130: hs130,
                hs26: hs26,
                hs55: hs55,
            }
        },
        getHeures15(programme) {
            let HS = this.getHeuresSup(programme)
            let hs = HS.hs15
            // console.log('voici les heures sup recuperer',hs)
            if (hs >= 8 * 60) {
                return this.toHoursAndMinutes(8 * 60)
            } else {
                return this.toHoursAndMinutes(hs)
            }


        },
        getHeures55(programme) {
            let HS = this.getHeuresSup(programme)
            let hs = HS.hs55
            // console.log('voici les heures sup recuperer',hs)
            return this.toHoursAndMinutes(hs)
        },
        getHeures30(programme) {
            let HS = this.getHeuresSup(programme)
            let hs = HS.hs30
            // console.log('voici les heures sup recuperer',hs)
            return this.toHoursAndMinutes(hs)
        },
        getHeures115(programme) {
            let HS = this.getHeuresSup(programme)
            let hs = HS.hs115
            // console.log('voici les heures sup recuperer',hs)
            return this.toHoursAndMinutes(hs)
        },
        getHeures60(programme) {
            let HS = this.getHeuresSup(programme)
            let hs = HS.hs60
            // console.log('voici les heures sup recuperer',hs)
            return this.toHoursAndMinutes(hs)
        },
        getHeures130(programme) {
            let HS = this.getHeuresSup(programme)
            let hs = HS.hs130
            // console.log('voici les heures sup recuperer',hs)
            return this.toHoursAndMinutes(hs)
        },
        getHeures26(programme) {
            let HS = this.getHeuresSup(programme)
            let hs = HS.hs26 - 8 * 60
            if (hs < 0) {
                hs = 0
            }
            return this.toHoursAndMinutes(hs)


        },
        replaceLine() {
            this.isLoading = true
            this.axios.post('/api/ventilationsActionRemplacer', this.form2).then(response => {
                // this.axios.post('/api/ventilations/action?action=remplacer', this.form2).then(response => {
                // this.isLoading = false
                $('#refresh-agents').click()
                this.$toast.success('Programme remplacé')
                for (const key in this.form2) {
                    this.form2[key] = ''
                }
                this.form2.ventilation_id = this.ventilation.id
                this.programmeForm = 'create'
                this.state = 'LISTING'
            }).catch(error => {
                this.errors = error.response.data.errors
                // this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        getHoraires() {
            this.axios.get('/api/horaires/tache_id/' + this.data[0].tache_id).then((response) => {
                this.horaires = response.data

            })
        },
        getProgrammes() {
            this.isLoading = true
            this.axios.get('/api/ventilations/programmation_id/' + this.data[0].id).then((response) => {
                response.data.forEach(data => {
                    this.allKey[data.id] = 0
                })
                this.programmes = response.data
                this.isLoading = false

            })
        },
        getAgentsOccuper(semaine) {
            this.axios.get('/api/congesActionAgentsDisponibles&semaine=' + semaine).then((response) => {
                // this.axios.get('/api/conges/action?action=agentsDisponibles&semaine=' + semaine).then((response) => {
                this.agentsOccuper = response.data
            })
            return true
        },
        getAllPointagesForProgrammes(programme) {
            let data = [];
            let jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche']
            for (let i = 0; i < jours.length; i++) {
                try {
                    data.push(programme[jours[i] + '_pointage'])
                } catch (e) {

                }
            }
            return data

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
                ventilation_id: programme.ventilation_id
            }
        },
        deleteProgramme(id) {
            this.isLoading = true
            this.axios.post('/api/programmes/' + id + '/delete').then(response => {
                // this.isLoading = false
                $('#refresh-agents').click()
                this.$toast.success('Programme retiré')
            }).catch(error => {
                this.errors = error.response.data.errors
                // this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
        canShowProgramme(id) {
            return this.state === 'LISTING' || this.actual === id
        },
        canShowAdminButton(ventilation) {
            return ventilation.statut !== 'Terminé' && this.state === 'LISTING'
        },
        annuler() {
            this.state = 'LISTING'
            this.programmeForm = 'create'
            this.actual = 0
            for (const [key, value] of Object.entries(this.form)) {
                this.form[key] = ''
                // console.log(value)
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
            $('#close_modal_ventilation' + this.ventilation.id).click()
        }
    }
}
</script>

<style>
@import "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"

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
    /*color:#28a745*/

}

.ventilation_horaires {
    display: flex;
    flex-direction: column;
    text-align: center;
}

th {
    text-align: center;
}

td {
    /*border-right: 1px dashed black;*/
    /*border-left: 1px dashed black;*/
}
</style>
