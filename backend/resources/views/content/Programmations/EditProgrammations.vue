<template>
    <b-overlay :show="isLoading">

        <!--        Details-->
        <div class="row">
            <div class="col-sm-12 row">

                <!-- <div v-if="!this.$routeData.meta.isProgrammations" class="form-group  col-sm">
                    <label>faction</label>
                    <input v-model="form.faction" :class="errors.faction ? 'form-control is-invalid' : 'form-control'"
                           disabled type="text">

                    <div v-if="errors.faction" class="invalid-feedback">
                        <template v-for=" error in errors.faction"> {{ error[0] }}</template>

                    </div>
                </div> -->
                <div class="form-group col-sm">
                    <label v-if="!this.$routeData.meta.isProgrammations">date </label>
                    <label v-if="this.$routeData.meta.isProgrammations">date_debut </label>
                    <input v-model="DateListing"
                           :class="errors.date_debut ? 'form-control is-invalid' : 'form-control'" disabled type="date">

                    <div v-if="errors.date_debut" class="invalid-feedback">
                        <template v-for=" error in errors.date_debut"> {{ error[0] }}</template>

                    </div>
                </div>
                <div v-if="this.$routeData.meta.isProgrammations" class="form-group col-sm">
                    <label>date_fin </label>
                    <input v-model="form.date_fin" :class="errors.date_fin ? 'form-control is-invalid' : 'form-control'"
                           disabled type="date">

                    <div v-if="errors.date_fin" class="invalid-feedback">
                        <template v-for=" error in errors.date_fin"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="form-group col-sm-2">
                    <label v-if="!this.$routeData.meta.isProgrammations">valideur 1</label>
                    <label v-if="this.$routeData.meta.isProgrammations">Superviseur </label>
                    <CustomSelect :key="form.valideur_1" :columnDefs="['nom', 'prenom', 'matricule']" :disable="true"
                                  :oldValue="form.valideur1" :renderCallBack="(data) => `${data.Selectlabel}`"
                                  :selectCallBack="(data) => form.valideur_1 = data.id"
                                  :url="`${axios.defaults.baseURL}/api/users-Aggrid`" filter-key="" filter-value=""
                                  placeHolder=" Pas encore valider "/>
                    <div v-if="errors.valideur_1" class="invalid-feedback">
                        <template v-for=" error in errors.valideur_1"> {{ error[0] }}</template>
                    </div>
                    <small class="form-text text-muted">{{ potentielValideur1() }}</small>
                </div>
                <div class="form-group col-sm ">
                    <button v-if="this.$routeData.meta.validation1 ||
        this.$routeData.meta.validation2
        " :disabled="form.valider1 || form.valider2" class="col-sm-12 mt-2 btn btn-primary " type="button"
                            @click.prevent="Validation1()">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ valider1Text }}
                    </button>

                    <button v-if="this.$routeData.meta.validation" :disabled="true"
                            class="col-sm-12 mt-2 btn btn-primary " type="button" @click.prevent="Validation1()">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ valider1Text }}
                    </button>
                </div>
                <div v-if="!this.$routeData.meta.isProgrammations" class="form-group col-sm-2">
                    <label>valideur 2</label>
                    <CustomSelect :key="form.valideur_2" :columnDefs="['nom', 'prenom', 'matricule']" :disable="true"
                                  :oldValue="form.valideur2" :renderCallBack="(data) => `${data.Selectlabel}`"
                                  :selectCallBack="(data) => form.valideur_2 = data.id"
                                  :url="`${axios.defaults.baseURL}/api/users-Aggrid`" filter-key="" filter-value=""
                                  placeHolder=" Pas encore valider "/>
                    <div v-if="errors.valideur_2" class="invalid-feedback">
                        <template v-for=" error in errors.valideur_2"> {{ error[0] }}</template>
                    </div>

                    <small class="form-text text-muted">{{ potentielValideur2() }}</small>
                </div>
                <div class="form-group col-sm ">

                    <button v-if="this.$routeData.meta.validation1 ||
        this.$routeData.meta.validation2
        " :disabled="!form.valider1 || form.valider2" class="col-sm-12 mt-2 btn btn-primary" type="button"
                            @click.prevent="Validation2()">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ valider2Text }}
                    </button>


                    <button v-if="this.$routeData.meta.validation" :disabled="true"
                            class="col-sm-12 mt-2 btn btn-primary" type="button" @click.prevent="Validation2()">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ valider2Text }}
                    </button>
                </div>
                <!-- <div v-if="!this.$routeData.meta.isProgrammations" class="form-group col-sm">
                    <label>type de listings </label>
                    <v-select v-model="form.typelistings" :options="validationsData" disabled label="Selectlabel" />
                    <input v-model="form.typelistings" class="form-control" required type="text"/>
                </div> -->
                <!-- <div v-if="!this.$routeData.meta.isProgrammations" class="form-group col-sm">
                    <label>postes baladeur </label>
                    <CustomSelect :key="form.postesbaladeur" :columnDefs="['libelle']" :oldValue="form.postesbaladeur"
                        :renderCallBack="(data) => `${data.Selectlabel}`"
                        :selectCallBack="(data) => form.postesbaladeur = data.id"
                        :url="`${axios.defaults.baseURL}/api/postes-Aggrid`" filter-key="type"
                        filter-value="baladeur" />
                    <div v-if="errors.postesbaladeur" class="invalid-feedback">
                        <template v-for=" error in errors.postesbaladeur"> {{ error[0] }}</template>

                    </div>
                </div> -->
                <div v-if="this.$routeData.meta.isProgrammations" class="form-group col-sm">
                    <label>taches </label>
                    <CustomSelect :key="form.tache" :columnDefs="['libelle']" :disable="true" :oldValue="form.tache"
                                  :renderCallBack="(data) => `${data.Selectlabel}`"
                                  :selectCallBack="(data) => form.tache_id = data.id"
                                  :url="`${axios.defaults.baseURL}/api/taches-Aggrid`" filter-key="" filter-value=""/>
                    <div v-if="errors.tache_id" class="invalid-feedback">
                        <template v-for=" error in errors.tache_id"> {{ error[0] }}</template>

                    </div>
                </div>
                <div v-if="this.$routeData.meta.isProgrammations" class="form-group col-sm">
                    <label>libelle </label>
                    <input v-model="form.libelle" :class="errors.libelle ? 'form-control is-invalid' : 'form-control'"
                           type="text">

                    <div v-if="errors.libelle" class="invalid-feedback">
                        <template v-for=" error in errors.libelle"> {{ error[0] }}</template>

                    </div>
                </div>
                <div v-if="this.$routeData.meta.isProgrammations" class="form-group col-sm">
                    <label>statut </label>
                    <input v-model="form.statut" :class="errors.statut ? 'form-control is-invalid' : 'form-control'"
                           disabled type="text">

                    <div v-if="errors.statut" class="invalid-feedback">
                        <template v-for=" error in errors.statut"> {{ error[0] }}</template>

                    </div>
                </div>
                <div class="form-group col-sm ">
                    <button class=" col-sm-12 mt-2 btn btn-primary " type="button" @click.prevent="launchImpression()">
                        <i class="fa-solid fa-print"></i>
                        Imprimer
                    </button>
                </div>
                <div class="form-group col-sm ">
                    <button class=" col-sm btn btn-primary mt-2" type="button" @click="EditLine()">
                        <i class="fas fa-floppy-disk"></i> Mettre à jour
                    </button>
                </div>
                <div class="form-group col-sm ">
                    <button class=" col-sm-12 mt-2 btn btn-danger " type="button" @click.prevent="DeleteLine()">
                        <i class="fas fa-close"></i> Archiver
                    </button>
                </div>

            </div>
            <div class="col-2" style="margin: 5px;">


                <!-- <div class="form-group  ">
                    <label>description </label>
                    <input type="text" :class="errors.description ? 'form-control is-invalid' : 'form-control'"
                           v-model="form.description">

                    <div class="invalid-feedback" v-if="errors.description">
                        <template v-for=" error in errors.description"> {{ error[0] }}</template>

                    </div>
                </div> -->

                <!-- <div class="row">

                </div> -->


                <div class="form-group">
                    <label>postes baladeur </label>
                    <CustomSelect :key="form.postesbaladeur" :columnDefs="['libelle']" :oldValue="form.postesbaladeur"
                                  :renderCallBack="(data) => `${data.Selectlabel}`"
                                  :selectCallBack="(data) => form.postesbaladeur = data.id"
                                  :url="`${axios.defaults.baseURL}/api/postes-Aggrid`" filter-key="typeposte"
                                  filter-value="baladeur"/>
                    <div v-if="errors.postesbaladeur" class="invalid-feedback">
                        <template v-for=" error in errors.postesbaladeur"> {{ error[0] }}</template>

                    </div>
                </div>

                <div v-if="clientsData.length" class="form-group">
                    <label>clients ( {{ clientsData.length }} )</label>
                    <div id="allClientsInListings">

                        <div v-for="client in clientsData"
                             :class="clientsSelectioner.includes(client.id) ? 'btn btn-selectionner' : 'btn btn-non-selectionner'"
                             @click="selectClient(client.id)">
                            {{ client.Selectlabel }}
                        </div>
                    </div>
                </div>

                <!-- <div class="">

                    <div class="row mb-2 d-flex justify-content-between">





                    </div>
                    <div class="row d-flex justify-content-between">



                    </div>
                    <template v-if="this.$routeData.meta.isProgrammations">

                        <div v-if="!form.valider1" class="row d-flex justify-content-between mt-2">
                            <button class=" col-md-5 btn btn-primary ml-1" type="button" @click="EditLine()">
                                <i class="fas fa-floppy-disk"></i> Mettre à jour
                            </button>

                            <button :disabled="form.statut == 'valider'" class=" col-md-5 btn btn-warning ml-2"
                                type="button" @click.prevent="ValideLine()">
                                <i class="fa-solid fa-play"></i>
                                Demarrer
                            </button>

                            <button :disabled="form.statut != 'valider'" class=" col-md-5 btn btn-warning mt-2 ml-1"
                                type="button" @click.prevent="Validation1()">
                                <i class="fa-solid fa-ban"></i>
                                Cloturer
                            </button>
                        </div>
                        <div v-else class=""></div>
                    </template>
                    <template v-else class="row d-flex justify-content-between">
                        <button class=" col-md-5 btn btn-primary mt-2" type="button" @click="EditLine()">
                            <i class="fas fa-floppy-disk"></i> Mettre à jour
                        </button>
                    </template>


                </div> -->

            </div>
            <div class="col-sm" style="border-left: 2px solid #b3b3b3;">
                <template v-if="form.statut != 'valider'">
                    <div class="col-sm-12">
                        <h4>Listes des agents programmees</h4>
                        <Managesprogrammesusers :key="form.id" :data="form" :horairesData="horairesData"
                                                :usersData="form.valider1"/>
                    </div>
                </template>
                <template v-else>
                    <div v-if="periodes.length > 1">

                        <h5>Veuillez selectionnez le jour</h5>
                        <div style="display: flex;justify-content: space-around;">
                            <button v-for="date in periodes"
                                    :style="(periodesSelectionner == date) ? 'border:1px solid green' : 'border:1px solid #b3b2b2'"
                                    class="btn" @click="selectPeriode(date)">{{ date }}
                            </button>

                        </div>

                    </div>
                    <Readprogrammes
                        :key="form.id + '-' + tableKey + '-' + periodesSelectionner" :data="form" :filter="filter"
                        :horairesData="horairesData" :periode="periodesSelectionner" :poste="{id:0}"
                        :types="$routeData.meta.isProgrammations" :usersData="usersData"/>

                </template>
            </div>

        </div>

    </b-overlay>
</template>

<script>
import CustomSelect from "@/components/CustomSelect.vue";
import Files from "@/components/Files.vue"
import Managesprogrammesusers from "./Managesprogrammesusers.vue";
import Readprogrammes from "./Readprogrammes.vue";
import ReadProgrammesUsersListings from "./ReadProgrammesUsersListings.vue";
import VSelect from 'vue-select'
import StatisticCardHorizontal from '@core/components/statistics-cards/StatisticCardHorizontal.vue'
import ClientsView from "./Clients/ClientsView.vue";
import * as htmlToImage from 'html-to-image';
import moment from "moment/moment";

export default {
    name: 'EditProgrammations',
    components: {
        VSelect, CustomSelect,
        Files,
        Managesprogrammesusers,
        ClientsView,
        Readprogrammes,
        StatisticCardHorizontal,
        ReadProgrammesUsersListings
    },
    props: ['data', 'gridApi', 'modalFormId',
        'tachesData',
        'usersData',
    ],
    data() {
        return {
            errors: [],
            validationsData: [],
            isLoading: false,
            form: {
                id: "",
                libelle: "",
                description: "",
                date_debut: "",
                date_fin: "",
                tache_id: "",
                user_id: "",
                statut: "",
                extra_attributes: "",
                created_at: "",
                updated_at: "",
                deleted_at: "",
                identifiants_sadge: "",
                PresentsId: [],
                AbscentsId: [],
                Allclients: [],
                Allclients1: [],
            },
            horairesData: [],
            DateListing: null,
            filter: false,
            tableKey: 0,
            clients: '',
            clientsSelectioner: [],
            actualPeriode: '',
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
        valider1Text: function () {
            let text = " 1er etape de validation"
            if (this.form.type != 'programmations') {
                text = 'Valider 1'
            }
            return text
        },
        valider2Text: function () {
            let text = " 2eme etape de validation"

            if (this.form.type != 'programmations') {
                text = 'Valider 2'
            }
            return text

        },
        clientsData: function () {
            let data = [];
            try {
                data = this.form.Allclients.map(e => {
                    return {
                        'id': e.clientId,
                        'Selectlabel': e.clientLibelle,
                    }
                })
                data = [...new Map(data.map(item => [item['id'], item])).values()]
            } catch (e) {

            }
            console.log('voici les clients ', data)
            return data;
        },
        postesData: function () {
            let countClient = 0;
            try {
                countClient = this.form.Allclients.length
            } catch (e) {
                countClient = 0;
            }
            let data = [];
            try {
                data = this.form.Allclients.filter(e => this.clientsSelectioner.includes(e.clientId)).map(e => {
                    return {
                        'id': e.posteId,
                        'Selectlabel': e.posteLibelle,
                        'horaireId': e.horaireId,
                    }
                })
                data = [...new Map(data.map(item => [item['id'], item])).values()]
            } catch (e) {

            }

            if (data.length == 0 && countClient == 0) {
                data.push({id: 0})
            }
            return data;
        },
        periodes: function () {
            let dateA = moment(this.data.date_debut, 'YYYY-MM-DD')
            let dateB = moment(this.data.date_fin, 'YYYY-MM-DD')
            let date = [dateA.format('YYYY-MM-DD')]
            let encore = true
            let i = 0;
            let diff = dateB.diff(dateA, 'days');
            if (diff > 0) {
                while (encore) {
                    let actual = date[date.length - 1]
                    actual = moment(actual, 'YYYY-MM-DD')
                    let demain = actual.add(1, 'days')
                    console.log('voici la date  actual ==>', actual, demain.format('YYYY-MM-DD'))
                    date.push(demain.format('YYYY-MM-DD'))
                    if (dateB.diff(actual, 'days') == 0 || i == 30) {
                        encore = false
                    } else {

                        i++
                    }

                }
            }

            console.log('voici la date ==>', dateA, dateB, this.data, this.data.date_fin)
            console.log('voici la dates collecter ==>', date, i)
            return date;

        },
        periodesSelectionner: function () {

            let resultat = this.actualPeriode;
            if (resultat == '') {
                resultat = this.periodes[0]
            }
            return resultat;
        }
    },
    watch: {
        'filter': {
            handler: function (after, before) {
                this.tableKey++

            },
            deep: true

        }
    },

    mounted() {
        this.form = this.data
        this.DateListing = this.form.date_debut.split(' ')[0]
        console.log('this.DateListing', this.DateListing, this.form.date_debut);
        this.form.Allclients = []
        this.form.Allclients1 = []
        this.form['date_debut'] = this.form['date_debut'].split(' ')[0]
        this.form['date_fin'] = this.form['date_fin'].split(' ')[0]
        this.analyseData()
        this.validationsData = ["client", "interne", "operationnel"]

        this.gethoraires()
        // this.count()
    },

    methods: {
        selectPeriode(date) {
            this.actualPeriode = date
        },
        potentielValideur1() {
            let allName = []
            try {
                allName.push(this.form.user.Selectlabel)
                allName.push(this.form.user2.Selectlabel)
            } catch (e) {

            }
            return allName.join(' ou ')

        },
        potentielValideur2() {
            let allName = []
            try {
                allName.push(this.form.user3.Selectlabel)
                allName.push(this.form.user4.Selectlabel)
            } catch (e) {

            }
            return allName.join(' ou ')
        },
        analyseData() {
            this.isLoading = true
            let dataFilters = {
                "startRow": 0,
                "endRow": 100,
                "rowGroupCols": [],
                "valueCols": [],
                "pivotCols": [],
                "pivotMode": false,
                "groupKeys": [],
                "filterModel": {},
                "sortModel": [],
                'id': [this.form.id],
            }
            let that = this
            this.axios.post('/api/programmations-Aggrid', dataFilters).then(response => {
                that.form = response.data.rowData[0]
                console.log('recu', that.form)
                that.form.Allclients = JSON.parse(that.form.Allclients)
                that.form.Allclients1 = Object.keys(that.form.Allclients)
                that.form['date_debut'] = that.form['date_debut'].split(' ')[0]
                that.form['date_fin'] = that.form['date_fin'].split(' ')[0]

                console.log('recu 1', that.form)
                that.isLoading = false
            }).catch(error => {
                that.isLoading = false
            })
        },
        selectClient(clientId) {
            if (this.clientsSelectioner.includes(clientId)) {
                this.clientsSelectioner = this.clientsSelectioner.filter(e => e != clientId)
            } else {
                this.clientsSelectioner.push(clientId)
            }
        },
        imprimer() {
            let that = this

            function filter(node) {
                return (node.tagName !== 'img');
            }

            let node = document.getElementById(`listing${this.form.id}`);
            htmlToImage.toJpeg(node, {filter: filter})
                .then(function (dataUrl) {

                    let win = window.open('');
                    win.document.write('<img src="' + dataUrl + '" onload="window.print();window.close()" />');
                    win.focus();

                })
                .catch(function (error) {
                    console.error('oops, something went wrong!', error);
                });


        },
        Validation1() {
            const today = new Date();
            const date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            const dateTime = date + ' ' + time;
            // console.log('clikk=>', dateTime)
            this.form.valider1 = dateTime
            // console.log('this.form', this.form)
            this.isLoading = true
            this.axios.post('/api/programmations/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
                // console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        Validation2() {
            const today = new Date();
            const date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            const dateTime = date + ' ' + time;
            // console.log('clikk=>', dateTime)
            this.form.valider2 = dateTime
            // console.log('this.form', this.form)
            this.isLoading = true
            this.axios.post('/api/programmations/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$emit('close')
                this.$toast.success('Operation effectuer avec succes')
                // console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        launchImpression() {
            if (this.form.type != "programmations") {
                this.Imprimer()
            } else {
                this.ImprimerProgrammation()
            }

        },
        Imprimer() {
            this.isLoading = true
            this.axios.post('/api/imprimme-listing', this.form).then(response => {
                this.isLoading = false
                window.open(response.data, "_blank");
                this.$toast.success('Operation effectuer avec succes')
            }).catch(error => {
                this.errors = error
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        ImprimerProgrammation() {
            this.isLoading = true;
            this.axios
                .post("/api/imprimme-Programmation", this.form)
                .then((response) => {
                    this.isLoading = false;
                    window.open(response.data, "_blank");
                    this.$toast.success("Operation effectuer avec succes");
                })
                .catch((error) => {
                    this.errors = error;
                    this.isLoading = false;
                    this.$toast.error(
                        "Erreur survenue lors de l'enregistrement"
                    );
                });
        },
        launchPrint(url) {
            var iframe = this._printIframe;
            if (!this._printIframe) {
                iframe = this._printIframe = document.createElement('iframe');
                document.body.appendChild(iframe);

                iframe.style.display = 'none';
                iframe.onload = function () {
                    setTimeout(function () {
                        iframe.focus();
                        iframe.contentWindow.print();
                    }, 1);
                };
            }

            iframe.src = url;
        },
        closeForm() {
            this.$bvModal.hide(this.modalFormId)
        },
        EditLine() {
            this.isLoading = true
            this.axios.post('/api/programmations/' + this.form.id + '/update', this.form).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        ValideLine() {
            this.isLoading = true
            this.axios.post('/api/programmations/' + this.form.id + '/update', {statut: 'valider'}).then(response => {
                this.isLoading = false
                this.gridApi.applyServerSideTransaction({
                    update: [
                        response.data
                    ],
                });
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },
        DeleteLine() {
            this.isLoading = true
            this.axios.post('/api/programmations/' + this.form.id + '/delete').then(response => {
                this.isLoading = false

                this.gridApi.applyServerSideTransaction({
                    remove: [
                        this.form
                    ]
                });
                this.gridApi.refreshServerSide()
                this.$bvModal.hide(this.modalFormId)
                this.$toast.success('Operation effectuer avec succes')
                this.$emit('close')
                console.log(response.data)
            }).catch(error => {
                console.log(error.response.data)
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de la suppression')
            })
        },
        DuplicateLine() {

        },
        gethoraires() {
            let filter = {
                "startRow": 0,
                "endRow": 100,
                "rowGroupCols": [],
                "valueCols": [],
                "pivotCols": [],
                "pivotMode": false,
                "groupKeys": [],
                "filterModel": {
                    "parent": {"filterType": "text", "type": "contains", "filter": "tache"},
                    "parentId": {"filterType": "text", "type": "contains", "filter": this.data.tache_id}
                },
                "sortModel": []
            }
            this.axios.post('/api/horaires-Aggrid', filter).then((response) => {
                this.requette--
                if (this.requette == 0) {
                    // // this.$store.commit('setIsLoading', false)
                }
                this.horairesData = response.data['rowData']
                console.log('=>horairesData', this.horairesData)

            }).catch(error => {
                console.log(error.response.data)
                // // this.$store.commit('setIsLoading', false)
                // this.$toast.error('Erreur survenue lors de la récuperation')
            })
        },
        checkAbscents() {

            if (!this.filter) {
                this.filter = this.form.Abscentsid
            } else {
                this.filter = false
            }
        },
        checkPresents() {
            if (!this.filter) {
                this.filter = this.form.Presentsid
            } else {
                this.filter = false
            }
        },
        count() {
            this.axios.get('/api/programmations/id/' + this.form.id).then((response) => {
                this.requette--
                if (this.requette == 0) {
                    this.$store.commit('setIsLoading', false)
                }

                //    console.log('okkkk',response.data[0].Abscents)
                this.Presents = response.data[0].Presents
                this.Abscents = response.data[0].Abscents


            }).catch(error => {
                console.log(error.response.data)
                this.$store.commit('setIsLoading', false)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })
            // alert(this.Presents)
        }
    }
}
</script>
<style>
.btn-non-selectionner {
    border: 1px solid #b5b5b5;
    width: 100%
}

.btn-selectionner {
    border: 1px solid #24a207;
    width: 100%
}

#allClientsInListings {
    max-height: 250px;
    overflow-x: scroll;
}
</style>
