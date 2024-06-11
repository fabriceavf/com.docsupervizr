<template>
    <b-overlay :show="isLoading">
        <div :key="tableKey" class="row">
            <b-modal :id="formId" :size="formWidth">
                <template #modal-title>
                    <div v-if="formState=='Update'">Update Preuves #{{ formData.id }}</div>
                    <div v-if="formState=='Create'">Create Preuves</div>
                </template>

                <template #modal-footer>
                    <div>
                    </div>
                </template>
            </b-modal>
            <!--            <div class="col-sm-12">-->
            <!--                <div v-if="this.state=='ABSCENCESNONJUSTIFIER'" class="btn btn-warning" disabled style="width:100%">-->
            <!--                    Abscences non justifier-->
            <!--                </div>-->
            <!--                <div v-if="this.state=='ABSCENCESJUSTIFIER'" class="btn btn-danger" disabled style="width:100%">-->
            <!--                    Abscences justifier-->
            <!--                </div>-->
            <!--                <div v-if="this.state=='INCOMPLETNONTRAITER'" class="btn btn-warning" disabled style="width:100%">-->
            <!--                    Pointage a completer-->
            <!--                </div>-->
            <!--                <div v-if="this.state=='INCOMPLETTRAITER'" class="btn btn-success" disabled style="width:100%">-->
            <!--                    Pointage incomplet traiter-->
            <!--                </div>-->
            <!--                <div v-if="this.state=='DEPASSEMENTNONTRAITER'" class="btn btn-warning" disabled style="width:100%">-->
            <!--                    Depassement a traiter ({{ depassement }})-->
            <!--                </div>-->
            <!--                <div v-if="this.state=='DEPASSEMENTREFUSER'" class="btn btn-success" disabled style="width:100%">-->
            <!--                    Depassement refuser ({{ depassement }})-->
            <!--                </div>-->
            <!--                <div v-if="this.state=='DEPASSEMENTACCEPTER'" class="btn btn-success" disabled style="width:100%">-->
            <!--                    Depassement accepter ({{ depassement }})-->
            <!--                </div>-->
            <!--                <div v-if="this.state=='REPOS'" class="btn btn-success" disabled style="width:100%">-->
            <!--                    Jour de repos-->
            <!--                </div>-->
            <!--            </div>-->

            <!-- {{ FinRealiser  }}
            {{ FinReel  }} -->
            <div class="col-sm-3">
                <label>matricule </label>
                <input v-model="programme.user.matricule"
                       :class="errors.matricule ? 'programme-control is-invalid' : 'form-control'"
                       disabled>

                <div v-if="errors.matricule" class="invalid-feedback">
                    <template v-for=" error in errors.matricule"> {{ error[0] }}</template>

                </div>
            </div>
            <div class="col-sm-3">
                <label>nom </label>
                <input v-model="programme.user.nom"
                       :class="errors.nom ? 'programme-control is-invalid' : 'form-control'"
                       disabled>

                <div v-if="errors.nom" class="invalid-feedback">
                    <template v-for=" error in errors.nom"> {{ error[0] }}</template>

                </div>
            </div>
            <div class="col-sm-3">
                <label>prenom </label>
                <input v-model="programme.user.prenom"
                       :class="errors.prenom ? 'programme-control is-invalid' : 'form-control'"
                       disabled>

                <div v-if="errors.prenom" class="invalid-feedback">
                    <template v-for=" error in errors.prenom"> {{ error[0] }}</template>

                </div>
            </div>
            <div class="col-sm-3">
                <label>num_badge </label>
                <input v-model="programme.user.num_badge"
                       :class="errors.num_badge ? 'programme-control is-invalid' : 'form-control'"
                       disabled>

                <div v-if="errors.num_badge" class="invalid-feedback">
                    <template v-for=" error in errors.num_badge"> {{ error[0] }}</template>

                </div>
            </div>
            <div class="col-sm-12" style="height:10px">

            </div>
            <div class="container-fluid block-volume">
                <div class="row">
                    <div class="col-sm-5">

                        <div class="container">
                            <div class="row">

                                <div class="col-sm-12">
                                    <h3>Detail du programme</h3>
                                </div>
                                <div class="col-sm-6">
                                    <label>debut_prevu </label>
                                    <input v-model="programme.debut_prevu"
                                           :class="errors.debut_prevu ? 'programme-control is-invalid' : 'form-control'"
                                           disabled type="datetime-local">

                                    <div v-if="errors.debut_prevu" class="invalid-feedback">
                                        <template v-for=" error in errors.debut_prevu"> {{ error[0] }}</template>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>fin_prevu </label>
                                    <input v-model="programme.fin_prevu"
                                           :class="errors.fin_prevu ? 'programme-control is-invalid' : 'form-control'"
                                           disabled type="datetime-local">

                                    <div v-if="errors.fin_prevu" class="invalid-feedback">
                                        <template v-for=" error in errors.fin_prevu"> {{ error[0] }}</template>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>debut_collecter </label>
                                    <input v-model="programme.debut_realise"
                                           :class="errors.debut_realise ? 'programme-control is-invalid' : 'form-control'"
                                           disabled type="datetime-local">

                                    <div v-if="errors.debut_realise" class="invalid-feedback">
                                        <template v-for=" error in errors.debut_realise"> {{ error[0] }}</template>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>fin_collecter </label>
                                    <input v-model="programme.fin_realise"
                                           :class="errors.fin_realise ? 'programme-control is-invalid' : 'form-control'"
                                           disabled type="datetime-local">

                                    <div v-if="errors.fin_realise" class="invalid-feedback">
                                        <template v-for=" error in errors.fin_realise"> {{ error[0] }}</template>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>debut_reel </label>
                                    <input v-model="programme.debut_reel"
                                           :class="errors.debut_reel ? 'programme-control is-invalid' : 'form-control'"
                                           type="datetime-local">

                                    <div v-if="errors.debut_reel" class="invalid-feedback">
                                        <template v-for=" error in errors.debut_reel"> {{ error[0] }}</template>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>fin_reel </label>
                                    <input v-model="programme.fin_reel"
                                           :class="errors.fin_reel ? 'programme-control is-invalid' : 'form-control'"
                                           type="datetime-local">

                                    <div v-if="errors.fin_reel" class="invalid-feedback">
                                        <template v-for=" error in errors.fin_reel"> {{ error[0] }}</template>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Volume Prevu </label>
                                    <input :class="errors.fin_reel ? 'programme-control is-invalid' : 'form-control'"
                                           :value="toHoursAndMinutes(volumePrevu)"
                                           disabled
                                           type="text">
                                </div>
                                <div class="col-sm-6">
                                    <label>Volume Travailer </label>
                                    <input :class="errors.fin_reel ? 'programme-control is-invalid' : 'form-control'"
                                           :value="toHoursAndMinutes(volumeRealiser)"
                                           disabled
                                           type="text">
                                </div>
                                <div class="col-sm-12">
                                    <h3>Listes des pointages collecter</h3>
                                </div>
                                <div class="col-sm-12">
                                    <AgGridTable
                                        :key="tableKey"
                                        :cacheBlockSize="cacheBlockSize"
                                        :columnDefs="columnDefs"
                                        :extrasData="extrasData"
                                        :inCard="false"
                                        :maxBlocksInCache="maxBlocksInCache"
                                        :pagination="pagination"
                                        :paginationPageSize="paginationPageSize"
                                        :rowData="rowData"
                                        :rowModelType="rowModelType"
                                        :show-export="false"
                                        :sideBar="false"
                                        :url="url"
                                        className="ag-theme-alpine"
                                        domLayout='autoHeight'
                                        rowSelection="multiple"
                                        @gridReady="onGridReady"

                                    >
                                        <template #header_buttons>

                                        </template>

                                    </AgGridTable>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="container">
                            <div class="row">
                                <div v-if="allDatas.length>0" class="col-sm-12">
                                    <div class="col-sm-12">
                                        <h3>Traitement des horaires</h3>
                                    </div>
                                    <div class="col-sm-12" style="margin-bottom:10px">
                                        <label>Veuillez qualifier l'abscence ou le depassement </label>
                                        <CustomSelect
                                            :key="programme.typesheure"
                                            :columnDefs="['libelle']"
                                            :filter-value="typeHeure"
                                            :oldValue="programme.typesheure"
                                            :renderCallBack="(data)=>`${data.Selectlabel}`"
                                            :selectCallBack="(data)=>{programme.typesheure_id=data.id ;programme.typesheure=data; codeSelect=data.code}"
                                            :url="`${axios.defaults.baseURL}/api/typesheures-Aggrid`"
                                            filter-key="type"
                                        />
                                        <div v-if="errors.typesheure_id" class="invalid-feedback">
                                            <template v-for=" error in errors.typesheure_id"> {{ error[0] }}</template>

                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <h5>Details</h5>
                                    </div>
                                    <div class="col-sm-12">
                                        <div style="display:flex;gap:5px;padding:5px;flex-wrap:wrap">
                                            <template v-for="(horaire,key) in horairesQualifies"
                                                      v-if="horaire.length>0">
                                                <div v-if="Object.keys(libelleQualifications).includes(key)"
                                                     class="btn btn-outline-primary btn-sm"> {{ getHoraireName(key) }}
                                                    =>
                                                    {{ horaire.length * 10 / 60 }}H
                                                </div>
                                            </template>

                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <AgGridTable
                                            :key="tableKey"
                                            :cacheBlockSize="cacheBlockSize"
                                            :columnDefs="customColonnes"
                                            :createDatasource="createDatasource"
                                            :extrasData="extrasData"
                                            :inCard="false"
                                            :maxBlocksInCache="maxBlocksInCache"
                                            :pagination="pagination"
                                            :paginationPageSize="15"
                                            :rowData="rowData"
                                            :rowModelType="rowModelType"
                                            :show-export="false"
                                            :sideBar="false"
                                            :url="url"
                                            className="ag-theme-alpine"
                                            domLayout='autoHeight'
                                            rowSelection="multiple"

                                            @gridReady="onGridReady"

                                        >
                                            <template #header_buttons>

                                            </template>

                                        </AgGridTable>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>


                </div>

                <div class="d-flex justify-content-around">
                    <button class="btn btn-primary" type="submit" @click.prevent="EditLine()">
                        <i class="fas fa-floppy-disk"></i> Mettre à jour
                    </button>
                </div>
            </div>
            <!-- <template #modal-footer> -->

            <!-- </template> -->

        </div>
    </b-overlay>
</template>


<script>
import DataTable from '@/components/DataTable.vue'
import AgGridTable from "@/components/AgGridTable.vue"
import justifyAbscent from "./justifyAbscent.vue";
import addIncomplet from "./addIncomplet.vue";
import traiteDepassement from "./traiteDepassement.vue";
import DataModal from '@/components/DataModal.vue'
import moment from 'moment'
import {getPointageState} from '@/libs/utils.js'
import CustomSelect from "@/components/CustomSelect.vue";
import AgGridBtnClicked from "@/components/AgGridBtnClicked.vue";

export default {
    name: 'DetailDaysView',
    components: {
        DataTable,
        AgGridTable,
        DataModal,
        AgGridBtnClicked,
        justifyAbscent,
        addIncomplet,
        traiteDepassement,
        CustomSelect
    },
    props: ['data', 'typesabscencesData', 'formID'],
    data() {

        return {
            codeSelect: "",
            errors: [],
            form: {

                id: "",

                nom: "",

                icon: "",

                host: "",

                favicon: "",

                extra_attributes: "",

                created_at: "",

                updated_at: "",

                deleted_at: "",
            },
            isLoading: false,
            formId: "preuves",
            formState: "",
            formData: {},
            formWidth: 'lg',
            formGridApi: {},
            formKey: 0,
            tableKey: 0,
            programme: {},
            url: 'http://127.0.0.1:8000/api/transactions-Aggrid',
            table: 'transactions',
            programmesData: [],
            transactionsData: [],
            weeksData: [],
            requette: 2,
            columnDefs: null,
            rowData: null,
            gridApi: null,
            columnApi: null,
            rowModelType: null,
            pagination: true,
            paginationPageSize: 100,
            cacheBlockSize: 10,
            maxBlocksInCache: 1,
            horairesQualifies: {},
            libelleQualifications: {},
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
        volumePrevu: function () {
            let volume = 0;
            if (this.programme.debut_prevu && this.programme.fin_prevu) {
                volume = moment(this.programme.fin_prevu, 'YYYY-MM-DD H:m:s').unix() - moment(this.programme.debut_prevu, 'YYYY-MM-DD H:m:s').unix()
                volume = volume / 60
                if (volume < 0) {
                    volume = 0
                }
            }
            return volume

        },
        volumeRealiser: function () {
            let volume = 0;
            if (this.debut != "" && this.fin != "") {
                volume = moment(this.fin, 'YYYY-MM-DD H:m:s').unix() - moment(this.debut, 'YYYY-MM-DD H:m:s').unix()
                volume = volume / 60
                if (volume < 0) {
                    volume = 0
                }
            }
            return volume

        },
        depassement: function () {
            let depassement = 0;
            if (this.programme.volume_horaire) {
                depassement = this.programme.volume_horaire - 8
                if (depassement < 0) {
                    depassement = 0
                }
                depassement = depassement * 60

            }
            return this.toHoursAndMinutes(depassement)

        },
        taille: function () {
            let result = 'col-sm-12'
            if (this.filtre) {
                result = 'col-sm-9'
            }
            return result
        },
        state() {
            return getPointageState(this.programme)
        },
        extrasData: function () {
            let params = {}
            let retour = {};
            let transactionsId = [0]
            try {
                let pointages = this.programme.pointages_rattacher_auto
                transactionsId = pointages.split(',')
            } catch (e) {
                transactionsId = [0]
            }
            params['id'] = {values: transactionsId, filterType: 'set'}
            retour["baseFilter"] = params;

            return retour;
        },
        createDatasource: server => {
            return {
                getRows: params => {
                    params.success({
                        "rowData": server.allDatas,
                        "rowCount": server.allDatas.length,
                        "__allId": [],
                        "__allFilters": [],
                        "__allQuery": "",
                        "__allQueryBindings": [],
                        "startRow": 0,
                        "endRow": 100
                    });


                }
            };
        },
        allDatas: function () {
            let allData = []
            let max = (48 * 60) / 10
            for (let i = 0; i < max; i++) {
                console.log('voici les data quon as pu avoir', this.debut, this.fin)
                if (this.debut != "" && this.fin != "") {
                    let date = moment(this.programme.debut_prevu, 'YYYY-MM-DD H:m:s').set({
                        hour: 0,
                        minute: 0,
                        second: 0,
                        millisecond: 0
                    }).add(i * 10, 'minutes').unix()
                    let dateFormat = moment(this.programme.debut_prevu, 'YYYY-MM-DD H:m:s').set({
                        hour: 0,
                        minute: 0,
                        second: 0,
                        millisecond: 0
                    }).add(i * 10, 'minutes').format('DD-MM-YYYY HH') + 'H'
                    let debut = moment(this.debut, 'YYYY-MM-DD H:m:s').unix()
                    let fin = moment(this.fin, 'YYYY-MM-DD H:m:s').unix()

                    if ((date - debut) > 8 * 60 * 60 && date <= fin) {
                        let data = {
                            "id": i,
                            "bio_id": "4476813",
                            "date_format": dateFormat,
                            "first_name": null,
                        }
                        allData.push(data)
                    }

                } else {
                    let date = moment(this.programme.debut_prevu, 'YYYY-MM-DD H:m:s').set({
                        hour: 0,
                        minute: 0,
                        second: 0,
                        millisecond: 0
                    }).add(i * 10, 'minutes').unix()
                    let debut = moment(this.programme.debut_prevu, 'YYYY-MM-DD H:m:s').unix()
                    let fin = moment(this.programme.fin_prevu, 'YYYY-MM-DD H:m:s').unix()
                    if (debut <= date && date < fin) {
                        let data = {
                            "id": i,
                            "bio_id": "4476813",
                            "area_alias": "NK-359",
                            "first_name": null,
                        }
                        allData.push(data)
                    }
                }


            }
            return allData
        },
        debut: function () {
            let value = ""
            if (this.programme.debut_realise) {
                value = moment(this.programme.debut_realise).format('YYYY-MM-DD H:m:s')
                if (moment(this.programme.debut_realise, 'YYYY-MM-DD H:m:s').unix() < moment(this.programme.debut_prevu, 'YYYY-MM-DD H:m:s').unix()) {
                    value = moment(this.programme.debut_prevu).format('YYYY-MM-DD H:m:s')
                }


            }
            if (this.programme.debut_reel) {
                value = moment(this.programme.debut_reel).format('YYYY-MM-DD H:m:s')
            }
            return value;
        },
        fin: function () {
            let value = ""
            if (this.programme.fin_realise) {
                value = moment(this.programme.fin_realise).format('YYYY-MM-DD H:m:s')
            }
            if (this.programme.fin_reel) {
                value = moment(this.programme.fin_reel).format('YYYY-MM-DD H:m:s')
            }
            return value
        },
        typeHeure: function () {
            let volumePrevu = this.volumePrevu;
            let volumeRealiser = this.volumeRealiser;
            let type = "ABSCENCE";
            if (volumeRealiser > 8) {
                type = 'plus'
            } else {
                type = "moins"
            }
            return type


        },

        FinRealiser: function () {
            let value = "Pas de fin realise"
            if (this.programme.fin_realise) {
                value = moment(this.programme.fin_realise).format('DD/MM/YYYY à HH:mm')
            }

            return value
        },
        FinReel: function () {
            let value = " Pas de fin reel"
            if (this.programme.fin_reel) {
                value = moment(this.programme.fin_reel).format('DD/MM/YYYY à HH:mm')
            }
            return value
        },
        customColonnes: function () {
            let colonnes = [

                {
                    field: "id",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Date', maxWidth: 150,
                    checkboxSelection: true,

                    cellRendererSelector: params => {
                        let horaire = params.data.id
                        let date = moment(this.programme.debut_prevu, 'YYYY-MM-DD H:m:s').set({
                            hour: 0,
                            minute: 0,
                            second: 0,
                            millisecond: 0
                        }).add(horaire * 10, 'minutes').format('DD-MM-YYYY')
                        let render = `<div class="" style="width:100%;height:100%;border-radius:5px;text-align:center;cursor:pointer"> ${date}</div>`
                        return {
                            component: 'AgGridBtnClicked',
                            params: {
                                render: render
                            }
                        };
                    },
                },
                {
                    field: "id",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Debut', maxWidth: 100,

                    cellRendererSelector: params => {
                        let horaire = params.data.id
                        let debut = moment(this.programme.debut_prevu, 'YYYY-MM-DD H:m:s').set({
                            hour: 0,
                            minute: 0,
                            second: 0,
                            millisecond: 0
                        }).add(horaire * 10, 'minutes').format('HH:mm')
                        let render = `<div class="" style="width:100%;height:100%;border-radius:5px;text-align:center;cursor:pointer">${debut} H</div>`
                        return {
                            component: 'AgGridBtnClicked',
                            params: {
                                render: render
                            }
                        };
                    },
                },
                {
                    field: "id",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Fin', maxWidth: 100,

                    cellRendererSelector: params => {
                        let horaire = params.data.id
                        let fin = moment(this.programme.debut_prevu, 'YYYY-MM-DD H:m:s').set({
                            hour: 0,
                            minute: 0,
                            second: 0,
                            millisecond: 0
                        }).add((horaire + 1) * 10, 'minutes').format('HH:mm')
                        let render = `<div class="" style="width:100%;height:100%;border-radius:5px;text-align:center;cursor:pointer"> ${fin} H</div>`
                        return {
                            component: 'AgGridBtnClicked',
                            params: {
                                render: render
                            }
                        };
                    },
                },
            ];
            if (this.$routeData.meta.typeHeures) {
                this.$routeData.meta.typeHeures.forEach((data) => {
                    if (data.type == this.typeHeure) {
                        this.libelleQualifications[data.code] = data.libelle
                        let donne = {
                            field: null,
                            filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                            headerName: data.code,
                            maxWidth: 100,
                            cellRendererSelector: params => {
                                let horaire = params.data.id
                                let qualification = data.code
                                let oldHoraires = [];
                                if (Object.keys(this.horairesQualifies).includes(qualification)) {
                                    oldHoraires = this.horairesQualifies[qualification]
                                } else {
                                    oldHoraires = []
                                }

                                console.log('voici les params dans la cellule', params)
                                oldHoraires.map((h) => parseInt(h))
                                let render = `<div class="" style="width:100%;height:100%;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-regular fa-square"></i></div>`

                                if (oldHoraires.includes(horaire)) {
                                    render = `<div class="" style="width:100%;height:100%;color:green;border-radius:5px;text-align:center;cursor:pointer">  <i class="fa-solid fa-square"></i></div>`

                                }
                                return {
                                    component: 'AgGridBtnClicked',
                                    params: {
                                        clicked: field => {
                                            console.log('voici les params', params, field)
                                            this.qualifieHoraire(field.id, data.code)
                                            params.api.applyServerSideTransaction({
                                                update: [
                                                    params.data
                                                ],
                                            });
                                        },
                                        render: render
                                    }
                                };
                            },
                        }
                        colonnes.push(donne)
                    }

                })
            }
            return colonnes
        }
    },
    watch: {
        'routeData': {
            handler: function (after, before) {
                this.gridApi.setFilterModel(null)
                this.gridApi.refreshServerSide()
            },
            deep: true
        },
        'codeSelect': {
            handler: function (after, before) {
                if (after != "-1") {
                    let horaires = {}
                    try {
                        let heures = []
                        this.allDatas.forEach((data) => heures.push(data.id))
                        let data = {}
                        data[this.codeSelect] = heures
                        horaires = data

                    } catch (e) {
                        horaires = {}
                    }
                    this.horairesQualifies = horaires;
                    this.tableKey++;
                }

            },
            deep: true
        },
    },
    created() {

        this.programme = this.data;
        this.url = this.axios.defaults.baseURL + '/api/transactions-Aggrid';
        this.formId = this.table + "_" + Date.now()
        this.rowBuffer = 0;
        this.rowModelType = 'serverSide';
        this.cacheBlockSize = 50;
        this.maxBlocksInCache = 2;


    },
    beforeMount() {


        this.columnDefs =
            [
                {
                    field: "terminal_alias",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Source',
                    maxWidth: 100
                },
                {
                    field: "punch_time",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'Pointages',
                },
                {
                    field: "card_no",
                    sortable: true,
                    filter: 'agTextColumnFilter', filterParams: {suppressAndOrCondition: true,},
                    headerName: 'badge',
                },
            ];
        let qualifications = [
            {
                code: 'HS15',
                libelle: 'HS 15'
            },
            {
                code: 'HS20',
                libelle: 'HS 20'
            },
            {
                code: 'HS35',
                libelle: 'HS 35'
            },
            {
                code: 'HS45',
                libelle: 'HS 45'
            }
        ]


    },
    mounted() {

        if (this.requette > 0) {
        }
        if (this.data.qualification_horaire) {
            this.horairesQualifies = JSON.parse(this.data.qualification_horaire)

        }
        // Convertir la date retournée en un objet moment
        const selectedDate = moment(this.data.date, 'YYYY-MM-DD');
        // Obtenir le premier jour de la semaine
        const firstDayOfWeek = selectedDate.clone().startOf('isoWeek');
        // Créer un tableau pour stocker les jours de la semaine
        const daysOfWeek = [];
        // Boucler pour ajouter chaque jour de la semaine au tableau
        for (let i = 0; i < 7; i++) {
            daysOfWeek.push(firstDayOfWeek.clone().add(i, 'days'));
        }
        // Stocker les jours de la semaine dans this.weeksData
        this.weeksData = daysOfWeek;
        console.log('horairesQualifies', this.weeksData, this.weeksData[2].format('YYYY-MM-DD'));

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
        closeForm() {
            this.tableKey++
        },
        openCreate() {
            this.showForm('Create', {}, this.gridApi)
        },
        showForm(type, data, gridApi, width = 'lg') {
            this.formKey++
            this.formWidth = width
            this.formState = type
            this.formData = data
            this.formGridApi = gridApi
            this.$bvModal.show(this.formId)
        },
        onGridReady(params) {
            console.log('on demarre', params)
            this.gridApi = params.api;
            this.columnApi = params.columnApi;
            this.isLoading = false
        },
        refreshData() {
            this.isLoading = true
            // alert('on veut refresh')
            this.axios.get('/api/programmes/id/' + this.programme.id).then((response) => {
                this.isLoading = false
                this.tableKey++
                this.programme = response.data[0]

                console.log('voici la nouvelle donnees recu ==>', this.programme)

            }).catch(error => {
                this.isLoading = false
                console.log(error.response.data)
                this.$toast.error('Erreur survenue lors de la récuperation')
            })

            this.$emit('refresh')
        },
        qualifieHoraire(horaire, qualification) {
            this.codeSelect = "-1"
            this.programme.typesheure = null
            this.programme.typesheure_id = 10000000
            console.log('one veut qualifier lhoraire', qualification, horaire)
            let oldHoraires = [];
            let newHoraires = [];
            if (Object.keys(this.horairesQualifies).includes(qualification)) {

                oldHoraires = this.horairesQualifies[qualification]
            } else {
                oldHoraires = []
            }

            oldHoraires.map((h) => parseInt(h))
            if (oldHoraires.includes(horaire)) {
                newHoraires = oldHoraires.filter((h) => parseInt(horaire) != parseInt(h))
            } else {
                newHoraires = [...oldHoraires, horaire]
            }

            newHoraires.map((h) => parseInt(h))
            this.horairesQualifies[qualification] = newHoraires;
            this.horairesQualifies = structuredClone(this.horairesQualifies)
            this.$emit('horaires-qualifies-updated', this.horairesQualifies)
            console.log('one veut qualifier lhoraire', qualification, horaire, oldHoraires, newHoraires, this.horairesQualifies)
        },
        getHoraireName(code) {
            let name = code;
            if (Object.keys(this.libelleQualifications).includes(code)) {
                name = this.libelleQualifications[code]
            }
            return name
        },
        EditLine() {


            console.log('this.programmes', this.programme)

            this.isLoading = true
            this.programme.qualification_horaire = this.horairesQualifies
            this.axios.post('/api/programmes/' + this.programme.id + '/update', this.programme).then(response => {
                this.isLoading = false
                this.newProgrammes = true,
                    this.programme = response.data
                this.$bvModal.hide(this.formID)

                this.$emit('refresh')
                this.$emit('close')
                this.$toast.success('effectuer avec success')

            }).catch(error => {
                this.errors = error.response.data.errors
                this.isLoading = false
                this.$toast.error('Erreur survenue lors de l\'enregistrement')
            })
        },

    }
}
</script>
<style>
.detail-agent {
    display: flex;
    justify-content: center;
    flex-direction: column;
    text-align: center;
    gap: 10px;
    margin: 10px;
}

.block-volume {
    padding: 10px;
    border: 2px dashed rgb(221, 221, 221);
    margin: 20px;
    border-radius: 5px;
}
</style>
